# 🚗 Thiuu Rental Elite  
**Premium Car Rental Management System | Laravel 12**

Thiuu Rental Elite is a modern, full-stack car rental management system built with **Laravel 12**, **TailwindCSS**, and **Alpine.js**. The application provides a comprehensive platform for managing vehicle rentals with an elegant, user-friendly interface and robust admin panel.

---

## 🔍 Project Overview

The system offers a complete car rental solution where users can browse premium vehicles, make bookings, and manage their rentals, while administrators have full control over inventory, bookings, users, and system settings through an intuitive admin dashboard.

This project showcases **modern web development practices**, **clean architecture**, and **production-ready patterns** suitable for portfolio demonstration and real-world deployment.

---

## 🎯 What This Project Demonstrates

- **Laravel 12** with modern PHP 8.2+ features
- Clean **MVC architecture** with service layer patterns
- **Authentication** with Laravel Breeze
- **Role-based access control** (Admin/User)
- **Vite** for fast asset bundling
- **TailwindCSS** for modern, responsive UI
- **Alpine.js** for interactive components
- RESTful API design patterns
- Image upload and storage management
- Database design with migrations and relationships
- Production-ready Docker configuration

---

## ✨ Features

### User Features
- 🔐 User registration and authentication
- 🚗 Browse premium vehicle collection
- 🔍 Advanced vehicle search and filtering
- 📝 Detailed vehicle information pages
- 🎫 Create and manage rental bookings
- 👤 Personal profile management
- 📱 Fully responsive design

### Admin Features
- 📊 Comprehensive dashboard with analytics
- 🚙 Vehicle inventory management (CRUD)
- 📂 Category management
- 📋 Booking and order management
- 👥 User management
- 🖼️ Image upload and management
- 📈 System statistics and reporting

---

## 🧱 Tech Stack

| Layer | Technology |
|-------|------------|
| Backend Framework | Laravel 12 |
| Frontend | Blade Templates, TailwindCSS, Alpine.js |
| Asset Bundler | Vite |
| Database | MySQL / SQLite |
| Language | PHP 8.2+ |
| Authentication | Laravel Breeze |
| Version Control | Git, GitHub |
| Containerization | Docker, Docker Compose |

---

## 📁 Project Structure

```
app/
 ├── Http/
 │   ├── Controllers/     # Application controllers
 │   └── Middleware/      # Custom middleware
 ├── Models/              # Eloquent models
 └── Providers/           # Service providers
routes/
 └── web.php              # Web routes
resources/
 ├── views/
 │   ├── admin/          # Admin panel views
 │   ├── components/     # Reusable Blade components
 │   └── *.blade.php     # Public views
 ├── css/                # Stylesheets
 └── js/                 # JavaScript files
database/
 ├── migrations/         # Database migrations
 └── seeders/            # Database seeders
public/                  # Public assets
storage/                 # File storage
docker/                  # Docker configuration
```

---

## ⚙️ Installation & Setup

### Requirements

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.0
- **npm** or **yarn**
- **MySQL** >= 8.0 (or SQLite for development)
- **Git**

### Option 1: Local Development Setup

#### 1. Clone the Repository

```bash
git clone https://github.com/khanhthieu1604-lab/Thiuu.git
cd Thiuu
```

#### 2. Install PHP Dependencies

```bash
composer install
```

#### 3. Install Node Dependencies

```bash
npm install
```

#### 4. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Configure Database

Edit `.env` file with your database credentials:

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thiuu_carrental
DB_USERNAME=root
DB_PASSWORD=your_password
```

**For SQLite (Development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

#### 6. Database Setup

```bash
# Run migrations
php artisan migrate

# (Optional) Seed database with sample data
php artisan db:seed

# Create storage symbolic link
php artisan storage:link
```

#### 7. Start Development Servers

**Option A: Run both servers separately**

Terminal 1 - Laravel Server:
```bash
php artisan serve
```

Terminal 2 - Vite Dev Server:
```bash
npm run dev
```

**Option B: Use composer script (runs both concurrently)**
```bash
composer dev
```

#### 8. Access the Application

- **Frontend:** http://localhost:8000
- **Vite Dev Server:** http://localhost:5173

---

### Option 2: Docker Setup

#### 1. Prerequisites

- Docker Desktop installed
- Docker Compose installed

#### 2. Build and Start Containers

```bash
# Build and start all services
docker-compose up -d --build

