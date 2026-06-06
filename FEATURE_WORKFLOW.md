# Plasmo Feature Workflow and Migration Scan

Generated from the current codebase scan on 2026-06-04. Updated after the first migration-fix pass on 2026-06-04.

## Summary

Plasmo is a Laravel web application for plasma donor coordination. The app has three main user groups:

- Guest users who read public information and register/login.
- Pencari Donor/Pasien users who submit plasma requests and search available donors or hospital stock.
- Pendonor users who register donor eligibility and view patient/request information.
- Admin users who manage users, hospitals, plasma stock, berita, and FAQ content.

The intended workflow is still recognizable. The first fix pass aligned the main route/controller/model/form wiring with the existing Blade pages and migrations, and Composer now resolves to Laravel 13 with compatible Jetstream/Fortify/Livewire packages.

Current verified checks:

- `composer validate --strict` passes.
- `php artisan --version` reports Laravel Framework `13.13.0`.
- `php artisan route:list` passes.
- `php artisan route:cache` passes.
- `php artisan view:cache` passes.
- `php artisan test` passes after clearing cached config.
- `composer audit` reports no advisories.

## Public Workflow

Guest users can access these public pages from `routes/web.php`:

| URL | View | Purpose |
| --- | --- | --- |
| `/` | `resources/views/home.blade.php` | Landing page and main call to action. |
| `/tentang-kami` | `resources/views/tentang-kami.blade.php` | About page. |
| `/stok-plasma` | `resources/views/stok-plasma.blade.php` | Public stock information page. |
| `/kontak` | `resources/views/kontak.blade.php` | Contact page. |
| `/masuk` | `resources/views/masuk.blade.php` | Custom login page posting to Fortify `login`. |
| `/daftar` | `resources/views/daftar.blade.php` | Custom register page posting to Fortify `register`. |
| `/daftar-donor` | `resources/views/daftar-donor.blade.php` | Donor registration landing page. |
| `/daftar-pendonor` | `resources/views/daftar-pendonor.blade.php` | Donor sign-up information page. |

Registration is handled by `app/Actions/Fortify/CreateNewUser.php`. It creates a user with `name`, `email`, `password`, and `role_id`.

## Authenticated User Entry

Authenticated and verified users are grouped under:

```php
Route::group([ "middleware" => ['auth:sanctum', 'verified'] ], function() {
    ...
});
```

The app also contains a role-based route group for:

- `Pencari Donor`
- `Pendonor`
- `admin`

Current role seed data creates:

| Role ID | Name |
| --- | --- |
| 1 | `Administrator` |
| 2 | `Pencari Donor` |
| 3 | `Pendonor` |

## Pencari Donor / Pasien Workflow

The intended patient flow is:

1. User registers as `Pencari Donor`.
2. User logs in.
3. User visits patient dashboard at `/dashboard`.
4. User submits a plasma request from `/permohonan`.
5. Form posts to `POST submit`, intended to call `PasienController@store`.
6. User can view donor/hospital stock through `/stok-plasma-donor`.
7. User can read FAQ and berita pages.
8. User can update password and email through patient account pages.

Main views:

| Feature | View |
| --- | --- |
| Dashboard | `resources/views/pages/pasien/dashboard.blade.php` |
| Plasma request form | `resources/views/pages/pasien/permohonan.blade.php` |
| Stock/donor list | `resources/views/pages/pasien/stok-plasma-donor.blade.php` |
| FAQ | `resources/views/pages/pasien/faq.blade.php` |
| Berita | `resources/views/pages/pasien/berita.blade.php` |
| Profile | `resources/views/pages/pasien/user-profile.blade.php` |
| Change password | `resources/views/pages/pasien/change-password.blade.php` |
| Change email | `resources/views/pages/pasien/change-email.blade.php` |

Fixed in the first migration pass:

- `resources/views/pages/pasien/permohonan.blade.php` submits old fields like `nama_pemohon`, `hotline`, `nama_pasien`, `rhesus`, `hospital`, `File_TPK`, and `jumlah_plasma`.
- `app/Http/Controllers/PasienController.php` now validates and stores those existing migration/form fields.
- The patient form now posts to the explicit `permohonan.store` route and supports file upload encoding.

## Pendonor Workflow

The intended donor flow is:

1. User registers as `Pendonor`.
2. User logs in.
3. User visits `/dashboard-pendonor`.
4. User fills donor eligibility/profile form at `/pendonor`.
5. Form posts to `POST submit`, intended to call `PendonorController@store`.
6. User can read FAQ and berita pages.
7. User can view patient/donor-related lists.
8. User can update password and email through donor account pages.

Main views:

