# MasakanKu

Aplikasi berbagi resep masakan berbasis web — user bisa membuat, mencari, dan
menyimpan resep favorit, memberi rating/ulasan, dan berkomentar. Dibangun
dengan **Laravel 11** (server-rendered, Blade + Alpine.js + Tailwind CSS),
dengan upload gambar ke **Cloudinary**.

## Fitur

- **Autentikasi & role**: register/login (Laravel Breeze), dua role —
  `admin` dan `user` (kolom `role` di tabel `users`, dijaga oleh
  `AdminMiddleware` & `UserMiddleware`).
- **Resep**
  - CRUD resep (judul, kategori, porsi, waktu masak, langkah/`steps` beserta
    gambar per langkah).
  - Pencarian resep (`/search`) dan filter per kategori
    (`/recipes/category/{category}`).
  - Halaman resep populer (`/populer`), berdasar kolom popularitas/rating
    rata-rata yang dihitung dari review.
  - Detail resep publik (`/recipes/{id}`) — bisa diakses tanpa login.
- **Review & Rating**: user login bisa memberi rating + ulasan pada resep;
  rata-rata rating resep disimpan di kolom `average_rating`.
- **Komentar**: user login bisa berkomentar di halaman resep.
- **Favorite**: toggle simpan resep ke daftar favorit, ditampilkan di
  `/profile/favorites`.
- **Profil**: edit profil, ganti foto profil (upload ke Cloudinary), hapus
  akun.
- **Dashboard per role**
  - Admin (`/admin/dashboard`, `/admin/recipes`): monitoring resep milik
    semua user.
  - User (`/user/dashboard`, `/recipes/all`): resep milik user sendiri.

## Tech Stack

| Komponen | Teknologi |
| --- | --- |
| Framework | Laravel 11 (PHP 8.2) |
| Frontend | Blade templates + Alpine.js + Tailwind CSS 3 (build via Vite) |
| Auth scaffolding | Laravel Breeze |
| Database | MySQL (production) / SQLite (default lokal) |
| Storage gambar | Cloudinary (`cloudinary-labs/cloudinary-laravel`) |
| Testing | PHPUnit |
| Deployment | Render (`render.yaml`) / Nixpacks (`nixpacks.toml`) |

## Struktur Proyek (ringkas)

```
app/
  Models/            Recipe, Category, Review, Rating, Comment, Favorite,
                     Instruction, InstructionImage, User
  Http/
    Controllers/     RecipeController, ReviewController, CommentController,
                     FavoriteController, ProfileController, AdminController,
                     AdminDashboardController, UserDashboardController,
                     PopulerController, RatingController, DashboardController
    Middleware/       AdminMiddleware, UserMiddleware
database/
  migrations/        skema tabel (recipes, reviews, comments, ratings,
                     steps/instructions, favorites, role di tabel users, dst)
  seeders/, factories/
resources/
  views/             Blade templates
  js/, css/          aset frontend (dikompilasi Vite)
routes/
  web.php            route halaman publik & privat (grup middleware auth/admin/user)
  auth.php           route bawaan Laravel Breeze
```

## Menjalankan Proyek

### Prasyarat
- PHP 8.2+, Composer
- Node.js 20+ (untuk build asset Vite)
- Database: **MySQL**

### Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Buka `.env`, set koneksi ke MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=masakanku
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `masakanku` di MySQL (lewat phpMyAdmin, MySQL Workbench, atau
`mysql -u root -p -e "CREATE DATABASE masakanku"`), lalu jalankan migrasi:

```bash
php artisan migrate --seed
```

Jalankan server dev (Laravel + Vite, dua terminal):

```bash
php artisan serve
npm run dev
```

Buka [http://localhost:8000](http://localhost:8000).

## Environment Variable Penting

| Variabel | Keterangan |
| --- | --- |
| `APP_KEY` | Di-generate otomatis lewat `php artisan key:generate` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` / `DB_PORT` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | Kredensial koneksi MySQL |
| `FILESYSTEM_DISK` | Set ke `cloudinary` untuk upload gambar resep/profil ke Cloudinary (lihat `.env.production.example`) |
| `CLOUDINARY_CLOUD_NAME` / `CLOUDINARY_API_KEY` / `CLOUDINARY_API_SECRET` | Kredensial Cloudinary — wajib diisi kalau `FILESYSTEM_DISK=cloudinary` |

## Daftar Route

Aplikasi ini **tidak punya REST API terpisah** — semua route mengembalikan
halaman Blade (server-rendered), bukan JSON. Daftar di bawah adalah seluruh
route dari `routes/web.php`.

### Publik (tanpa login)
| Method | Route | Controller@Method |
| --- | --- | --- |
| GET | `/` | `welcome` view |
| GET | `/search` | `RecipeController@search` |
| GET | `/populer` | `RecipeController@popular` |
| GET | `/recipes/{id}` | `RecipeController@show` |

### Auth (login diperlukan)
| Method | Route | Controller@Method |
| --- | --- | --- |
| GET | `/profile` | `ProfileController@edit` |
| PATCH | `/profile` | `ProfileController@update` |
| DELETE | `/profile` | `ProfileController@destroy` |
| POST | `/profile/update/picture` | `ProfileController@updatePicture` |
| GET | `/profile/favorites` | `ProfileController@favorites` |
| POST/DELETE | `/profile/favorites/{recipe}` | `FavoriteController@toggleFavorite` |
| GET | `/recipes/create` | `RecipeController@create` |
| GET | `/recipes/category/{category}` | `RecipeController@category` |
| GET | `/recipes` | `RecipeController@index` |
| POST | `/recipes` | `RecipeController@store` |
| GET | `/recipes/{recipe}/edit` | `RecipeController@edit` |
| PUT | `/recipes/{recipe}` | `RecipeController@update` |
| DELETE | `/recipes/{recipe}` | `RecipeController@destroy` |
| POST | `/recipes/{recipe}/reviews` | `ReviewController@store` |
| POST | `/recipes/{recipe}/comments` | `CommentController@store` |

### Admin (`auth` + `verified` + `admin`)
| Method | Route | Controller@Method |
| --- | --- | --- |
| GET | `/admin/dashboard` | `AdminController@index` |
| GET | `/admin/recipes` | `AdminController@userRecipes` |

### User (`auth` + `verified` + `user`)
| Method | Route | Controller@Method |
| --- | --- | --- |
| GET | `/user/dashboard` | `UserDashboardController@index` |
| GET | `/user/all-recipes` | `RecipeController@allRecipes` |

Route autentikasi (login, register, verifikasi email, reset password, dll)
mengikuti bawaan **Laravel Breeze** di `routes/auth.php`.

## Deployment

Repo ini sudah menyertakan dua opsi konfigurasi deploy siap pakai:

- **`render.yaml`** — deploy ke [Render](https://render.com) (region
  Singapore), build otomatis menjalankan `composer install`, `npm run
  build`, lalu cache config/route/view Laravel.
- **`nixpacks.toml`** — build via [Nixpacks](https://nixpacks.com) (dipakai
  platform seperti Railway), termasuk step `php artisan migrate --force`
  dan `storage:link` otomatis saat build.

Untuk kedua opsi, pastikan environment variable database & Cloudinary di
platform hosting sudah diisi sesuai tabel di atas.

## Testing

```bash
php artisan test
```
