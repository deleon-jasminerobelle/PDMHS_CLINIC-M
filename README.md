# PDMHS Student Medical System

A comprehensive medical management system designed specifically for PDMHS (President Diosdado Macapagal High School) to streamline student health records, medical consultations, and clinic operations.


### Development Tools
- **Laravel Pint** - Code style fixer for consistent formatting
- **PHPUnit** - Comprehensive testing framework
- **Laravel Sail** - Docker development environment
- **Concurrently** - Run multiple development processes simultaneously

### Infrastructure
- **Redis** - Caching and session management
- **Queue System** - Background job processing for heavy operations
- **File Storage** - Secure document and image management

## Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+ or PostgreSQL 13+
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/PDMHS_CLINIC-M.git
   cd PDMHS_CLINIC-M/pdmhs_clinic
   ```

2. **Install dependencies and setup**
   ```bash
   composer run setup
   ```
   This command will:
   - Install PHP dependencies
   - Copy environment configuration
   - Generate application key
   - Run database migrations
   - Install Node.js dependencies
   - Build frontend assets

3. **Configure environment**
   ```bash
   cp .env.example .env
   ```
   Edit `.env` file with your database credentials and other settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pdmhs_clinic
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run database migrations**
   ```bash
   php artisan migrate
   ```