| Feature | View |
| --- | --- |
| Dashboard | `resources/views/pages/pendonor/dashboard-pendonor.blade.php` |
| Donor form | `resources/views/pages/pendonor/pendonor.blade.php` |
| Stock page | `resources/views/pages/pendonor/stok-plasma-pendonor.blade.php` |
| Donor list | `resources/views/pages/pendonor/list-pendonor.blade.php` |
| FAQ | `resources/views/pages/pendonor/faq.blade.php` |
| Berita | `resources/views/pages/pendonor/berita.blade.php` |
| Profile | `resources/views/pages/pendonor/user-profile.blade.php` |
| Change password | `resources/views/pages/pendonor/change-password.blade.php` |
| Change email | `resources/views/pages/pendonor/change-email.blade.php` |

Fixed in the first migration pass:

- `resources/views/pages/pendonor/pendonor.blade.php` submits old fields like `nama_pendonor`, `hotline`, `NIK`, `gender`, `rhesus`, `height`, `province`, `city`, `PCR_Positive`, and `PCR_Negative`.
- `app/Http/Controllers/PendonorController.php` now validates and stores those existing migration/form fields.
- The donor form now posts to the explicit `pendonor.store` route and supports file upload encoding.
- `PendonorController@showPendonor` no longer queries the nonexistent `ready` column.

## Admin Workflow

The intended admin flow is:

1. Admin logs in with an admin role.
2. Admin visits `/dashboard-admin`.
3. Admin manages users at `/user`.
4. Admin manages hospitals and plasma stock at `/hospital`.
5. Admin manages berita at `/berita`.
6. Admin manages FAQ at `/faq`.
7. Admin can change password and email through admin account pages.

Main views:

| Feature | View |
| --- | --- |
| Admin dashboard | `resources/views/pages/user/dashboard-admin.blade.php` |
| User list | `resources/views/pages/user/user-data.blade.php` |
| User create | `resources/views/pages/user/user-new.blade.php` |
| User edit | `resources/views/pages/user/user-edit.blade.php` |
| Hospital list | `resources/views/pages/hospital/hospital-data.blade.php` |
| Hospital create | `resources/views/pages/hospital/hospital-new.blade.php` |
| Hospital edit | `resources/views/pages/hospital/hospital-edit.blade.php` |
| Berita list | `resources/views/pages/berita/berita-data.blade.php` |
| Berita create | `resources/views/pages/berita/berita-new.blade.php` |
| Berita edit | `resources/views/pages/berita/berita-edit.blade.php` |
| FAQ list | `resources/views/pages/faq/faq-data.blade.php` |
| FAQ create | `resources/views/pages/faq/faq-new.blade.php` |
| FAQ edit | `resources/views/pages/faq/faq-edit.blade.php` |

Fixed in the first migration pass:

- `routes/web.php` no longer references the missing `App\Http\Controllers\Admin\UserController`.
- `app/Http/Middleware/CheckRole.php` exists and is registered in the new Laravel bootstrap middleware aliases.
- The role middleware accepts aliases such as `admin` and maps them to the seeded `Administrator` role.
- Controllers now return the checked-in view folders such as `pages/user`, `pages/hospital`, `pages/berita`, and `pages/faq`.

## Hospital and Stock Workflow

The intended hospital stock flow is:

1. Admin opens `/hospital`.
2. Admin creates or edits hospital details.
3. Admin fills stock quantities for each blood type and rhesus combination:
   - A+
   - A-
   - B+
   - B-
   - AB+
   - AB-
   - O+
   - O-
4. Patients and donors view stock through patient/donor stock pages.

Fixed in the first migration pass:

- `HospitalController` and `Hospital` model now use `hotline` and the plasma-stock fields defined by the migrations/forms.
- `HospitalController@showHospital` and `HospitalController@showHospitalPasien` exist.
- Hospital create/edit forms now post to explicit named routes.

## Berita Workflow

The intended berita flow is:

1. Admin opens `/berita`.
2. Admin creates a berita item.
3. Admin edits or deletes berita.
4. Patients and donors read berita through their dashboard pages.

Fixed in the first migration pass:

- `BeritaController` and `Berita` model now use `judul_berita`, `isi_berita`, and `berita_photo_path`.
- `BeritaController@showBerita` exists.
- Berita create/edit forms now post to explicit named routes.

## FAQ Workflow

The intended FAQ flow is:

1. Admin opens `/faq`.
2. Admin creates a FAQ item.
3. Admin edits or deletes FAQ.
4. Patients and donors read FAQ through their dashboard pages.

Fixed in the first migration pass:

- `FaqController` and `Faq` model now use `pertanyaan` and `jawaban`.
- `FaqController@showFaq` exists.
- FAQ create/edit forms now post to explicit named routes.

