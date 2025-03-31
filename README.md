# CodeSnippets
Code Snippets web aplikácia - Diplomová práca

## Project Overview
A modern web application serving as a centralized repository for code snippets with user authentication and search functionality. The platform allows developers to store, organize, and discover useful code segments across multiple programming languages.

## Key Features
User Authentication: Secure registration and login system
Code Snippet Management: Upload, edit and organize code snippets
Powerful Search: Find snippets by language, tags or content
Modular Architecture: Easy to extend with new features
Developer-Friendly: Designed with modern development workflows in mind

## Technology Stack
Frontend: Vue.js (progressive framework for building UIs)
Backend: Laravel (PHP framework for web artisans)
Database: MySQL/PostgreSQL
Development Environment:
PHPStorm as primary IDE
Docker for containerized development
WSL (Windows Subsystem for Linux) for Linux compatibility

## Project Setup
Docker installed and running
WSL configured (for Windows users)
PHPStorm or other compatible IDE

### Clone the repository
```
git clone [repository-url]
cd code-snippet-repo
```

### Install PHP dependencies
```
composer install
```

### Install JavaScript dependencies
```
npm install
```

### Configure environment
Copy .env.example to .env and update database credentials

### Database setup
```
php artisan migrate
php artisan db:seed
```

### Start development servers
```
php artisan serve
npm run dev
```
