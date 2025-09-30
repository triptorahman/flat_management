# 🏢 Flat Management System

A comprehensive Laravel-based flat management system designed for house owners to efficiently manage their properties, tenants, and billing operations.



## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Breeze with custom guards

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Development Server**: Laravel Artisan, Vite Dev Server

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 16+ and NPM
- MySQL

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/flat-management.git
cd flat-management
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install JavaScript Dependencies
```bash
npm install
```

### Step 4: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Database Setup
```bash
# Create Mysql
database name: flat_management.sql

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed
```

Common Password : password

### Step 6: Build Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

### Step 7: Start the Development Server
```bash
# Start Laravel development server
php artisan serve

# In another terminal, start Vite dev server for hot reloading
npm run dev
```

Visit `http://localhost:8000` to access the application.

## ⚙️ Configuration

### Database Configuration
Edit `.env` file to configure your database:

```env
# For SQLite
DB_CONNECTION=mysql
DB_DATABASE=/absolute/path/to/database.sqlite

# For MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flat_management
DB_USERNAME=root
DB_PASSWORD=
```

### Application Settings
```env
APP_NAME="Flat Management System"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000
```

## 🚀 Usage

### 1. **Admin**
- Register as a Admin through the registration form
- Or login with 'admin@gmail.com' 'password'
- add House owner and buildings
- Assign tenant to a available flat

### 2. **House Owner**
- Add flats
- Add bill category
- Generate Bill (After admin assign a tenant)
- Generate Bill
- Bill Collection

### Asset Development
```bash
# Watch for changes during development
npm run dev

# Build for production
npm run build
```

