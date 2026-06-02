# Kids Park - Development Workflow

> Panduan lengkap workflow development untuk Sistem Informasi Promosi dan Layanan Kids Park (Laravel)

## 📋 Table of Contents

1. [Project Overview](#project-overview)
2. [Environment Setup](#environment-setup)
3. [Development Workflow](#development-workflow)
4. [Database Management](#database-management)
5. [Testing Workflow](#testing-workflow)
6. [Common Tasks](#common-tasks)
7. [Git Workflow](#git-workflow)
8. [Troubleshooting](#troubleshooting)

---

## 📌 Project Overview

| Aspek | Detail |
|-------|--------|
| **Nama Proyek** | Kids Park Web Information System |
| **Framework** | Laravel 11+ |
| **Stack** | PHP, Laravel, MySQL, Blade Templates, Vite |
| **Database** | MySQL 5.7+ / MariaDB 10+ |
| **Server** | Apache (Laragon) |
| **Node Version** | 18+ (untuk Vite) |
| **PHP Version** | 8.1+ |

---

## 🚀 Environment Setup

### Prerequisites
```bash
# Diperlukan untuk development:
- PHP 8.1+
- Composer
- MySQL / MariaDB
- Node.js 18+
- Git
- Laragon (atau XAMPP)
```

### Initial Setup

```bash
# 1. Navigate ke project directory
cd c:\laragon\www\kidspark

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Create .env file (copy dari .env.example jika ada)
cp .env.example .env
# Atau buat manual dengan:
# - APP_NAME=KidsPark
# - APP_ENV=local
# - APP_DEBUG=true
# - DB_HOST=localhost
# - DB_DATABASE=kidspark_db
# - DB_USERNAME=root
# - DB_PASSWORD=

# 5. Generate app key
php artisan key:generate

# 6. Migrate database
php artisan migrate

# 7. Seed database (jika tersedia)
php artisan db:seed

# 8. Build assets
npm run dev
# Atau untuk production:
npm run build

# 9. Start development server
php artisan serve
# Akses: http://127.0.0.1:8000
```

### Laragon Setup (Alternative)
```bash
# Jika menggunakan Laragon:
# 1. Copy folder kidspark ke C:\laragon\www\
# 2. Buka Laragon, klik menu → Quick Add → Artisan
# 3. Atau akses manual: http://localhost/kidspark
# 4. Edit .env sesuai database Laragon (biasanya root:root)
```

---

## 💻 Development Workflow

### Daily Development Cycle

```
1. Start Development
   ├─ php artisan serve          # Mulai dev server
   ├─ npm run dev                # Watch assets (Vite)
   └─ mysql server running       # Pastikan DB aktif

2. Code Development
   ├─ Create/edit controllers (app/Http/Controllers/)
   ├─ Create/edit models (app/Models/)
   ├─ Create/edit views (resources/views/)
   └─ Create/edit routes (routes/web.php)

3. Database Changes
   ├─ Create migration: php artisan make:migration create_xxx_table
   ├─ Edit migration file
   └─ Run migration: php artisan migrate

4. Testing
   ├─ php artisan test           # Run tests
   └─ npm run build              # Build untuk production check

5. Commit & Push
   ├─ git add .
   ├─ git commit -m "descriptive message"
   └─ git push origin branch-name
```

### Directory Structure & Responsibilities

```
app/
├── Http/
│   ├── Controllers/            # Business logic handlers
│   │   ├── Admin/              # Admin controllers
│   │   ├── Api/                # API endpoints (jika ada)
│   │   └── Web/                # Web page controllers
│   └── Middleware/             # Custom middleware (auth, etc)
│
├── Models/                     # Database models
│   ├── Admin.php               # Admin user model
│   ├── Layanan.php             # Services model
│   ├── Tiket.php               # Tickets model
│   ├── Promosi.php             # Promotions model
│   ├── Galeri.php              # Gallery model
│   ├── Kontak.php              # Contact info model
│   └── PesananTiket*.php       # Order models
│
└── Helpers/                    # Helper functions
    └── AppHelper.php

resources/
├── views/
│   ├── welcome.blade.php       # Homepage
│   ├── admin/                  # Admin templates
│   │   ├── dashboard.blade.php
│   │   ├── layanan.blade.php
│   │   ├── tiket.blade.php
│   │   ├── promosi.blade.php
│   │   ├── galeri.blade.php
│   │   └── kontak.blade.php
│   ├── layouts/
│   │   ├── app.blade.php       # Main admin layout
│   │   └── guest.blade.php     # Login layout
│   └── tiket/                  # Tiket booking related
│
├── css/
│   └── app.css                 # Global styles
│
└── js/
    └── app.js                  # Global JS

database/
├── migrations/                 # Database schemas
├── seeders/                    # Database seeders
│   ├── DatabaseSeeder.php
│   └── LayananSeeder.php
└── factories/                  # Model factories (testing)

routes/
├── web.php                     # Web routes (public + admin)
└── console.php                 # Artisan commands
```

### Code Style Guidelines

```php
// ✅ GOOD - Follow PSR-12 & Laravel conventions
namespace App\Http\Controllers;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return view('admin.layanan', compact('layanan'));
    }
}

// ✅ Use meaningful variable names
$daftarLayanan = Layanan::where('status', 'aktif')->get();

// ✅ Use type hints
public function store(Request $request): RedirectResponse

// ❌ AVOID - Cryptic names, missing types
function getStuff() {
    $x = DB::select("SELECT * FROM layanan");
}
```

---

## 🗄️ Database Management

### Create New Table/Model

```bash
# 1. Create model + migration
php artisan make:model NamaModel -m

# 2. Edit migration file (database/migrations/XXXX_create_nama_models_table.php)
php artisan make:migration create_nama_models_table

# Contoh migration:
Schema::create('nama_models', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->text('deskripsi')->nullable();
    $table->foreignId('id_admin')->constrained('admins');
    $table->timestamps();
});

# 3. Run migration
php artisan migrate

# 4. Update model (app/Models/NamaModel.php)
protected $fillable = ['nama', 'deskripsi', 'id_admin'];
```

### Database Workflow

```bash
# Lihat status migrations
php artisan migrate:status

# Rollback last batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Refresh (reset + run)
php artisan migrate:refresh

# Refresh + seed data
php artisan migrate:refresh --seed

# Run specific seeder
php artisan db:seed --class=LayananSeeder
```

### Backup & Restore

```bash
# Export database (dari cmd/terminal)
mysqldump -u root kidspark_db > backup_kidspark.sql

# Import database
mysql -u root kidspark_db < backup_kidspark.sql

# Atau dari Laragon GUI:
# 1. Database → MySQL → Admin
# 2. phpMyAdmin → Database → Export/Import
```

---

## 🧪 Testing Workflow

### Unit Tests

```bash
# Jalankan semua tests
php artisan test

# Jalankan test file spesifik
php artisan test tests/Unit/LayananTest.php

# Jalankan dengan coverage report
php artisan test --coverage

# Jalankan tests dengan pattern
php artisan test --filter LayananTest
```

### Feature Tests

```bash
# Tests untuk HTTP requests
php artisan test tests/Feature/

# Test specific feature
php artisan test tests/Feature/LoginTest.php

# Test dengan debug output
php artisan test --verbose
```

### Test Example Structure

```php
// tests/Feature/LayananTest.php
<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Layanan;

class LayananTest extends TestCase
{
    public function test_layanan_index_returns_view()
    {
        $response = $this->get('/admin/layanan');
        $response->assertStatus(200);
        $response->assertViewIs('admin.layanan');
    }
}
```

---

## ✅ Common Tasks

### Create a New Admin Feature

```bash
# 1. Create Model & Migration
php artisan make:model Fitur -m

# 2. Create Controller
php artisan make:controller FiturController -r

# 3. Edit migration (database/migrations/)
# Add table fields

# 4. Run migration
php artisan migrate

# 5. Add routes (routes/web.php)
Route::middleware('auth:admin')->group(function () {
    Route::resource('fitur', FiturController::class);
});

# 6. Create views (resources/views/admin/fitur/)
# - index.blade.php
# - create.blade.php
# - edit.blade.php
# - show.blade.php

# 7. Implement logic in controller
# 8. Test the feature
# 9. Commit to git
```

### Handle File Uploads

```php
// In Controller
public function store(Request $request)
{
    $request->validate([
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
    ]);

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/galeri', $filename);
        // Store $filename in database
    }
}

// Access uploaded file
Storage::url('galeri/' . $filename)
```

### Add Authentication Guard

```php
// config/auth.php - Already configured with 'admin' guard
'guards' => [
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],

// Use in middleware/controller
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
});
```

### Query Database

```php
// Get all records
$layanan = Layanan::all();

// Get with conditions
$layanan = Layanan::where('status', 'aktif')->get();

// Get single record
$layanan = Layanan::find($id);
$layanan = Layanan::where('slug', 'washing')->first();

// Count
$total = Layanan::count();
$aktif = Layanan::where('status', 'aktif')->count();

// Update
$layanan->update(['nama' => 'New Name']);
Layanan::where('id', $id)->update(['status' => 'aktif']);

// Delete
$layanan->delete();
Layanan::find($id)->delete();

// Relationships
$admin = Admin::with('layanan', 'tiket')->find($id);
```

### Format & Display Data

```php
// app/Helpers/AppHelper.php
function formatRupiah($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function truncate($text, $limit = 100)
{
    return substr($text, 0, $limit) . '...';
}

// In Blade view
{{ formatRupiah($tiket->harga) }}
{{ truncate($promosi->deskripsi) }}

// Or use Blade directives
{{ $date->format('d M Y') }}
@if($promosi->isAktif())
    <span class="badge badge-success">Aktif</span>
@endif
```

---

## 🌿 Git Workflow

### Branch Strategy

```
main                           # Production branch
├─ develop                     # Development integration
│  ├─ feature/layanan-crud    # Feature branches
│  ├─ feature/tiket-booking
│  ├─ bugfix/auth-issue
│  └─ hotfix/security-patch
```

### Standard Commands

```bash
# Clone repository
git clone <repo-url>
cd kidspark

# Create feature branch
git checkout -b feature/nama-fitur
git checkout develop

# Make changes
git add .
git commit -m "feat: add new feature description"
# Types: feat, fix, docs, style, refactor, test, chore

# Push branch
git push origin feature/nama-fitur

# Create Pull Request (GitHub/GitLab)
# - Describe changes
# - Reference issues
# - Request review

# After approval
git checkout develop
git pull origin develop
git merge feature/nama-fitur
git push origin develop

# Delete branch
git branch -d feature/nama-fitur
git push origin --delete feature/nama-fitur

# Update local develop
git fetch origin
git checkout develop
git pull origin develop
```

### Commit Message Format

```
feat: add layanan listing page
fix: resolve authentication timeout issue
docs: update API documentation
style: format code according to PSR-12
refactor: simplify tiket calculation logic
test: add unit tests for Layanan model
chore: update dependencies
```

---

## 🛠️ Troubleshooting

### Common Issues & Solutions

#### 1. Database Connection Error
```
Error: SQLSTATE[HY000]: General error: 1030 Got error...

Solution:
# 1. Check .env file
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=
DB_DATABASE=kidspark_db

# 2. Ensure MySQL is running (Laragon)
# 3. Clear cache
php artisan config:clear
php artisan cache:clear

# 4. Retry migration
php artisan migrate:refresh --seed
```

#### 2. Storage Permission Denied
```
Error: The only supported ciphers are AES-128-CBC and AES-256-CBC

Solution:
# 1. Regenerate app key
php artisan key:generate

# 2. Set storage permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# 3. On Windows: right-click → Properties → Security
```

#### 3. Vite Assets Not Loading
```
Error: JavaScript not compiled, CSS not linked

Solution:
# 1. Kill Vite server
# 2. Clear node_modules cache
npm install

# 3. Rebuild assets
npm run dev
# atau
npm run build

# 4. Clear Laravel cache
php artisan view:clear
php artisan config:clear
```

#### 4. Migration Already Exists
```
Error: Class already exists

Solution:
# 1. Delete duplicate migration file
# 2. Or rename with new timestamp
# 3. Re-run migration
php artisan migrate
```

#### 5. Session/Auth Issues
```
Error: Unauthenticated, redirected to login

Solution:
# 1. Check session configuration (config/session.php)
# 2. Clear sessions
php artisan session:clear

# 3. Verify auth guard config (config/auth.php)
# 4. Check middleware on routes
```

### Performance Optimization

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Development Server Issues

```bash
# If port 8000 is in use, specify different port
php artisan serve --port=8001

# If Artisan commands hang, clear
php artisan cache:clear
php artisan queue:flush

# Restart from clean state
php artisan migrate:refresh --seed
php artisan serve
```

---

## 📚 Resources

| Resource | Link |
|----------|------|
| Laravel Docs | https://laravel.com/docs/11 |
| Laravel Community | https://laravel.io |
| Blade Template Docs | https://laravel.com/docs/11/views |
| Eloquent ORM | https://laravel.com/docs/11/eloquent |
| Vite Assets | https://laravel.com/docs/11/vite |
| MySQL Docs | https://dev.mysql.com/doc/ |

---

## 👥 Team Guidelines

### Before Starting Work
- [ ] Pull latest code: `git pull origin develop`
- [ ] Update dependencies: `composer install && npm install`
- [ ] Run tests: `php artisan test`
- [ ] Create feature branch: `git checkout -b feature/xxx`

### While Developing
- [ ] Follow PSR-12 code style
- [ ] Write meaningful commit messages
- [ ] Add tests for new features
- [ ] Update documentation if needed
- [ ] Don't commit .env or vendor/

### Before Committing
- [ ] Test locally: `php artisan test`
- [ ] Build assets: `npm run build`
- [ ] Review code changes
- [ ] Clear cache: `php artisan config:clear`

### Before Merging
- [ ] Code review approval required
- [ ] All tests pass
- [ ] Documentation updated
- [ ] No merge conflicts

---

*Last Updated: May 2026 | Team: Kelompok 9 - D4 SIKC POLINDRA*
