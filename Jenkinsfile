pipeline {
    agent any

    options {
        timestamps()
        disableConcurrentBuilds()
        buildDiscarder(logRotator(numToKeepStr: '20'))
    }

    parameters {
        booleanParam(
            name: 'DEPLOY',
            defaultValue: false,
            description: 'Deploy the tested build to the configured server.'
        )
        choice(
            name: 'DEPLOY_TARGET',
            choices: ['staging', 'production'],
            description: 'Deployment label used for logs and environment selection.'
        )
        string(
            name: 'DEPLOY_HOST',
            defaultValue: '',
            description: 'Target server host or IP. Required only when DEPLOY=true.'
        )
        string(
            name: 'DEPLOY_USER',
            defaultValue: 'deploy',
            description: 'SSH user on the target server.'
        )
        string(
            name: 'DEPLOY_PATH',
            defaultValue: '/var/www/plasmo',
            description: 'Base release path on the target server.'
        )
        string(
            name: 'SSH_CREDENTIALS_ID',
            defaultValue: 'plasmo-vps-ssh',
            description: 'Jenkins SSH private key credentials ID.'
        )
        booleanParam(
            name: 'RUN_MIGRATIONS',
            defaultValue: false,
            description: 'Run php artisan migrate --force during deployment.'
        )
        string(
            name: 'HEALTHCHECK_URL',
            defaultValue: '',
            description: 'Optional public URL to check after deployment, for example https://plasmo.example.com/up.'
        )
    }

    environment {
        APP_NAME = 'plasmo'
        FRONTEND_COMPOSE_FILE = 'docker-compose.frontend.yml'
        COMPOSER_CACHE_DIR = "${WORKSPACE}/.composer-cache"
        BUILD_DIR = "${WORKSPACE}/build"
        PACKAGE_FILE = "${WORKSPACE}/build/plasmo-release.tar.gz"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
                script {
                    env.GIT_SHORT_COMMIT = sh(
                        script: 'git rev-parse --short=8 HEAD',
                        returnStdout: true
                    ).trim()
                    env.RELEASE_NAME = "${env.BUILD_NUMBER}-${env.GIT_SHORT_COMMIT}"
                }
            }
        }

        stage('Validate Docker Tooling') {
            steps {
                sh 'docker --version'
                sh 'docker compose version'
            }
        }

        stage('Install PHP Dependencies') {
            steps {
                sh '''
                    set -e
                    mkdir -p "$COMPOSER_CACHE_DIR"
                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
                        -v "$PWD":/app \
                        -v "$COMPOSER_CACHE_DIR":/tmp/composer-cache \
                        -w /app \
                        composer:2.8 \
                        composer install --no-interaction --prefer-dist --no-progress --optimize-autoloader
                '''
            }
        }

        stage('Validate Composer') {
            steps {
                sh '''
                    set -e
                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -e COMPOSER_CACHE_DIR=/tmp/composer-cache \
                        -v "$PWD":/app \
                        -v "$COMPOSER_CACHE_DIR":/tmp/composer-cache \
                        -w /app \
                        composer:2.8 \
                        composer validate --strict
                '''
            }
        }

        stage('Build Frontend Assets') {
            steps {
                sh '''
                    set -e
                    docker compose -f "$FRONTEND_COMPOSE_FILE" build
                    docker compose -f "$FRONTEND_COMPOSE_FILE" run --rm frontend npm ci
                    docker compose -f "$FRONTEND_COMPOSE_FILE" run --rm frontend npm run prod
                '''
            }
        }

        stage('Laravel Sanity Checks') {
            steps {
                sh '''
                    set -e
                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -v "$PWD":/app \
                        -w /app \
                        composer:2.8 \
                        php artisan --version

                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -v "$PWD":/app \
                        -w /app \
                        composer:2.8 \
                        php artisan config:clear

                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -v "$PWD":/app \
                        -w /app \
                        composer:2.8 \
                        php artisan route:list
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh '''
                    set -e
                    docker run --rm \
                        --user "$(id -u):$(id -g)" \
                        -v "$PWD":/app \
                        -w /app \
                        composer:2.8 \
                        php artisan test
                '''
            }
        }

        stage('Package Release') {
            steps {
                sh '''
                    set -e
                    rm -rf "$BUILD_DIR"
                    mkdir -p "$BUILD_DIR"
                    tar \
                        --exclude='./.git' \
                        --exclude='./.env' \
                        --exclude='./.env.*' \
                        --exclude='./.composer-cache' \
                        --exclude='./build' \
                        --exclude='./node_modules' \
                        --exclude='./storage/logs/*' \
                        --exclude='./storage/framework/cache/*' \
                        --exclude='./storage/framework/sessions/*' \
                        --exclude='./storage/framework/views/*' \
                        -czf "$PACKAGE_FILE" .
                    ls -lh "$PACKAGE_FILE"
                '''
                archiveArtifacts artifacts: 'build/plasmo-release.tar.gz', fingerprint: true
            }
        }

        stage('Deploy') {
            when {
                expression { return params.DEPLOY }
            }
            steps {
                script {
                    if (!params.DEPLOY_HOST?.trim()) {
                        error('DEPLOY_HOST is required when DEPLOY=true.')
                    }
                }

                sshagent(credentials: ["${params.SSH_CREDENTIALS_ID}"]) {
                    sh '''
                        set -e

                        REMOTE="${DEPLOY_USER}@${DEPLOY_HOST}"
                        REMOTE_PACKAGE="/tmp/${APP_NAME}-${RELEASE_NAME}.tar.gz"
                        RELEASE_DIR="${DEPLOY_PATH}/releases/${RELEASE_NAME}"

                        ssh -o StrictHostKeyChecking=no "$REMOTE" "mkdir -p '${DEPLOY_PATH}/releases' '${DEPLOY_PATH}/shared/storage' '${DEPLOY_PATH}/shared/bootstrap/cache'"
                        scp -o StrictHostKeyChecking=no "$PACKAGE_FILE" "$REMOTE:$REMOTE_PACKAGE"

                        ssh -o StrictHostKeyChecking=no "$REMOTE" "
                            set -e

                            if [ ! -f '${DEPLOY_PATH}/shared/.env' ]; then
                                echo 'Missing ${DEPLOY_PATH}/shared/.env on server.'
                                exit 1
                            fi

                            mkdir -p '$RELEASE_DIR'
                            tar -xzf '$REMOTE_PACKAGE' -C '$RELEASE_DIR'
                            rm -f '$REMOTE_PACKAGE'

                            rm -rf '$RELEASE_DIR/storage'
                            ln -sfn '${DEPLOY_PATH}/shared/storage' '$RELEASE_DIR/storage'
                            ln -sfn '${DEPLOY_PATH}/shared/.env' '$RELEASE_DIR/.env'

                            mkdir -p \
                                '${DEPLOY_PATH}/shared/storage/app/public' \
                                '${DEPLOY_PATH}/shared/storage/framework/cache' \
                                '${DEPLOY_PATH}/shared/storage/framework/sessions' \
                                '${DEPLOY_PATH}/shared/storage/framework/views' \
                                '${DEPLOY_PATH}/shared/storage/logs'

                            cd '$RELEASE_DIR'
                            php artisan config:cache
                            php artisan route:cache
                            php artisan view:cache
                        "

                        if [ "${RUN_MIGRATIONS}" = "true" ]; then
                            ssh -o StrictHostKeyChecking=no "$REMOTE" "cd '$RELEASE_DIR' && php artisan migrate --force"
                        fi

                        ssh -o StrictHostKeyChecking=no "$REMOTE" "
                            set -e
                            ln -sfn '$RELEASE_DIR' '${DEPLOY_PATH}/current'
                            cd '${DEPLOY_PATH}/current'
                            php artisan storage:link || true
                            php artisan queue:restart || true
                            find '${DEPLOY_PATH}/releases' -maxdepth 1 -mindepth 1 -type d | sort -r | tail -n +6 | xargs -r rm -rf
                        "
                    '''
                }
            }
        }

        stage('Health Check') {
            when {
                allOf {
                    expression { return params.DEPLOY }
                    expression { return params.HEALTHCHECK_URL?.trim() }
                }
            }
            steps {
                sh '''
                    set -e
                    curl --fail --silent --show-error --location --max-time 30 "$HEALTHCHECK_URL" > /dev/null
                '''
            }
        }
    }

    post {
        always {
            sh 'docker compose -f "$FRONTEND_COMPOSE_FILE" down --remove-orphans || true'
            cleanWs(
                deleteDirs: true,
                disableDeferredWipeout: true,
                notFailBuild: true
            )
        }
        success {
            echo "Build ${env.BUILD_NUMBER} finished successfully for ${params.DEPLOY_TARGET}."
        }
        failure {
            echo "Build ${env.BUILD_NUMBER} failed. Check the stage logs before deploying."
        }
    }
}
