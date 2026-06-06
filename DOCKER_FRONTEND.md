# Docker Frontend Build

Use this when you need `npm install`, `npm ci`, or `npm run dev` without changing your host Node/NVM version.

The container uses Node `16.20.2`, which is safer for this project's old Laravel Mix 5, Webpack 4, and Tailwind 1 stack than the host Node `v24`.

## Commands

Build the frontend container:

```powershell
docker compose -f docker-compose.frontend.yml build
```

Install dependencies using the lock file:

```powershell
docker compose -f docker-compose.frontend.yml run --rm frontend npm ci
```

If you intentionally want normal npm install instead:

```powershell
docker compose -f docker-compose.frontend.yml run --rm frontend npm install
```

Compile development assets:

```powershell
docker compose -f docker-compose.frontend.yml run --rm frontend npm run dev
```

Compile production assets:

```powershell
docker compose -f docker-compose.frontend.yml run --rm frontend npm run prod
```

Run watch mode:

```powershell
docker compose -f docker-compose.frontend.yml run --rm --service-ports frontend npm run watch
```

## Notes

- The container keeps `node_modules` in a Docker volume named `frontend_node_modules`, not in your Windows workspace.
- Generated files are still written to `public/css`, `public/js`, and `public/mix-manifest.json` through the mounted project folder.
- Prefer `npm ci` when you want reproducible installs from `package-lock.json`.
- Use this only for frontend assets. It does not fix the Laravel/PHP migration issues listed in `FEATURE_WORKFLOW.md`.
