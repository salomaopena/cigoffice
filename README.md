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
7. Open your web browser and navigate to `http://localhost/cigoffice/public/` to access the CIGBurguer Office Application.

## Database Structure

The CIGBurguer Office Application uses a MySQL database schema provided in the `database/cigburguer_office_app.sql` file. You can create the database and import the schema using your preferred MySQL management tool.

## Permissions for database administrator

To grant database administrator permissions, you can use the following SQL statement:
> - Database: cigburguer_office_app;
> - User: cigburguer_office_app_admin;
> - Password: GsCl23!G8/9)Y3UK

Grant the following permissions:

## User Roles and Permissions

The CIGBurguer Office Application uses a role-based access control (RBAC) system to manage user permissions. The following user roles are available:

- Admin: Can access all features and manage staff members, orders, inventory, and reports.
- Manager: Can access all features except for managing staff members and inventory.
- Kitchen: Can access order management features and view inventory.
- Waiter: Can access order management features and view inventory.


## Security Considerations

The CIGBurguer Office Application is designed with security in mind. Here are some considerations:

- Use secure HTTPS connections for all communication between the web browser and the server.
- Implement password hashing and salting for user passwords.


## Server Requirements

1. Apache or Nginx server with PHP 8.1 or higher.
2. MySQL or MariaDB database server.
3. Composer installed globally.

For PHP version 8.1 or higher is required, with the following extensions installed:

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

## Frameworks and libraries

The CIGBurguer Office Application uses the following frameworks and libraries:

- [CodeIgniter 4](https://codeigniter.com/) - The PHP framework used for building the web application.
- [AdminLTE 3](https://adminlte.io/) - A free Bootstrap admin template with a clean and modern design.
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) - A popular email sending library for PHP.
- [PHP-DI](https://php-di.org/) - A dependency injection container for PHP.
- [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) - A tool to fix PHP code style issues.
- [PHP-XSS-Sanitizer](https://github.com/paragonie/php-xss-sanitizer) - A PHP library for sanitizing user input against XSS
- [PHP-JWT](https://github.com/firebase/php-jwt) - A library for generating and validating JSON Web Tokens.
- [PHP-CSV](https://github.com/php-fig/php-fig-standards/tree/master/proposed/csv-standard) - A PHP library for
reading and writing CSV files.
- [PHP-Graphviz](https://github.com/php-graphviz/php-graphviz) - A PHP library for generating graphs using Graphviz.
- [Bootstrap-5.3.3]
- [Google-fonte]

## Contributing

To contribute to the CIGBurguer Office Application, follow these steps:

1. Fork the repository on GitHub.
2. Clone your fork locally:
   git clone [https://github.com/your-username/cigoffice.git]
   cd cigoffice

3. Create a new branch for your feature or bug fix:
   git checkout -b [feature-or-bug-fix-name]
   git push origin [feature-or-bug-fix-name]

4. Make your changes and commit them:
   git add .
   git commit -m "[Your commit message]"
   git push origin [feature-or-bug-fix-name]

5. Submit a pull request to the main repository.

## License

The CIGBurguer Office Application is licensed under the MIT License. See the `LICENSE` file for more information.

## Contact

For any questions or inquiries about the CIGBurguer Office Application, please contact the author at [spenna.live@gmail.com](spenna.live@gmail.com).
