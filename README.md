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

### **Day 2: Detailed Progress Report**

---

**Project Name**: Book Rental Application  
**Frameworks/Tools**: Laravel, Blade, MySQL, Laravel Sanctum  
**Date**: Day 2 of 10  

---

### **Objectives for Day 2**:
1. Break down the UI into reusable components.
2. Create the **Book Owner's Dashboard**:
   - Display books uploaded by the owner.
   - Include a form for uploading new books.
   - Implement field validations and enum handling (for status and category).
3. Create the **Renter's Dashboard**:
   - Display available books for rent.
4. Ensure that the dashboards are connected to the proper routes and middleware.

---

### **Tasks Completed**:

#### **1. UI Modular Design with Blade Components**
   - **Navbar Component**: Created a reusable `navbar` Blade component that is displayed across all pages. The component dynamically displays navigation links for authenticated users, including links to the home page, owner dashboard, and login/logout routes.
   
     ```php
     <nav>
         <ul>
             <li><a href="{{ route('home') }}">Home</a></li>
             @auth
                 <li><a href="{{ route('owner.dashboard') }}">Owner Dashboard</a></li>
                 <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                     @csrf
                     <button type="submit">Logout</button>
                 </form>
             @else
                 <li><a href="{{ route('login') }}">Login</a></li>
                 <li><a href="{{ route('register') }}">Register</a></li>
             @endauth
         </ul>
     </nav>
     ```

   - **Footer Component**: Added a simple footer with basic layout to make it reusable across different views.

#### **2. Book Owner's Dashboard**
   - **Route Setup**: Defined a route to display the book owner's dashboard and added middleware to protect the route using Sanctum's authentication.
     ```php
     Route::middleware('auth:sanctum')->group(function () {
         Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
         Route::get('/owner/books/create', [OwnerController::class, 'create'])->name('owner.books.create');
         Route::post('/owner/books', [OwnerController::class, 'store'])->name('owner.books.store');
     });
     ```

   - **OwnerController**: 
     - Implemented the `index()` method to display the list of books uploaded by the owner.
     - Implemented the `create()` and `store()` methods to handle book creation with validation.
     - Handled various book fields like `title`, `author`, `category`, `quantity`, `rental_price`, and `status`.

     ```php
     public function index()
     {
         if (Auth::user()->role !== 'owner') {
             return redirect()->route('home')->withErrors('Access denied.');
         }

         $books = Auth::user()->books;
         return view('owner.dashboard', compact('books'));
     }

     public function create()
     {
         return view('owner.books.create');
     }

     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'author' => 'required|string|max:255',
             'category' => 'required|string',
             'quantity' => 'required|integer|min:1',
             'rental_price' => 'required|numeric',
             'status' => 'required|in:available,unavailable',
         ]);

         $book = new Book([
             'title' => $request->title,
             'author' => $request->author,
             'category' => $request->category,
             'quantity' => $request->quantity,
             'rental_price' => $request->rental_price,
             'status' => $request->status,
         ]);

         Auth::user()->books()->save($book);

         return redirect()->route('owner.dashboard')->with('status', 'Book added successfully!');
     }
     ```

   - **Book Creation Form**: Created a form for owners to upload new books, including fields for `title`, `author`, `category`, `quantity`, `rental_price`, and `status` (enum values).
     - Added a dropdown for `category` and `status` fields to handle enum selections in the form.

     ```html
     <form action="{{ route('owner.books.store') }}" method="POST">
         @csrf
         <div class="form-group">
             <label for="title">Book Title:</label>
             <input type="text" name="title" id="title" required>
         </div>
         <div class="form-group">
             <label for="author">Author:</label>
             <input type="text" name="author" id="author" required>
         </div>
         <div class="form-group">
             <label for="category">Category:</label>
             <select name="category" id="category">
                 <option value="Fiction">Fiction</option>
                 <option value="Science">Science</option>
             </select>
         </div>
         <div class="form-group">
             <label for="quantity">Quantity:</label>
             <input type="number" name="quantity" id="quantity" min="1" required>
         </div>
         <div class="form-group">
             <label for="rental_price">Rental Price:</label>
             <input type="number" name="rental_price" id="rental_price" required>
         </div>
         <div class="form-group">
             <label for="status">Status:</label>
             <select name="status" id="status">
                 <option value="available">Available</option>
                 <option value="unavailable">Unavailable</option>
             </select>
         </div>
         <button type="submit">Add Book</button>
     </form>
     ```

   - **Validations**: Implemented server-side validation for all the fields, ensuring that only valid data is stored in the database.

#### **3. Renter's Dashboard**
   - **Route Setup**: Added a route for the renter’s dashboard to list all available books for rent.

     ```php
     Route::middleware('auth:sanctum')->group(function () {
         Route::get('/renter/dashboard', [RenterController::class, 'index'])->name('renter.dashboard');
     });
     ```

   - **RenterController**: Implemented the `index()` method to display a list of available books for rent. Only books with a `status` of `available` are shown.

     ```php
     public function index()
     {
         $books = Book::where('status', 'available')->get();
         return view('renter.dashboard', compact('books'));
     }
     ```

   - **Renter Dashboard View**: Created a Blade template to display the available books for rent, including their title, author, category, rental price, and quantity.

     ```html
     @extends('layouts.layout')

     @section('content')
     <div class="container">
         <h2>Available Books for Rent</h2>
         @if($books->isEmpty())
             <p>No books available for rent at the moment.</p>
         @else
             <ul>
                 @foreach ($books as $book)
                     <li>
                         <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                         Category: {{ $book->category }}<br>
                         Price: {{ $book->rental_price }} Birr<br>
                         Quantity: {{ $book->quantity }}<br>
                     </li>
                     <hr>
                 @endforeach
             </ul>
         @endif
     </div>
     @endsection
     ```

#### **4. Enum Handling and Default Values**
   - Added `enum` handling for **status** and **category** fields.
   - Made the `quantity` field a required field with validation to ensure it is always populated.

---

### **Challenges Faced**:
- Initial issues with missing default values for the `quantity` and `category` fields were resolved by adding validation rules and ensuring these fields are handled in the form.
- Error with the `category` field was fixed by adding dropdown options in the book creation form and validation in the controller.

---

### **Next Steps**:
1. Add basic CSS or Bootstrap to enhance the UI/UX for both the **owner’s** and **renter’s** dashboards.
2. Add features for **renting** books from the **renter’s dashboard** (optional).

---

### **Conclusion**:
Day 2 is complete! We successfully built:
- **UI Modular Design** with reusable Blade components.
- **Owner’s Dashboard** for managing books, including a form to add books.
- **Renter’s Dashboard** to browse available books for rent.
- Handled **enum fields** (status and category) in both forms and views.
