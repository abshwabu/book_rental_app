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
**Date**: 23/09/2024

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

### **Day 3: Detailed Progress Report**

---

**Project Name**: Book Rental Application  
**Frameworks/Tools**: Laravel 11, Blade, MySQL, Laravel Sanctum  
**Date**: 24/09/2024

---

### **Objectives for Day 3**:
1. **Implement Book Management Features for Owners**:
   - Edit Book Feature: Allow owners to edit details of their uploaded books.
   - Delete Book Feature: Provide functionality to delete books from the system.
   - Search and Filter Books: Implement a search feature for owners to find their books easily.
2. **Admin Feature Implementation**:
   - Set up an admin role.
   - Create an admin dashboard for managing users and books.
   - Allow the admin to view, activate, deactivate, or delete users.
   - Allow the admin to manage all books in the system.

---

### **Tasks Completed**:

#### **1. Edit Book Feature**
- **Route Definition**: Created routes for editing a book and handling the update.

    ```php
    Route::get('/owner/books/{book}/edit', [OwnerController::class, 'edit'])->name('owner.books.edit');
    Route::put('/owner/books/{book}', [OwnerController::class, 'update'])->name('owner.books.update');
    ```

- **Controller Implementation**: 
    - Implemented `edit()` to show the edit form for the selected book.
    - Implemented `update()` to handle the form submission, validate inputs, and update the book record.

    ```php
    public function edit(Book $book)
    {
        // Check ownership and return the edit view
        return view('owner.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        // Validate input and update the book
    }
    ```

- **Edit Book Blade View**: Created a Blade view that pre-fills the book's current data in a form, allowing the owner to update details.

    ```html
    <form action="{{ route('owner.books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Form fields for editing book -->
    </form>
    ```

---

#### **2. Delete Book Feature**
- **Route Definition**: Added a route for deleting books.

    ```php
    Route::delete('/owner/books/{book}', [OwnerController::class, 'destroy'])->name('owner.books.destroy');
    ```

- **Controller Implementation**: 
    - Implemented `destroy()` to delete the book after confirming the ownership and confirming deletion.

    ```php
    public function destroy(Book $book)
    {
        // Check ownership and delete the book
    }
    ```

- **Delete Button in Dashboard**: Added a delete button for each book in the owner’s dashboard, with a confirmation prompt.

    ```html
    <form action="{{ route('owner.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    ```

---

#### **3. Search and Filter Books**
- **Search Bar Implementation**: Added a search form to the owner's dashboard to allow searching books by title or category.

    ```html
    <form action="{{ route('owner.dashboard') }}" method="GET">
        <input type="text" name="search" placeholder="Search by title or category" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>
    ```

- **Controller Modification**: Updated the `index()` method in `OwnerController` to handle search queries and filter the displayed books.

    ```php
    public function index(Request $request)
    {
        // Fetch books based on search query
    }
    ```

---

#### **4. Admin Feature Implementation**
- **Admin Role Setup**: 
    - Created a `role` field in the `users` table to assign roles (e.g., `admin`, `owner`, `renter`).

- **Middleware for Admin**: 
    - Implemented an `AdminMiddleware` class to restrict access to admin routes.

    ```php
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        return redirect('/')->withErrors('Access denied. Admins only.');
    }
    ```

- **Admin Routes**: Defined routes for the admin dashboard and user management.

    ```php
    Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    });
    ```

- **Admin Dashboard**: Created the admin dashboard view to display the number of users and books.

    ```html
    <h2>Admin Dashboard</h2>
    <p>Total Users: {{ $userCount }}</p>
    <p>Total Books: {{ $bookCount }}</p>
    ```

- **Manage Users**: Implemented the `users()` method in `AdminController` to fetch and display all users.

    ```php
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    ```

- **Manage Books**: Created functionality to view and manage all books in the system.

---

### **Challenges Faced**:
- Adjusting to the removal of `Kernel.php` in Laravel 11 required modifications in how middleware is defined and used.
- Ensuring that all routes and functionalities were adequately protected by middleware to prevent unauthorized access.

---

### **Next Steps**:
1. **Admin Functionality Enhancements**: 
   - Add features for activating or deactivating users.
   - Provide additional controls for managing books (e.g., adding or editing books).
2. **Styling and UI Improvements**: 
   - Enhance the user interface using CSS or a front-end framework for better usability and aesthetics.

---

### **Conclusion**:
Day 3 has been successfully completed! You have implemented:
- **Book management features** for owners (editing, deleting, searching).
- **Admin features** including user management and an admin dashboard.


### **Day 4: Detailed Progress Report**

---

