pipeline {
    agent any

    environment {
        COOLIFY_API_URL  = 'http://coolify:8080/api/v1'
        COOLIFY_TOKEN    = credentials('coolify-api-token')
        COOLIFY_APP_UUID = credentials('coolify-app-uuid-plasmo')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Deploy') {
            steps {
                sh """
                    curl -sf -X POST \
                        "${COOLIFY_API_URL}/deploy" \
                        -H "Authorization: Bearer ${COOLIFY_TOKEN}" \
                        -H "Content-Type: application/json" \
                        -d '{"uuid": "${COOLIFY_APP_UUID}", "force_rebuild": true}'
                """
            }
        }
    }

    post {
        success { echo '✅ Plasmo deploy triggered successfully!' }
        failure { echo '❌ Pipeline failed.' }
        always  { cleanWs() }
    }
}
