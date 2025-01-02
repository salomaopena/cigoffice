# CIGBurguer Office Application

## What is CIGBurguer Office Application?

CIGBurguer Office Application is a web-based application designed to manage and control the CIGBurguer restaurant using **CodeIgniter 4**. It provides features for managing staff, orders, inventory, and other essential aspects of the restaurant.

## Features

- Staff management: Add, edit, and delete staff members with their roles and permissions.
- Order management: Create, view, edit, and cancel orders.
- Inventory management: Add, edit, and remove items from the inventory.
- Reporting: Generate reports such as sales, inventory, and customer analysis.
- Authentication and authorization: Implement role-based access control (RBAC) to restrict access to specific features based on user roles.

## Installation

1. Clone the repository:
   git clone [https://github.com/salomaopena/cigoffice.git]
2. Create a new database and import the `cigburguer_office_app.sql` file located in the `database` directory.
3. Update the database configuration in `app/Config/Database.php` with your database credentials.
4. Configure your email settings in `app/Config/Email.php` if you want to enable email notifications for order status changes.
5. Install dependencies using Composer:
   composer install
6. Start the server:
   php spark serve