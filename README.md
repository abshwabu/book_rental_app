### **Day 1: Detailed Progress Report**

---

**Project Name**: Book Rental Application  
**Frameworks/Tools**: Laravel, Blade, MySQL, Laravel Sanctum for Authentication  
**Date**: 22/09/2024

---

### **Tasks Accomplished**:

#### 1. **Laravel Installation and Environment Setup**
   - **Installed Laravel**: The Laravel project was successfully installed using the command:
     ```bash
     composer create-project --prefer-dist laravel/laravel book_rental_app
     ```
   - **Configured `.env` File**: The `.env` file was updated with appropriate MySQL database credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=book_rental
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```
   - **Project Structure**: Verified that all Laravel directories (`routes`, `resources/views`, `app/Models`, etc.) are in place for future development.

---

#### 2. **MySQL Database Setup**
   - **Database Created**: A MySQL database named `book_rental` was created.
   - **Ran Initial Migrations**: The default Laravel migrations (e.g., `users` table) were successfully run to create the necessary tables in the database.

     **Issues Faced**: 
     - There were initial issues with duplicate migrations, especially with the `books` and `rentals` tables.
     - Errors related to foreign key constraints and duplicate columns were encountered.
     - **Resolution**: 
       - A migration file for modifying the `rentals` table was created, ensuring no duplicate columns.
       - The foreign key relationship between `books` and `categories` was fixed by ensuring that the `categories` table was created before the `books` table.
     - Successfully ran all migrations, ensuring all tables were properly created.

---

#### 3. **Authentication Setup (Laravel Sanctum)**
   - **Chose Laravel Sanctum**: Decided to use **Sanctum** for user authentication, with token-based authentication for API routes and cookie-based session handling for the web interface.
   - **Sanctum Installation**:
     - Installed Sanctum using the command:
       ```bash
       composer require laravel/sanctum
       ```
     - Published Sanctum configuration:
       ```bash
       php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
       ```
     - Migrated the Sanctum tables using:
       ```bash
       php artisan migrate
       ```

   
   - **Routes for Authentication**: Defined the routes in `routes/api.php` for:
     - **Register**: `POST /register`
     - **Login**: `POST /login`
     - **Logout**: `POST /logout` (protected by Sanctum’s `auth:sanctum` middleware)
   
   - **AuthController**:
     - Implemented the following methods in the `AuthController`:
       - `register()`: Handles user registration and token issuance.
       - `login()`: Authenticates users and issues tokens.
       - `logout()`: Revokes tokens on logout.

---

#### 4. **Frontend Framework Selection**
   - **Frontend Framework Chosen**: **Blade** templates were selected as the frontend framework for the project. This decision ensures tight integration with Laravel's routing and templating system, allowing for a clean and maintainable UI.
   
---

#### 5. **Basic Blade Layout and Route Setup**
   - **Blade Layout Created**:
     - A reusable layout template (`layout.blade.php`) was created under `resources/views/layouts`:
       ```php
       <!DOCTYPE html>
       <html lang="en">
       <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <meta name="csrf-token" content="{{ csrf_token() }}">
           <title>Book Rental App</title>
           <link rel="stylesheet" href="{{ asset('css/app.css') }}">
       </head>
       <body>
           <header>
               <h1>Book Rental Application</h1>
           </header>
       
           <main>
               @yield('content')
           </main>
       
           <footer>
               <p>&copy; 2024 Book Rental App</p>
           </footer>
       
           <script src="{{ asset('js/app.js') }}"></script>
       </body>
       </html>
       ```

   - **Home Page Setup**:
     - A `home.blade.php` file was created as a basic home page to verify the Blade templating system:
       ```php
       @extends('layouts.layout')

       @section('content')
           <div class="container">
               <h2>Welcome to the Book Rental App</h2>
               <p>Browse and rent books in your neighborhood!</p>
           </div>
       @endsection
       ```
   - **Route Configuration**:
     - Added a route for the home page in `routes/web.php`:
       ```php
       Route::get('/', function () {
           return view('home');
       })->name('home');
       ```

   - **Tested Blade Layout**: Verified the basic Blade layout by accessing the home page via `http://localhost:8000`.

---

### **Challenges Encountered**:
   - **Foreign Key Issues**: There were initial problems with foreign key constraints when creating relationships between the `books` and `categories` tables, but this was resolved by ensuring the correct order of migration execution.
   - **Duplicate Column Errors**: While modifying the `rentals` table, duplicate column errors occurred. This was resolved by adjusting the migration to check for existing columns before adding new ones.

---

### **Conclusion**:
By the end of **Day 1**, the foundation for the **book rental application** has been successfully laid down:
- Laravel is installed and properly configured.
- Database structure is set up, including migrations for users, books, rentals, and categories.
- Authentication is handled securely using **Laravel Sanctum**.
- **Blade** templates are in place, and the basic home page and layout have been implemented.

The project is now well-prepared for further development, including building out user dashboards, book management, and more.
