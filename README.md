# PDMHS Student Medical System

A comprehensive medical management system for Pedro Diaz Memorial High School (PDMHS) built with Laravel 12. The system manages student health records, clinic operations, and medical consultations with role-based access for Students, Clinic Staff, and Class Advisers.

## Key Features

### 🏥 Student Health Management
- **Complete Health Records** - Student profiles with medical history, allergies, medications, and family history
- **Vital Signs Tracking** - Temperature, blood pressure, heart rate, respiratory rate, weight, height with BMI calculation
- **Medical Visit Records** - Detailed clinic visits with symptoms, diagnoses, treatments, and medications
- **Immunization Tracking** - Vaccination records with due dates and batch numbers
- **Allergy Management** - Track student allergies with severity levels (Mild/Moderate/Severe)
- **Health Incidents** - Record accidents and health emergencies with follow-up actions

### 👨‍⚕️ Clinic Operations
- **QR Code Scanning** - Quick student lookup via QR code scanning
- **Visit Management** - Create, update, and track clinic visits with status (pending/in_progress/completed)
- **Student Search** - Search students by name or student ID
- **Follow-up Tracking** - Schedule and track required follow-up appointments
- **Emergency Response** - Quick access to critical student medical information

### 📊 Health Reports & Analytics
- **Visit Statistics** - Total visits, chronic cases (3+ visits), emergency cases, hospital referrals
- **Health Analytics** - Cases by illness/diagnosis and grade level distribution
- **Date Range Filtering** - Generate reports for specific time periods
- **Grade Level Analysis** - Filter data by student grade levels
- **Export Capabilities** - PDF and Excel export (planned feature)

### 👥 Role-Based Access Control
- **Students** - View personal health records, medical history, and profile management
- **Clinic Staff** - Full clinic operations, student management, and health reporting
- **Class Advisers** - View assigned students' health summaries and medical records
- **Admin** - Complete system administration and user management

### 🔒 Security Features
- **Authentication System** - Secure login with role-based routing
- **Session Management** - Keep-alive functionality and session monitoring
- **Profile Management** - Secure profile updates with password changes
- **Data Protection** - Proper access controls for sensitive medical information

## Tech Stack

### Backend
- **PHP 8.2+** - Modern PHP with latest features
- **Laravel 12** - Latest Laravel framework with enhanced performance
- **MySQL/SQLite** - Flexible database configuration
- **Laravel Sanctum** - API authentication for secure access

### Frontend
- **Tailwind CSS 4.0** - Utility-first CSS framework for responsive design
- **Vite** - Fast build tool and development server
- **Axios** - HTTP client for API communication
- **Blade Templates** - Laravel's templating engine

### Development Tools
- **Laravel Pint** - Code style fixer for consistent formatting
- **PHPUnit** - Comprehensive testing framework
- **Laravel Sail** - Docker development environment
- **Concurrently** - Run multiple development processes

### Infrastructure
- **Docker Support** - Containerized development and deployment
- **Redis** - Caching and session management
- **Queue System** - Background job processing
- **File Storage** - Secure document and image management

## Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+ or SQLite
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/PDMHS_CLINIC-M.git
   cd PDMHS_CLINIC-M/pdmhs_clinic
