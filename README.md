# 🛒 Laravel E-commerce Backend API

A scalable and API-first **Laravel E-commerce Backend** designed to manage products, categories, brands, and media uploads using clean architecture and RESTful principles. This project serves as a solid foundation for building full-featured e-commerce platforms.

---

## 🚀 Overview

This backend provides core e-commerce functionalities required for modern applications, including product management, secure image handling, pagination, validation, and structured API responses. It is built to integrate seamlessly with frontend frameworks and mobile applications.

---

## ✨ Features

-   Product, Category, and Brand management
-   Full CRUD operations
-   Secure image upload & replacement
-   Pagination for large datasets
-   Validation & centralized error handling
-   RESTful API architecture
-   API-first design (frontend agnostic)
-   Clean and scalable code structure

---

## 🧱 Tech Stack

-   **Backend:** Laravel
-   **Database:** MySQL
-   **Language:** PHP
-   **API Style:** REST
-   **File Handling:** Public storage uploads

---

## 📁 Project Structure

app/
├── Http/Controllers/ # API controllers
├── Models/ # Eloquent models
database/
├── migrations/ # Database schema
public/
└── assets/uploads/ # Uploaded images
routes/
└── api.php # API routes

---

## 🔗 Entity Relationships

-   Product belongs to Category
-   Product belongs to Brand
-   Category has many Products
-   Brand has many Products

---

## 🔧 Installation & Setup

```bash
git clone https://github.com/Ahmed-Shoman/Api-Ecommerce-project.git
cd Api-Ecommerce-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
