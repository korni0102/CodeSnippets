# CodeSnippets – Laravel Application

**CodeSnippets** is a Laravel-based web application designed to manage, search, and organize Python code snippets. It categorizes snippets according to CRISP-DM phases and supports multilingual functionality (English and Slovak). The application offers role-based access control for guests, registered users, and administrators.

---

## 📋 Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Translation System](#translation-system)
- [Development Tools](#development-tools)
- [Testing](#testing)

---

## 🚀 Features

- **Code Snippet Management**: Create, edit, and archive Python code snippets.
- **Categorization**: Organize snippets based on CRISP-DM phases.
- **Multilingual Support**: Automatic translation of snippets and metadata between English and Slovak.
- **Role-Based Access Control**:
    - *Guest*: View and search snippets.
    - *Registered User*: Create and manage personal snippets.
    - *Administrator*: Manage all snippets and approve user-submitted categories.
- **Search and Filtering**: Full-text search and filtering by category and CRISP-DM phase.
- **User-Friendly Interface**: Responsive design with intuitive navigation.

---

## 🛠️ System Requirements

Ensure the following tools are installed on your system:

- PHP >= 8.1
- Composer
- Node.js and npm
- MySQL

---

## 📦 Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/korni0102/CodeSnippets.git
   cd CodeSnippets
   ```

2. **Install PHP dependencies**:

   ```bash
   composer install
   ```


3. **Copy `.env` file and generate application key**:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure environment variables**:

   Update the `.env` file with your database credentials and other necessary configurations.

---

## ⚙️ Configuration

- **Database**: Set up your MySQL database and update the `.env` file accordingly.
- **Queue**: The application uses the `sync` driver by default. You can change this in the `.env` file (`QUEUE_CONNECTION`).
- **Sanctum**: Laravel Sanctum is used for API authentication.

---

## ▶️ Running the Application

1. **Run migrations**:

   ```bash
   php artisan migrate
   ```

2. **Seed the database**:

   ```bash
   php artisan db:seed
   ```

   This will:

    - Create an admin user.
    - Import code snippets from a structured CSV file using `SnippetsSeeder`.

3. **Start the development server**:

   ```bash
   php artisan serve
   ```

   Access the application at `http://localhost:8000`.

---

## 🌐 Translation System

- **Automatic Translation**: Utilizes [open-google-translator](https://github.com/vidya-hub/open-google-translator) for translating snippets and metadata.
- **Caching**: Translations are cached in JSON files to minimize API calls and improve performance.
- **Fallback Mechanism**: If the translation API fails, the original text is displayed with a notification.

---

## 🧰 Development Tools

- **Laravel Framework**: Backend framework.
- **Blade Templates**: Templating engine for views.
- **Bootstrap 5**: Frontend styling.
- **Select2**: Enhanced select boxes for filtering.
- **Laravel Sanctum**: API authentication.
- **PHPUnit**: Testing framework.

---

## ✅ Testing

Run the test suite using:

```bash
php artisan test
```