## Data Model Scan

Current migrations define these business tables:

| Table | Current migration purpose |
| --- | --- |
| `users` | Auth users with Jetstream profile columns. |
| `roles` | User roles. |
| `pasien` | Plasma request/patient data. |
| `pendonor` | Donor eligibility/profile data. |
| `plasmo` | Blood stock model, currently not strongly connected to the active workflow. |
| `hospital` | Hospital data and plasma stock fields. |
| `berita` | News/article content. |
| `faq` | FAQ content. |

Fixed Eloquent table-name risk:

| Model | Laravel default table | Migration table | Risk |
| --- | --- | --- | --- |
| `Pasien` | `pasiens` | `pasien` | Fixed with `protected $table = 'pasien';`. |
| `Pendonor` | `pendonors` | `pendonor` | Fixed with `protected $table = 'pendonor';`. |
| `Hospital` | `hospitals` | `hospital` | Fixed with `protected $table = 'hospital';`. |
| `Berita` | `beritas` | `berita` | Fixed with `protected $table = 'berita';`. |
| `Faq` | `faqs` | `faq` | Fixed with `protected $table = 'faq';`. |

## Migration Health Findings

These were the main issues found during the scan and their current status.

### 1. Composer version and lock file are inconsistent

Initial state:

- `laravel/framework` `^13.0`
- `laravel/sanctum` `^4.0`

But `composer.lock` still contained Laravel 8-era Jetstream/Fortify/Livewire dependencies.

Current status: fixed. `composer.lock` now resolves Laravel Framework `v13.13.0`, Jetstream `v5.5.3`, Sanctum `v4.3.2`, and Livewire `v3.8.1`. `laravel/tinker` was removed because the available package constraint did not support Laravel 13 during the update.

### 2. Jetstream, Fortify, and Livewire are referenced but not required in composer.json

The codebase still references:

- `Laravel\Jetstream`
- `Laravel\Fortify`
- `Livewire`
- `x-jet-*` Blade components
- `<livewire:styles />` and `<livewire:scripts />`

Current status: fixed. `composer.json` now requires `laravel/jetstream`, `laravel/fortify`, and `livewire/livewire`.

### 3. Old `app/Http/Kernel.php` exists, but Laravel's new bootstrap style is also present

`bootstrap/app.php` uses the newer Laravel application configuration style. At the same time, `app/Http/Kernel.php` contains old middleware registration. In newer Laravel skeletons, middleware aliases and groups normally need to be registered through `bootstrap/app.php`.

Current status: partially fixed. The new Laravel bootstrap now registers the `role` middleware alias and the application providers list includes Fortify and Jetstream providers. `app/Http/Kernel.php` remains as legacy code and can be removed later if the app is fully committed to the Laravel 13 bootstrap style.

- `role` middleware registration.
- `auth:sanctum` and `verified` route behavior.
- `Fruitcake\Cors\HandleCors`, which is an old CORS package reference.
- `Laravel\Jetstream\Http\Middleware\AuthenticateSession`.

### 4. Required middleware class is missing

`routes/web.php` and `app/Http/Kernel.php` refer to:

```php
\App\Http\Middleware\CheckRole::class
```

Current status: fixed. `app/Http/Middleware/CheckRole.php` is present and registered.

### 5. Route references missing controller classes or methods

Initial examples:

- `App\Http\Controllers\Admin\UserController` is referenced, but no `app/Http/Controllers/Admin/UserController.php` exists.
- `HospitalController@showHospital` is referenced, but missing.
- `HospitalController@showHospitalPasien` is referenced, but missing.
- `BeritaController@showBerita` is referenced, but missing.
- `FaqController@showFaq` is referenced, but missing.

Current status: fixed for the listed routes/methods. `php artisan route:list` now passes.

### 6. Route names are duplicated

Inside the authenticated route group, several routes reuse the same route names:

- `faq`
- `berita`
- `hospital`
- `pendonor`
- `user-profile`

Current status: mostly fixed. Routes were rewritten to avoid the old duplicate names for donor/patient pages, using names such as `faq.donor`, `faq.pendonor`, `berita.donor`, and `berita.pendonor`.

### 7. Controllers, views, models, and migrations use different field names

Initial examples:

- Patient view/migration use `nama_pemohon`, `nama_pasien`, `hotline`, `rhesus`, `hospital`, `jumlah_plasma`.
- `PasienController` expects `full_name`, `phone_number`, `address`, `weight`, `plasma_status`.
- Donor view/migration use `nama_pendonor`, `hotline`, `NIK`, `rhesus`, `height`, `PCR_Positive`.
- `PendonorController` expects `full_name`, `blood_list`, `phone_number`, `address`, `plasma_status`.
- FAQ migration/views use `pertanyaan` and `jawaban`.
- FAQ controller/model use `question` and `answer`.
- Berita migration/views use `judul_berita`, `isi_berita`, `berita_photo_path`.
- Berita controller/model use `title`, `content`, `image`.
- Hospital migration/views use `hotline`.
- Hospital controller/model use `phone`, `email`, `website`, `image`.

