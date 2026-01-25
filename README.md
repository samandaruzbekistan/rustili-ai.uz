# Rustili AI - Bolalar uchun onlayn ta'lim platformasi

Rustili AI - bu bolalar uchun mo'ljallangan ko'p tilli (O'zbek va Rus) onlayn ta'lim va kutubxona platformasi. Platforma Filament admin paneli orqali boshqariladi va turli xil ta'lim materiallarini (matn, audio, video, testlar, topishmoqlar) taqdim etadi.

## 📋 Tarkib

- [Texnologiyalar](#texnologiyalar)
- [Talablar](#talablar)
- [O'rnatish](#ornatish)
- [Konfiguratsiya](#konfiguratsiya)
- [Ma'lumotlar bazasi](#malumotlar-bazasi)
- [Funksiyalar](#funksiyalar)
- [Loyiha struktura](#loyiha-struktura)
- [Admin panel](#admin-panel)
- [API va Route'lar](#api-va-routelar)
- [Development](#development)

## 🛠 Texnologiyalar

- **Backend**: Laravel 10.x
- **PHP**: 8.1+
- **Admin Panel**: Filament 3.x
- **Frontend**: Blade Templates, Vite
- **Database**: MySQL/PostgreSQL
- **Storage**: Local filesystem (public storage)

## 📦 Talablar

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL 5.7+ yoki PostgreSQL 10+
- Web server (Apache/Nginx)

## 🚀 O'rnatish

### 1. Repository'ni clone qiling

```bash
git clone <repository-url>
cd rustili-ai-uz
```

### 2. Dependencies'ni o'rnating

```bash
composer install
npm install
```

### 3. Environment faylini sozlang

```bash
cp .env.example .env
php artisan key:generate
```

`.env` faylida quyidagi sozlamalarni to'ldiring:

```env
APP_NAME="Rustili AI"
APP_URL=https://rustili-ai.uz
APP_LOCALE=ru
APP_FALLBACK_LOCALE=uz

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rustili_ai
DB_USERNAME=your_username
DB_PASSWORD=your_password

FILESYSTEM_DISK=local
```

### 4. Ma'lumotlar bazasini yarating va migratsiyalarni ishga tushiring

```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage link yarating

```bash
php artisan storage:link
```

### 6. Frontend asset'larini build qiling

```bash
npm run build
# yoki development uchun:
npm run dev
```

### 7. Admin panel uchun foydalanuvchi yarating

```bash
php artisan make:filament-user
```

## ⚙️ Konfiguratsiya

### Storage

Fayllar `storage/app/public` papkasida saqlanadi. Production'da quyidagilarni tekshiring:

1. `storage/app/public` papkasi yozish uchun ochiq bo'lishi kerak
2. `public/storage` symlink mavjud bo'lishi kerak (`php artisan storage:link`)

### Til sozlamalari

Platforma 2 ta tilni qo'llab-quvvatlaydi:
- **O'zbek tili** (`uz`)
- **Rus tili** (`ru`)

URL format: `/{locale}/...` (masalan: `/ru/chapter/...`, `/uz/chapter/...`)

## 🗄️ Ma'lumotlar bazasi

### Asosiy jadvallar

- **chapters** - Boblar (asosiy bo'limlar)
- **sections** - Bo'limlar (boblar ichidagi kichik bo'limlar)
- **contents** - Materiallar (matn, audio, video, testlar, topishmoqlar)
- **tests** - Testlar
- **test_questions** - Test savollari
- **test_options** - Test variantlari
- **test_attempts** - Test natijalari
- **users** - Foydalanuvchilar

### Migratsiyalar

```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed
```

## ✨ Funksiyalar

### 1. Materiallar turlari

- **📖 Matn** - Rich text formatida matn materiallar
- **🎧 Audio** - Audio fayllar
- **🎬 Video** - Video (iframe kod orqali)
- **📁 Fayl** - PDF, DOC, DOCX, PPT, PPTX fayllar
- **📝 Test** - Interaktiv testlar
- **🖼️ Rasm** - Rasm materiallar
- **🎨 Aralash** - Bir nechta turdagi materiallar
- **❓ Topishmoq** - Topishmoqlar (savol va javob)

### 2. Topishmoqlar (Riddles)

Topishmoqlar maxsus funksiyaga ega:
- Savol matni (title maydoni)
- Yashirin javob (body maydoni)
- "Javobni ko'rish" tugmasi
- To'g'ridan-to'g'ri bob yoki bo'lim sahifasida ko'rsatiladi

### 3. Rich Text Editor

- Emoji qo'llab-quvvatlash
- Rasm yuklash (attachFiles)
- Formatlash (bold, italic, underline, lists, headings)
- HTML kodlarini to'g'ri render qilish

### 4. Filtrlar

- Material turi bo'yicha filter
- Yosh chegaralari (ixtiyoriy)

### 5. Ko'p tillilik

- O'zbek va Rus tillari
- URL orqali til tanlash
- Session orqali til saqlash

## 📁 Loyiha struktura

```
rustili-ai-uz/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Filament/
│   │   └── Resources/        # Admin panel resurslari
│   │       ├── ChapterResource.php
│   │       ├── SectionResource.php
│   │       ├── ContentResource.php
│   │       └── TestResource.php
│   ├── Http/
│   │   ├── Controllers/      # Controller'lar
│   │   │   ├── HomeController.php
│   │   │   ├── ChapterController.php
│   │   │   ├── SectionController.php
│   │   │   ├── ContentController.php
│   │   │   └── TestController.php
│   │   └── Middleware/
│   │       └── SetLocale.php  # Til o'zgartirish middleware
│   ├── Models/               # Eloquent modellar
│   │   ├── Chapter.php
│   │   ├── Section.php
│   │   ├── Content.php
│   │   └── Test.php
│   └── Services/
│       └── AiTestGeneratorService.php
├── database/
│   ├── migrations/           # Ma'lumotlar bazasi migratsiyalari
│   └── seeders/              # Seeder'lar
├── resources/
│   ├── views/                # Blade template'lar
│   │   ├── layouts/
│   │   │   └── kids.blade.php  # Asosiy layout
│   │   ├── home.blade.php
│   │   ├── chapter/
│   │   ├── section/
│   │   ├── content/
│   │   └── test/
│   └── js/
├── routes/
│   └── web.php               # Web route'lar
└── public/
    └── storage/              # Storage symlink
```

## 🔐 Admin panel

Admin panel Filament 3.x orqali boshqariladi.

### Kirish

```
https://your-domain.com/admin
```

### Resurslar

1. **Boblar (Chapters)** - Asosiy bo'limlarni boshqarish
2. **Bo'limlar (Sections)** - Bo'limlarni boshqarish
3. **Materiallar (Contents)** - Barcha materiallarni boshqarish
4. **Testlar (Tests)** - Testlarni boshqarish

### Material yaratish

1. Material turini tanlang
2. Nom (RU va UZ) kiriting
3. Material kontentini kiriting:
   - **Matn**: Rich text editor
   - **Audio**: Audio URL yoki fayl yuklash
   - **Video**: iframe HTML kod (YouTube'dan copy qiling)
   - **Fayl**: PDF, DOC, DOCX, PPT, PPTX fayllar
   - **Topishmoq**: Savol (title) va javob (body)
4. Muqova rasmini yuklang (JPG, PNG, GIF, WEBP)
5. Saqlang

## 🌐 API va Route'lar

### Asosiy route'lar

```
/{locale}/                          # Bosh sahifa
/{locale}/chapter/{slug}            # Bob sahifasi
/{locale}/chapter/{slug}/section/{sectionSlug}  # Bo'lim sahifasi
/{locale}/content/{id}              # Material sahifasi
/{locale}/test/{id}                 # Test sahifasi
/{locale}/test/{id}/submit          # Test javoblarini yuborish
/{locale}/test/{id}/result/{attemptId}  # Test natijasi
```

### Helper funksiyalar

`app/helpers.php` faylida quyidagi helper funksiyalar mavjud:

- `current_locale()` - Joriy tilni qaytaradi
- `locale_url($name, $parameters = [])` - Locale bilan URL yaratadi
- `switch_locale_url($locale)` - Til o'zgartirish URL'i

## 🎨 Frontend

### CSS va JavaScript

- Vite orqali build qilinadi
- Responsive dizayn
- Mobile-friendly
- Emoji qo'llab-quvvatlash

### Layout

Asosiy layout: `resources/views/layouts/kids.blade.php`

Xususiyatlar:
- Gradient header
- Responsive navigation
- Locale switcher
- Footer

## 🔧 Development

### Cache tozalash

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Log'lar

Log fayllar: `storage/logs/laravel.log`

### Testing

```bash
php artisan test
```

### Code Style

```bash
./vendor/bin/pint
```

## 📝 Production Deployment

### 1. Environment sozlamalari

`.env` faylida production sozlamalarini to'ldiring:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rustili-ai.uz
```

### 2. Optimizatsiya

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3. Storage link

```bash
php artisan storage:link
```

### 4. Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🐛 Muammolarni hal qilish

### Rasm yuklash muammosi

1. Storage link yaratilganligini tekshiring: `php artisan storage:link`
2. `storage/app/public` papkasi yozish uchun ochiqligini tekshiring
3. `public/storage` symlink mavjudligini tekshiring

### Locale muammosi

1. Route cache'ni tozalang: `php artisan route:clear`
2. Config cache'ni tozalang: `php artisan config:clear`
3. Session'ni tozalang

### Rich Text muammosi

1. Emoji'lar ko'rinmasa, browser cache'ni tozalang
2. `Content-Type` meta tag mavjudligini tekshiring
3. Font-family'da emoji font'lar qo'shilganligini tekshiring

## 📄 License

Bu loyiha shaxsiy loyiha sifatida ishlab chiqilgan.

## 👥 Muallif

Rustili AI Team

## 🔗 Linklar

- Production: https://rustili-ai.uz
- Admin Panel: https://rustili-ai.uz/admin

---

**Eslatma**: Bu loyiha bolalar uchun mo'ljallangan ta'lim platformasi. Barcha materiallar bolalar uchun xavfsiz va mos bo'lishi kerak.