# View logs
docker-compose logs -f
```

#### 3. Run Initial Setup

```bash
# Run migrations inside container
docker-compose exec app php artisan migrate

# Create storage link
docker-compose exec app php artisan storage:link
```

#### 4. Access the Application

- **Application:** http://localhost:8080
- **MySQL:** localhost:3306

#### 5. Manage Containers

```bash
# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# View running containers
docker-compose ps
```

---

## 🚀 Running the Project

### Development Mode

```bash
# Start Laravel server (port 8000)
php artisan serve

# In another terminal, start Vite dev server (port 5173)
npm run dev
```

### Production Build

```bash
# Build assets for production
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run tests with coverage
php artisan test --coverage
```

---

## � Available Commands

### Composer Scripts

```bash
composer setup        # Initial project setup
composer dev          # Run dev servers (Laravel + Queue + Logs + Vite)
composer test         # Run tests
```

### Artisan Commands

```bash
php artisan migrate          # Run migrations
php artisan db:seed          # Seed database
php artisan storage:link     # Link storage
php artisan cache:clear      # Clear cache
php artisan config:clear     # Clear config cache
php artisan route:list       # List all routes
php artisan tinker           # Laravel REPL
```

### NPM Commands

```bash
npm run dev           # Start Vite dev server
npm run build         # Build for production
npm run preview       # Preview production build
```

---

## 🖼️ Image & Asset Management

- Uploaded vehicle images are stored in `storage/app/public/vehicles`
- Public access via `public/storage` (created by `storage:link`)
- Static assets (CSS, JS) compiled by Vite to `public/build`
- Production-ready for CDN integration (AWS S3, Cloudinary, etc.)

---

## � Default Admin Credentials

After running seeders, you can login with:

```
Email: admin@thiuu.com
Password: password
```

**⚠️ Important:** Change these credentials in production!

---

## 🌐 Environment Variables

Key environment variables to configure:

```env
APP_NAME="Thiuu Rental Elite"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=thiuu_carrental

VITE_APP_NAME="${APP_NAME}"

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025

# Storage
FILESYSTEM_DISK=local
```

---

## 🚧 Troubleshooting

### Common Issues

**1. "Mix manifest not found" or Vite errors**
```bash
npm install
npm run dev
```

**2. Storage link issues**
```bash
# Remove old link if exists
rm public/storage

# Recreate link
php artisan storage:link
```

**3. Database connection errors**
- Check `.env` database credentials
- Ensure MySQL service is running
- Verify database exists

**4. Permission errors**
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache

# Windows (PowerShell as Admin)
icacls storage /grant Users:F /t
```

**5. Docker build takes too long**
- The `npm run dev` in Dockerfile can be slow
- For faster builds, use local development setup
- Or modify Dockerfile to use `npm run build` instead

---

## 🎨 Customization

### Changing Colors/Theme

Edit `tailwind.config.js` to customize the design:

```js
theme: {
  extend: {
    colors: {
      primary: '#your-color',
      secondary: '#your-color',
    }
  }
}
```

### Adding New Features

1. Create migration: `php artisan make:migration create_table_name`
2. Create model: `php artisan make:model ModelName`
3. Create controller: `php artisan make:controller ControllerName`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`

---

## 📦 Deployment

### Deployment Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper database credentials
- [ ] Run `npm run build` for production assets
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up proper file permissions
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate
- [ ] Configure backup strategy

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

This project is intended for learning, portfolio demonstration, and production use.

---

## 👨‍💻 Author

**Lương Khánh Thiệu**  
Full-stack Developer | Laravel Specialist

- 🌐 GitHub: [khanhthieu1604-lab](https://github.com/khanhthieu1604-lab)
- 📧 Contact: [Your Email]
- 💼 LinkedIn: [Your LinkedIn]

---

## � Acknowledgments

- Laravel Framework
- TailwindCSS
- Alpine.js
- The amazing open-source community

---

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Troubleshooting](#-troubleshooting) section
2. Search existing [GitHub Issues](https://github.com/khanhthieu1604-lab/Thiuu/issues)
3. Create a new issue with detailed information

---

**Made with ❤️ using Laravel**
