# Jenkins Deployment Guide

This project now includes a `Jenkinsfile` for build, validation, packaging, and optional VPS deployment.

The pipeline is designed to reduce the "works locally but fails in production" problem by running these checks before deploy:

- Composer install.
- Composer validation.
- Frontend build through Docker using Node 16.
- `php artisan --version`.
- `php artisan config:clear`.
- `php artisan route:list`.
- `php artisan test`.
- Release packaging.
- Optional deploy through SSH.
- Optional public health check.

## Jenkins Agent Requirements

The Jenkins agent should have:

- Docker CLI.
- Docker Compose v2.
- Git.
- SSH client.
- `tar`.
- `curl` if you use `HEALTHCHECK_URL`.

The agent does not need host Node, npm, PHP, or Composer. The pipeline runs those through Docker containers.

## Jenkins Plugins

Recommended plugins:

- Pipeline.
- Git.
- SSH Agent.
- Workspace Cleanup.

If `cleanWs` fails because Workspace Cleanup is missing, install that plugin or remove the `cleanWs(...)` block from `post`.

## Required Jenkins Credentials

Create an SSH private key credential for your deployment server.

Suggested credential ID:

```text
plasmo-vps-ssh
```

You can use another ID, but pass it through the `SSH_CREDENTIALS_ID` Jenkins parameter.

## Server Folder Layout

The Jenkinsfile deploys to this release layout:

```text
/var/www/plasmo
+-- current -> /var/www/plasmo/releases/<build>-<commit>
+-- releases
|   +-- 12-a1b2c3d4
|   +-- 13-e5f6a7b8
+-- shared
    +-- .env
    +-- storage
```

Your web server should point to:

```text
/var/www/plasmo/current/public
```

## First-Time Server Setup

On the production server, create the base directories:

```bash
sudo mkdir -p /var/www/plasmo/shared/storage
sudo chown -R deploy:www-data /var/www/plasmo
sudo chmod -R ug+rwX /var/www/plasmo
```

Create the production env file:

```bash
nano /var/www/plasmo/shared/.env
```

Make sure the server has PHP and required extensions for your Laravel version. The deploy script runs these commands on the server:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link
php artisan queue:restart
```

## Jenkins Parameters

| Parameter | Purpose |
| --- | --- |
| `DEPLOY` | Set to `true` to deploy after build/test/package succeeds. |
| `DEPLOY_TARGET` | Label for `staging` or `production`. |
| `DEPLOY_HOST` | Server IP or domain. Required when `DEPLOY=true`. |
| `DEPLOY_USER` | SSH user. Default: `deploy`. |
| `DEPLOY_PATH` | Base app path. Default: `/var/www/plasmo`. |
| `SSH_CREDENTIALS_ID` | Jenkins SSH key credential ID. Default: `plasmo-vps-ssh`. |
| `RUN_MIGRATIONS` | Runs `php artisan migrate --force` during deployment. |
| `HEALTHCHECK_URL` | Optional URL checked after deployment. |

## Recommended First Run

Run the pipeline with:

```text
DEPLOY=false
```

This should fail right now if the Laravel migration issues listed in `FEATURE_WORKFLOW.md` still exist. That is useful: fix those failures in CI first, then deploy.

After CI is green, run a staging deployment:

```text
DEPLOY=true
DEPLOY_TARGET=staging
DEPLOY_HOST=<your-staging-ip>
RUN_MIGRATIONS=false
```

Only enable `RUN_MIGRATIONS=true` when you are ready for database changes on that target.

## Important Production Notes

- The pipeline packages `vendor` and built public assets, so production does not need to run `composer install` or `npm install`.
- The production server still needs a compatible PHP runtime and extensions.
- The production `.env` is not committed. It must live at `<DEPLOY_PATH>/shared/.env`.
- Route cache is intentionally run before switching `current`. If routes reference missing classes or methods, deployment fails before the new release goes live.
- Keep `DEPLOY=false` as your default Jenkins run while stabilizing the Laravel migration.