**Project Name**: Book Rental Application  
**Frameworks/Tools**: Laravel 11, Blade, MySQL, Laravel Sanctum  
**Date**: 25/09/2025 

---

### **Objectives for Day 4**:
1. **Owner Dashboard Enhancement**:
   - Display books uploaded by owners in their dashboard.
2. **Renter Dashboard Enhancement**:
   - Display books rented by renters in their dashboard.
3. **Fix Format Error in Date Fields**:
   - Resolve the issue of calling `format()` on a string instead of a `Carbon` date instance.
4. **Sidebar Layout Fix**:
   - Ensure that the content displays correctly beside the sidebar and not below it.

---

### **Tasks Completed**:

#### **1. Owner Dashboard Enhancement**
- **Objective**: Allow owners to view the books they have uploaded in the dashboard.
  
- **Steps Taken**:
   - Added logic in `OwnerController` to retrieve books based on the logged-in owner’s ID.
   - The `index()` method in `OwnerController` was updated to fetch the books using the `Book::where('owner_id', Auth::id())` query.
   - In `resources/views/owner/dashboard.blade.php`, a table was created to display the owner’s uploaded books, including options to **edit** and **delete** each book.

- **Outcome**: Owners can now see a list of all the books they have uploaded on their dashboard, complete with actions to edit or delete each book.

---

#### **2. Renter Dashboard Enhancement**
- **Objective**: Allow renters to view the books they have rented.
  
- **Steps Taken**:
   - Added logic in `RenterController` to retrieve books based on the logged-in renter’s rental records.
   - The `index()` method in `RenterController` was updated to use the `Rental::with('book')->where('renter_id', Auth::id())` query to fetch rentals.
   - The `Rental` model was updated with a relationship to the `Book` model to ensure proper data retrieval.
   - In `resources/views/renter/dashboard.blade.php`, a table was created to display rented books, along with details like the **rented date** and **due date**.

- **Outcome**: Renters can now see a list of books they have rented on their dashboard, with key information about the rental such as due date and rental price.

---

#### **3. Fix Format Error for Date Fields**
- **Objective**: Fix the error `Call to a member function format() on string` when trying to format the `rented_on` and `due_date` fields.

- **Steps Taken**:
   - The `Rental` model was updated with the `protected $dates = ['rented_on', 'due_date'];` property, which automatically casts the `rented_on` and `due_date` fields as `Carbon` instances.
   - The Blade views were updated to safely call `format()` on these fields to display them in the desired format (e.g., `Y-m-d`).

- **Alternative Solution (Implemented for String Dates)**:
   - For cases where dates are stored as strings, the `\Carbon\Carbon::parse()` method was used in the Blade views to manually parse the dates.

- **Outcome**: The error has been resolved, and the date fields (e.g., `rented_on`, `due_date`) are now properly formatted using `format()`.

---

#### **4. Sidebar Layout Fix**
- **Objective**: Ensure that the content displays correctly beside the sidebar, not below it.

- **Steps Taken**:
   - The layout in `resources/views/layouts/app.blade.php` was adjusted to ensure proper usage of Flexbox. The `#wrapper` div and `content-wrapper` were correctly structured to follow the SB Admin 2 layout guidelines.
   - The CSS from SB Admin 2 was loaded properly using `{{ asset('css/sb-admin-2.min.css') }}` in the Blade layout to ensure that the Flexbox layout is respected.
   - JavaScript and jQuery files were included to ensure responsive functionality of the sidebar.

- **Outcome**: The sidebar now correctly displays beside the content instead of below it, ensuring proper use of space and layout.

---

### **Challenges Faced**:
1. **Date Format Error**: Encountered an issue with calling `format()` on string fields in the database, which was fixed by casting the fields to `Carbon` instances in the model.
2. **Sidebar Layout**: There was some misalignment in the layout, where the content was being pushed below the sidebar. This was resolved by properly structuring the Flexbox layout and ensuring the SB Admin 2 styles were applied.

---

### **Next Steps**:
1. **Owner and Renter Features**:
   - Expand functionality for owners to manage their books more effectively (e.g., adding categories or filtering options).
   - Add functionality for renters to return books or extend rental periods.
2. **Admin Dashboard Improvements**:
   - Implement more detailed analytics for the admin, such as showing the total number of active rentals, overdue books, and active users.
3. **Notifications**:
   - Add a notification system for renters when a rental is due soon or overdue.

---

### **Conclusion**:
Day 4 has been successfully completed with the following achievements:
- Owners can view and manage their books on their dashboard.
- Renters can see their rented books with relevant details.
- Admins can view and manage books and user on their dashboard.
