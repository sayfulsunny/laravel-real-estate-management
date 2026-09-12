Real Estate Management System
A Laravel-based real estate management system designed to manage projects, customers, installments, income, expenses, commissions, financial reports, users, roles, permissions, and promotional SMS from a centralized dashboard.

📸 Screenshots
Dashboard
Project Management
Customer Management
Installment Management
Reports
✨ Features
Dashboard
Centralized dashboard
Overview of projects and financial activities
Quick access to major modules
Customer Management
Customer management
Customer information tracking
Customer summary reports
Project Management
Project management
Project-wise information
Project expense management
Project reports
Installment Management
Installment management
Installment tracking
Customer installment information
Income & Expense Management
Income management
Project expense management
Expense categorization
Category-wise expense reports
Yearly financial reports
Commission Management
Commission management
Commission withdrawal
Commission withdrawal history
Commission-related reporting
Reporting
Commission reports
Project reports
Expense reports
Category expense reports
Yearly financial reports
Customer summary reports
Promotional SMS
Promotional SMS management
Customer communication support
User & Permission Management
User management
Role management
Permission management
Role-based access control
Backup
Database/system backup functionality
🛠️ Technology Stack
Backend: Laravel / PHP
Database: MySQL
Frontend: Blade, HTML, CSS, JavaScript
Version Control: Git & GitHub
📋 Requirements
Before installing this project, make sure you have:

PHP
Composer
MySQL
Node.js & NPM
Laravel-compatible web server or Laravel development server
⚙️ Installation
1. Clone the repository
git clone https://github.com/sayfulsunny/laravel-real-estate-management.git

2. Go to the project directory
cd laravel-real-estate-management

3. Install PHP dependencies
composer install

4. Install frontend dependencies
npm install

5. Create environment file
Copy .env.example to .env:

cp .env.example .env

For Windows PowerShell:

Copy-Item .env.example .env

6. Generate application key
php artisan key:generate

7. Configure database
Update your .env file with your MySQL database information:

DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

8. Run migrations
php artisan migrate

If the project requires seed data:

php artisan db:seed

9. Build frontend assets
npm run build

10. Start the Laravel development server
php artisan serve

The application will be available at:

http://127.0.0.1:8000

🔐 Authentication & Access Control
The system includes user, role, and permission management to control access to different modules according to user roles.

📊 Reporting
The system provides multiple reports to help monitor business and financial activities, including:

Commission Report
Commission Withdrawal History
Project Report
Expense Report
Category Expense Report
Yearly Financial Report
Customer Summary Report
💾 Backup
The system includes backup functionality to help protect important application data.

📱 Promotional SMS
The system includes promotional SMS functionality for communicating with customers.

🚀 Future Improvements
Potential future improvements may include:

Online payment integration
Customer portal
REST API
Advanced analytics dashboard
Automated notifications
Online property booking
Cloud-based backup
Production deployment
👨‍💻 Developer
Sayful Islam

GitHub: @sayfulsunny

📄 License
This project is developed for portfolio and demonstration purposes.