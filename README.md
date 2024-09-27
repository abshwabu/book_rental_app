### **Day 6 Report**

**Date:** [Insert Date]

**Objective:**  
Continue enhancing the admin and user experience by adding advanced features, such as integrating detailed statistics and improving the functionality of the book management system.

---

**Tasks Completed:**

1. **Advanced Admin Statistics & Visualizations**
   - **Implemented new admin statistics**:
     - Added the ability for the admin dashboard to display top rented books and most active renters.
     - Enhanced the statistics by showing detailed data on total users, books, and most rented books over time.
   - **Visual Enhancements**:
     - Used a table format for easy visualization of data in the admin dashboard, including active users and book statistics.

2. **Review and Rating System for Books**
   - **Review Functionality**:
     - Enabled renters to leave reviews and rate books after renting them.
     - Created a `Review` model and set up necessary migrations to store book reviews.
     - Modified the renter dashboard to allow submitting reviews and ratings.
     - Implemented review submission logic in the `RentalController` to handle review form data.
   - **Form Updates**:
     - Updated the book details form to include a review submission section, where renters can write feedback and rate the books they’ve rented.

3. **Owner Reports for Rentals**
   - **Report Generation**:
     - Added the ability for owners to generate reports detailing the rentals of their books.
     - Implemented report views that list all rentals for the books uploaded by the owner, including renter details, rented date, and due dates.
   - **Controller Updates**:
     - Created a `report()` method in `OwnerController` to fetch and display the rental information for the owner’s books.
     - Created a new view to present the rental reports in a tabular format.

4. **Security Enhancements**
   - **Improved Authentication**:
     - Strengthened security with proper access control for owners, renters, and admins by making use of Laravel’s policies and gates.
     - Applied rate limiting on critical actions, such as login attempts, to mitigate brute force attacks.

5. **Book Cover Image Implementation**
   - **Updated Forms**:
     - Modified the book creation and editing forms to include a file input for uploading cover images.
   - **Controller Logic**:
     - Implemented file upload handling in the `store()` and `update()` methods of the `OwnerController` to manage cover images.
   - **Display Logic**:
     - Displayed the uploaded cover images in the owner and renter dashboards using `asset()`.

6. **Handle Book Quantity Issue**
   - **SQL Error Fix**:
     - Addressed an SQL error related to missing `quantity` fields when adding or updating a book.
     - Updated the forms to include a `quantity` field and added validation in the controller to ensure this field is required.
   - **Controller Updates**:
     - Ensured the `store()` and `update()` methods handle the `quantity` field properly.

---

