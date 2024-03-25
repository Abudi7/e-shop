```markdown
# E-Shop Project

This is a simple e-commerce platform built using plain PHP, MySQL, and Bootstrap. It allows sellers to list their products for sale and enables administrators to perform CRUD (Create, Read, Update, Delete) operations within the system.

## Features

- **User Authentication**: Users can register, login, and logout.
- **Seller Dashboard**: Sellers can buy products
- **Admin Dashboard**: Administrators can manage users, view and edit product listings, and handle orders.
- **Product Listings**: Users can browse through available products, view product details, and make purchases.

## Installation

Follow these steps to set up the project:

1. **Clone the Repository**: Clone this repository to your local machine using the following command:

   ```bash
   git clone https://github.com/Abudi7/e-shop.git
   ```

2. **Database Setup**:
   - Create a MySQL database for the project.
   - Import the `onlineshop.sql` file located in the `database` directory to set up the necessary tables.

3. **Configuration**:
   - Rename the `config-sample.php` file in the `config` directory to `config.php`.
   - Open `config.php` and update the database connection details (`DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`) with your MySQL credentials.

4. **Web Server Setup**:
   - You can use Apache, Nginx, or any other web server of your choice.
   - Configure your web server to point to the `public` directory as the document root.

5. **Accessing the Application**:
   - Once everything is set up, you should be able to access the application by navigating to the appropriate URL in your web browser.

## Usage

- **User Registration/Login**: Users can register for a new account or log in if they already have one.
- **Seller Dashboard**: After logging in, sellers can access their dashboard to manage product listings.
- **Admin Dashboard**: Administrators have access to additional functionalities such as managing users, products, and orders.
- **Product Listings**: Users can browse through available products, view details, and make purchases.

## Contributors

- [Abdulrhman Alshalal](https://github.com/Abudi7)

## License

This project is licensed under the [E-shop](LICENSE).
```

