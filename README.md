# 🏥 PDMHS Student Medical System

A secure and comprehensive medical management system built for **President Diosdado Macapagal High School (PDMHS)**. This platform streamlines student health records, clinic consultations, and day‑to‑day clinic operations—helping school health personnel work faster, safer, and smarter.

---

## ✨ Key Features

* **Student Health Records**

  * Centralized medical profiles
  * Medical history, allergies, immunizations, and notes

* **Clinic Consultations**

  * Log visits, diagnoses, treatments, and prescriptions
  * Track follow‑ups and outcomes

* **Secure File Management**

  * Upload and store medical documents and images
  * Controlled access to sensitive records

* **Performance & Reliability**

  * Redis-powered caching and sessions
  * Queue-based background processing for heavy tasks

* **Developer Friendly**

  * Clean code standards
  * Automated testing and containerized setup

---

## 🛠️ Tech Stack

### Backend

* **Laravel (PHP 8.2+)** – Robust MVC framework
* **MySQL – Relational database
* **Redis** – Cache & session management

### Frontend

* **Node.js 18+ & npm** – Asset compilation and tooling

### Development & Tooling

* **Laravel Sail** – Docker-based development environment
* **Laravel Pint** – Code style fixer
* **PHPUnit** – Testing framework
* **Concurrently** – Run multiple dev processes

---

## 🧱 System Architecture

* **Web Layer** – User interface for clinic staff
* **Application Layer** – Business logic and validation
* **Data Layer** – Student records, consultations, and files
* **Infrastructure Services** – Redis, queues, and storage

---

| Name                  | Role(s)                       | Contributions                                                       | Commit Focus               
| --------------------- | ----------------------------- | ------------------------------------------------------------------- | -------------------------- 
| **Clarence Villas**   | UX/UI · Developer · Tech Lead | UI/UX design, system architecture, core development, code review    | Frontend · Backend · UI/UX 
| **Jasmine De Leon**   | Project Manager · Developer   | Project coordination, feature development, testing support          | Backend · Docs · Testing  
| **Krislyn Francisco** | Developer                     | Debugging, documentation                                            | Backend · Docs  

---

## 🚀 Quick Start

### Prerequisites

Make sure you have the following installed:

* PHP **8.2+**
* Composer
* Node.js **18+** and npm
* MySQL **8.0+**
* Git

---

## 📦 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/PDMHS_CLINIC-M.git
cd PDMHS_CLINIC-M/pdmhs_clinic
```

### 2. Install Dependencies & Initial Setup

```bash
composer run setup
```

This command will automatically:

* Install PHP dependencies
* Copy environment configuration
* Generate the application key
* Run database migrations
* Install Node.js dependencies
* Build frontend assets

---

### 3. Configure Environment Variables

```bash
cp .env.example .env
```

Update your `.env` file with the correct database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdmhs_clinic
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 4. Run Database Migrations (if needed)

```bash
php artisan migrate
```

---

## ▶️ Running the Application

Using Laravel Sail:

```bash
./vendor/bin/sail up
```

Or without Docker:

```bash
php artisan serve
```

Access the app at:

```
http://localhost:8000
```

---

## 🧪 Testing

Run automated tests with:

```bash
php artisan test
```

Or directly using PHPUnit:

```bash
vendor/bin/phpunit
```

---

## 🔐 Security Considerations

* Role-based access control for clinic staff
* Encrypted sensitive data
* Secure file storage configuration
* CSRF protection and input validation

> ⚠️ **Note:** This system handles sensitive medical data. Ensure proper server security and access policies in production.

---

## 📁 Project Structure (Simplified)

```
pdmhs_clinic/
├── app/            # Application logic
├── database/       # Migrations & seeders
├── resources/      # Views & frontend assets
├── routes/         # Web & API routes
├── storage/        # Logs & uploaded files
└── tests/          # Automated tests
```

---



✨ Simple. Secure. Student‑Centered.
