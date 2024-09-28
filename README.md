### **Day 6 Report**

**Date:** 27/09/2024

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

### **Daily Report - Day 7**

**Date:** September 28, 2024

---

#### **1. JWT Integration with Sanctum**
- **Issue:** User mentioned JWT was not working and that no token was being generated. After clarification, it was confirmed that the application is using Laravel Sanctum instead of traditional JWT.
- **Resolution:** Reviewed and ensured that Sanctum configuration was correct for token authentication. Adjusted login handling and response to include proper token generation via Sanctum.

#### **2. LoginController Update**
- **Context:** The login system needed to handle different user roles (owner, renter, admin).
- **Solution:**
    - Implemented role-based redirection in the `LoginController`. Depending on the user's role, they are now redirected to the appropriate dashboard (`owner/dashboard`, `renter/dashboard`, or `admin/dashboard`).
    - This was tested and verified to ensure that role-based authentication is functioning as intended.

#### **3. Admin Dashboard User Interface**
- **Objective:** Align the admin dashboard user interface (UI) with the provided design.
- **Action:**
    - The existing `manage users` interface was modified to visually resemble the reference image provided. A detailed table was created to display:
        - User information (name, role, status).
        - Control buttons for actions (view, delete, approve).
    - Added dynamic elements like "Approve" and "Deactivate" buttons based on user status.
    - Added visual elements to improve the aesthetic, such as color-coded statuses (e.g., "Active" shown in green).

#### **4. Role-Based Book Uploads**
- **Issue:** Only active users should be able to upload books.
- **Resolution:**
    - Added checks in the book upload logic to ensure only users with an `active` status can proceed with uploading books. Inactive users are restricted from performing this action.
    - This was integrated into the backend to ensure that inactive users cannot bypass this check.

#### **5. Alerts and Errors Auto Dismiss**
- **Objective:** Automatically hide status and error messages after 3 seconds.
- **Implementation:**
    - Updated the blade templates where success and error messages are displayed.
    - Added JavaScript to ensure the messages auto-hide after 3 seconds. Both status and error messages will now disappear, improving user experience.

---

**Next Steps for Day 8:**
- Continue refining role-based functionalities.
- Review any remaining tasks related to book cover uploads and admin management.
- Enhance token-based authentication with Sanctum if needed.

