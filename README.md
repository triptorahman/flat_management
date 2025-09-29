# 🏢 Flat Management System

A comprehensive Laravel-based flat/apartment management system designed for house owners to efficiently manage their properties, tenants, and billing operations.

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Database Schema](#-database-schema)
- [API Endpoints](#-api-endpoints)
- [Screenshots](#-screenshots)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🏠 **Property Management**
- **Building Management**: Create and manage multiple buildings
- **Flat/Unit Management**: Add flats with detailed information (number, rent, deposit, etc.)
- **Multi-property Support**: Handle multiple properties from a single dashboard

### 👥 **Tenant Management**
- **Tenant Registration**: Complete tenant profile management
- **Tenant Assignment**: Link tenants to specific flats
- **Tenant History**: Track tenant movement and history
- **Contact Management**: Store tenant contact information and documents

### 💰 **Advanced Billing System**
- **Multi-Category Bills**: Create bills with multiple categories (rent, utilities, maintenance, etc.)
- **Flexible Bill Generation**: Generate bills for specific tenants and months
- **Duplicate Prevention**: Smart duplicate bill detection
- **Bill Categories**: Customizable billing categories for different charges

### 💳 **Payment Collection**
- **Payment Processing**: Record full and partial payments
- **Multiple Payment Methods**: Cash, bank transfer, cheque, online, card
- **Payment History**: Comprehensive payment tracking and history
- **Due Amount Management**: Automatic calculation of outstanding amounts

### 📊 **Dashboard & Analytics**
- **Revenue Overview**: Track total revenue and payment statistics
- **Bill Status Tracking**: Monitor paid/unpaid bills
- **Quick Actions**: Easy access to common operations
- **Search & Filter**: Advanced search capabilities across all modules

### 🔐 **Security & Authentication**
- **Multi-Guard Authentication**: Separate authentication for house owners
- **Role-based Access**: Secure access control
- **Data Protection**: Owner-specific data isolation
- **Session Management**: Secure session handling

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze with custom guards

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Icons**: Heroicons (SVG)

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Code Quality**: Laravel Pint, PHPUnit
- **Development Server**: Laravel Artisan, Vite Dev Server

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 16+ and NPM
- SQLite (or MySQL/PostgreSQL)

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
# Create SQLite database (if using SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed
```

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
DB_CONNECTION=sqlite
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

### 1. **House Owner Registration**
- Register as a house owner through the registration form
- Complete profile setup with contact information

### 2. **Property Setup**
- Create buildings for your properties
- Add flats/units with rent details
- Set up bill categories (rent, utilities, maintenance, etc.)

### 3. **Tenant Management**
- Add tenants with complete information
- Assign tenants to specific flats
- Manage tenant contacts and documents

### 4. **Bill Generation**
- Navigate to Bills → Generate New Bill
- Select tenant and month
- Choose bill categories and enter amounts
- System prevents duplicate bills automatically

### 5. **Payment Collection**
- View bills in the Bills Management section
- Click "Collect Payment" for unpaid bills
- Record full or partial payments
- Track payment history

## 🗄️ Database Schema

### Core Tables

#### **house_owners**
- Primary authentication table for property owners
- Stores owner profile and contact information

#### **buildings**
- Property/building information
- Links to house_owners (one-to-many)

#### **flats**
- Individual unit/flat details
- Stores rent, deposit, and other flat-specific data
- Links to buildings and house_owners

#### **tenants**
- Tenant profile information
- Contact details and documentation
- Links to flats (one-to-one current occupancy)

#### **bill_categories**
- Customizable billing categories
- Owner-specific categories (rent, utilities, etc.)

#### **bills**
- Main billing records
- Links to flats, house_owners, and primary bill_category

#### **bill_details**
- Category-wise bill breakdown
- Stores individual amounts for each category
- Links to bills and bill_categories

## 🌐 API Endpoints

### Authentication Routes
```
POST   /house-owner/register     - House owner registration
POST   /house-owner/login        - House owner login
POST   /house-owner/logout       - House owner logout
```

### Management Routes
```
GET    /house-owner/dashboard         - Main dashboard
GET    /house-owner/tenants          - Tenant management
GET    /house-owner/bills            - Bill management
GET    /house-owner/bills?generate=1 - Bill generation form
POST   /house-owner/bills/check      - Check duplicate bills (AJAX)
GET    /house-owner/bills/{id}/collect - Payment collection form
POST   /house-owner/bills/{id}/collect - Process payment
```

## 📸 Screenshots

### Dashboard
![Dashboard Overview](screenshots/dashboard.png)

### Bill Generation
![Bill Generation Form](screenshots/bill-generation.png)

### Payment Collection
![Payment Collection](screenshots/payment-collection.png)

### Bills Management
![Bills List](screenshots/bills-list.png)

## 🎯 Key Features Breakdown

### **Multi-Category Billing**
- Create bills with multiple categories in a single transaction
- Dynamic form that adapts to selected categories
- Automatic total calculation and validation

### **Smart Duplicate Prevention**
- Real-time AJAX checking during bill creation
- Server-side validation with user-friendly messages
- Prevents accidental duplicate billing

### **Flexible Payment System**
- Support for full and partial payments
- Multiple payment methods with reference tracking
- Automatic due amount calculations

### **Responsive Design**
- Mobile-first approach with Tailwind CSS
- Print-friendly bill layouts
- Consistent user experience across devices

## 🔧 Development

### Running Tests
```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Check for issues
./vendor/bin/pint --test
```

### Asset Development
```bash
# Watch for changes during development
npm run dev

# Build for production
npm run build
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📋 TODO / Roadmap

- [ ] **Reports & Analytics**: Advanced reporting dashboard
- [ ] **Document Management**: File upload and management for tenants
- [ ] **Notification System**: Email/SMS notifications for due payments
- [ ] **Mobile App**: React Native mobile application
- [ ] **Multi-language Support**: Internationalization
- [ ] **Backup System**: Automated database backups
- [ ] **API Documentation**: Complete API documentation with Swagger

## 🐛 Known Issues

- Print functionality needs enhancement for different paper sizes
- Mobile responsiveness can be improved for complex tables
- Need to add more comprehensive error handling

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Email: support@flatmanagement.com
- Documentation: [Wiki Pages](../../wiki)

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework and community
- Tailwind CSS for the beautiful styling
- Alpine.js for reactive components
- Heroicons for the icon set

---

**Made with ❤️ for property management efficiency**
