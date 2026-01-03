# PDMHS Student Medical System

A comprehensive medical management system designed specifically for PDMHS (Pedro Diaz Memorial High School) to streamline student health records, medical consultations, and clinic operations.

## Key Features

### 🏥 Medical Records Management
- **Student Health Profiles** - Complete medical history tracking for each student
- **Medical Consultation Records** - Detailed visit logs with symptoms, diagnosis, and treatments
- **Health Screening** - Annual health checkups and vaccination tracking
- **Medical Certificate Generation** - Automated medical clearance and fitness certificates

### 👨‍⚕️ Healthcare Provider Tools
- **/Nurse Dashboard** - Centralized view of daily appointments and patient queue
- **Prescription Management** - Digital prescription creation and medication tracking
- **Medical Inventory** - Medicine stock monitoring and supply management
- **Emergency Response** - Quick access to critical student medical information

### 📊 Administrative Features
- **Student Registration** - Comprehensive student enrollment with medical data
- **Adviser Integration** - Class adviser access to student health summaries
- **Report Generation** - Health statistics, incident reports, and compliance documentation
- **User Management** - Role-based access control for different staff levels

### 🔒 Security & Compliance
- **HIPAA-Compliant** - Secure handling of sensitive medical information
- **Audit Trail** - Complete logging of all medical record access and modifications
- **Data Backup** - Automated backup systems for data protection
- **Access Controls** - Multi-level authentication and authorization

## Tech Stack

### Backend
- **PHP 8.2+** - Modern PHP with latest features and performance improvements
- **Laravel 12** - Robust PHP framework with elegant syntax and powerful features
- **MySQL/PostgreSQL** - Reliable database management for medical records
- **Laravel Sanctum** - API authentication for secure mobile/web access

### Frontend
- **Tailwind CSS 4.0** - Utility-first CSS framework for responsive design
- **Vite** - Fast build tool and development server
- **Axios** - HTTP client for API communication
- **Blade Templates** - Laravel's templating engine for server-side rendering

### Development Tools
- **Laravel Pint** - Code style fixer for consistent formatting
- **PHPUnit** - Comprehensive testing framework
- **Laravel Sail** - Docker development environment
- **Concurrently** - Run multiple development processes simultaneously

### Infrastructure
- **Docker** - Containerized development and deployment
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

5. **Seed initial data (optional)**
   ```bash
   php artisan db:seed
   ```

### Development

**Start development server**
```bash
composer run dev
```
This will start:
- Laravel development server (http://localhost:8000)
- Queue worker for background jobs
- Log monitoring with Laravel Pail
- Vite development server for hot reloading

**Run tests**
```bash
composer run test
```

**Code formatting**
```bash
./vendor/bin/pint
```

### Production Deployment

1. **Build for production**
   ```bash
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Set up queue worker**
   ```bash
   php artisan queue:work --daemon
   ```

3. **Configure web server** (Apache/Nginx) to point to `public/` directory

## Git Workflow Guidelines

### Branch Naming Convention
- `main` - Production-ready code
- `develop` - Integration branch for features
- `feature/feature-name` - New features (e.g., `feature/patient-registration`)
- `bugfix/issue-description` - Bug fixes (e.g., `bugfix/login-validation`)
- `hotfix/critical-issue` - Critical production fixes
- `release/version-number` - Release preparation (e.g., `release/v1.2.0`)

### Commit Message Format
```
type(scope): brief description

Detailed explanation of changes (if needed)

- List specific changes
- Reference issue numbers (#123)
```

**Types:**
- `feat` - New feature
- `fix` - Bug fix
- `docs` - Documentation changes
- `style` - Code formatting (no logic changes)
- `refactor` - Code restructuring
- `test` - Adding or updating tests
- `chore` - Maintenance tasks

**Examples:**
```bash
feat(auth): add two-factor authentication for medical staff
fix(reports): resolve date filtering in health statistics
docs(api): update medical records endpoint documentation
```

### Development Workflow

1. **Create feature branch**
   ```bash
   git checkout develop
   git pull origin develop
   git checkout -b feature/your-feature-name
   ```

2. **Make changes and commit**
   ```bash
   git add .
   git commit -m "feat(medical): add patient allergy tracking"
   ```

3. **Push and create pull request**
   ```bash
   git push origin feature/your-feature-name
   ```
   Create PR to `develop` branch with:
   - Clear description of changes
   - Screenshots for UI changes
   - Test coverage information
   - Breaking changes (if any)

4. **Code review process**
   - At least one reviewer required
   - All tests must pass
   - Code style checks must pass
   - Security review for medical data handling

5. **Merge to develop**
   - Use "Squash and merge" for clean history
   - Delete feature branch after merge

### Release Process

1. **Create release branch**
   ```bash
   git checkout develop
   git checkout -b release/v1.x.x
   ```

2. **Prepare release**
   - Update version numbers
   - Update CHANGELOG.md
   - Final testing and bug fixes

3. **Merge to main**
   ```bash
   git checkout main
   git merge release/v1.x.x
   git tag v1.x.x
   git push origin main --tags
   ```

4. **Merge back to develop**
   ```bash
   git checkout develop
   git merge main
   ```

### Important Notes
- **Never commit directly to `main`**
- **Always test medical data handling thoroughly**
- **Include database migration files in commits**
- **Update documentation for API changes**
- **Follow HIPAA compliance in all code changes**
- **Use meaningful commit messages for audit trails**

---

## Contributing

Please read our [Contributing Guidelines](CONTRIBUTING.md) and [Code of Conduct](CODE_OF_CONDUCT.md) before submitting contributions.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For technical support or questions about the PDMHS Student Medical System:
- Create an issue in this repository
- Contact the development team
- Check the [Wiki](../../wiki) for detailed documentation