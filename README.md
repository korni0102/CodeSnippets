# Laravel Application

This is a Laravel-based web application designed to use MySQL for the database and provides support for features such as queue processing, secure API management with Sanctum, and robust development tools such as PHPUnit for automated testing.

---

## Table of Contents

- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Features](#features)
- [Development Tools](#development-tools)
- [Testing](#testing)
- [Dependencies](#dependencies)

---

## System Requirements

You need the following tools installed on your system to run this project:

- PHP 8.1 or higher
- Composer
- Node.js (with `npm`)
- MySQL

---

## Installation

1. Clone the repository:

   ```bash
   git clone <repo-url>
   cd <repo-directory>
   ```

2. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env` and configure your environment variables:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Set up the database:

    - Create a new MySQL database.
    - Update the `.env` file with your database credentials.

---

## Configuration

- **Database**: Update your `.env` file to include the correct MySQL database credentials.
- **Queue**: The application is set to use a `sync` queue driver by default, which processes jobs synchronously. This can be adjusted in the `.env` file (`QUEUE_CONNECTION`).

---

## Running the Application

1. Migrate the database:

   ```bash
   php artisan migrate
   ```

2. (Optional) Seed the database with test data:

   ```bash
   php artisan db:seed
   ```

3. Run the development server:

   ```bash
   php artisan serve
   ```

---

## Features

- **Secure Authentication**: Powered by Laravel Sanctum.
- **Database Management**: Uses MySQL for data persistence.
- **API Development**: Offers robust API development standards with Sanctum for token-based authentication.
- **Queue Management**: Queue system (currently `sync`) for deferred task handling.
- **Scheduling**: Integrated support for task scheduling using the `dragonmantank/cron-expression`.
- **Testing**: Pre-configured with PHPUnit for automated testing.

---

## Development Tools

The following tools and packages are used to enhance development:

- **PHPUnit**: For testing your PHP code.
- **Mockery/Mockery**: Provides mocking and test double functionalities.
- **FakerPHP/Faker**: Generates fake data for development.
- **Laravel Sail**: Offers a lightweight development environment for Docker.
- **Laravel Tinker**: Provides a REPL for direct interaction with your Laravel code.
- **Laravel IDE Helper**: Offers code completion for IDEs like PhpStorm.

---
