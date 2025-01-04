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

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:
> - json (enabled by default - don't turn it off).
> - [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
> - [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library.