Current status: fixed for the main patient, donor, hospital, berita, and FAQ forms/controllers/models.

### 8. View paths are inconsistent

Several controllers return views under `pages.admin.*`, but the current files are under:

- `pages/user/*`
- `pages/hospital/*`
- `pages/berita/*`
- `pages/faq/*`
- `pages/pasien/*`
- `pages/pendonor/*`

Current status: fixed for the main controller paths. Controllers now point to checked-in view folders rather than `pages.admin.*`.

Previously missing view examples included:

- `pages.admin.user`
- `pages.admin.list-hospital`
- `pages.admin.faq`
- `pages.admin.berita`
- `pages.admin.change-password`
- `pages.admin.change-email`

### 9. Helper functions may not be autoloaded

Current status: fixed. `AppServiceProvider` explicitly loads `app/Helpers/MainHelper.php`.

### 10. Frontend build stack is old, but not the main runtime blocker

`package.json` still uses Laravel Mix 5, Tailwind 1, Webpack 4, and older build scripts. This is not automatically a Laravel runtime problem because the Blade templates mostly load already-built files from `public/css`, `public/js`, `public/vendor`, and `public/stisla`.

Current runtime assets exist:

- `public/css/style.css`
- `public/css/responsive.css`
- `public/css/app.css`
- `public/css/tailwind.css`
- `public/js/app.js`
- `public/mix-manifest.json`

So if the goal is to keep the same design, the safest migration path is to keep these public assets and keep Blade references like `asset('css/style.css')`, `asset('css/tailwind.css')`, and `mix('js/app.js')`.

The old frontend stack becomes concerning mainly when rebuilding assets with `npm install`, `npm ci`, or `npm run dev`, especially on modern Node versions. This machine has Node `v24.16.0`, while the lock file is old (`lockfileVersion: 1`) and the project uses Webpack 4 via Laravel Mix 5. A Docker-based Node 16 frontend build setup has been added in `docker-compose.frontend.yml` and `DOCKER_FRONTEND.md`.

If rebuilds fail, prefer one of these paths:

1. Use an older compatible Node version such as Node 14 or 16 for this project.
2. Keep the checked-in public assets and do not rebuild unless CSS/JS source changes are needed.
3. Upgrade the build system separately to a newer Mix/Vite setup only after backend migration is stable, because that may change generated CSS/JS output.

On this Windows shell, `npm` through PowerShell is blocked by execution policy, but `npm.cmd` works. Use `npm.cmd --version`, `npm.cmd install`, and `npm.cmd run dev` if you need to run npm locally.

## Recommended Migration Stabilization Order

1. Decide the canonical database field names: keep old Indonesian migration/view fields or migrate everything to the newer English controller/model fields.
2. Fix Composer first so `composer.json`, `composer.lock`, and installed `vendor` packages agree.
3. Register only the middleware system used by the target Laravel version.
4. Restore or replace `CheckRole` middleware.
5. Fix Eloquent table names or rename tables.
6. Fix route-controller-view alignment.
7. Remove duplicate route names by using role-specific names such as `pasien.faq`, `pendonor.faq`, and `admin.faq.index`.
8. Fix form actions so patient and donor forms post to explicit named routes.
9. Add feature tests for registration, login redirect, patient request submission, donor submission, hospital CRUD, berita CRUD, and FAQ CRUD.
10. Move frontend build to Vite only if that is part of the migration target. Otherwise keep Mix intentionally and document it.

## Current Verdict

The application is much closer to a deployable Laravel 13 migration after the first fix pass. The critical boot blockers found in the initial scan have been addressed: Composer alignment, missing role middleware, model table names, route/controller/view alignment, field-name mismatches, Jetstream component aliases, and test APP key setup.

Remaining risks:

- The current tests are still only Laravel starter example tests; feature coverage should be added for real workflows before production confidence is high.
- The frontend build was not rerun because Docker Desktop was not running. `resources/js/app.js` and `public/js/app.js` were both patched for the Livewire 3 event call, and Jenkins should rebuild assets once Docker is available.
- Some legacy Laravel 8-era files remain, such as `app/Http/Kernel.php`, while Laravel 13 uses the new bootstrap style. They are no longer blocking the verified commands, but can be cleaned up later.
- Database migrations should be run against a staging database before production, especially because the app uses older singular table names.
