
_```Cash Tracker Web Application_ ``` 

Overview

The *Cash Tracker* is a web-based application designed to help users manage their personal finances by tracking cash transactions. This open-source project is built with PHP for the backend, MySQL for the database, and HTML/CSS for the frontend. It provides a simple yet efficient interface for users to register, log in, track cash transactions, and generate reports of their financial activity.

This application is intended for personal use and is deployed locally using tools such as XAMPP, making it easily accessible for anyone looking to manage their finances without relying on cloud hosting.

Features

- *User Registration*: Users can create accounts to securely log in and track their transactions.
- *Login & Logout*: Secure login system for users, allowing them to access their own financial data and log out.
- *Cash Tracker*: Users can record, view, and manage cash transactions including descriptions and amounts.
- *Database Reporting*: The system generates reports based on the transaction data stored in the MySQL database.
- *Secure Authentication*: Passwords are hashed for secure authentication, and users can only access their own transaction records.

Technologies Used

- *Frontend*: HTML, CSS, JavaScript
- *Backend*: PHP
- *Database*: MySQL
- *Local Server*: XAMPP (for local hosting)
  
 Installation

Follow these steps to get the Cash Tracker application up and running on your local machine:

Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) (or similar local server stack) installed on your machine
- A web browser
- Basic knowledge of using PHP and MySQL

 Steps to Install

1. *Download the Project*
   - Clone this repository to your local machine:
   ```bash
   git clone (https://github.com/3model3/3model3).git
   ```

2. *Set Up the Database*
   - Open the XAMPP Control Panel and start Apache and MySQL services.
   - Open phpMyAdmin (usually accessible at `http://localhost/phpmyadmin`).
   - Create a new database named `transactions`.
   - Use the following SQL queries to create the required tables:

   *Users Table*:
   ```sql
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL,
       password VARCHAR(255) NOT NULL
   );
   ```

   *Transactions Table*:
   ```sql
   CREATE TABLE transactions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       description VARCHAR(255),
       amount DECIMAL(10,2),
       user_id INT,
       FOREIGN KEY (user_id) REFERENCES users(id)
   );
   ```

3. *Configure the Database Connection*
   - In the project's root directory, locate the `config.php` file.
   - Update the file with your MySQL server credentials (e.g., username, password, database name).
   
4. *Launch the Application*
   - Place the project folder in the `htdocs` directory of your XAMPP installation.
   - In your browser, go to `http://localhost/cash_tracker` to start using the application.

Usage

- *Registering a User*: On the homepage, users can register an account by entering a valid username and password.
- *Logging In*: After registration, users can log in using their credentials. If the credentials are correct, they will be redirected to the Cash Tracker dashboard.
- *Adding Transactions*: Users can add transactions by providing a description and amount for each cash transaction.
- *Viewing Transactions*: Users can view a list of their recorded transactions.
- *Generating Reports*: The database generates reports based on the transactions, which are displayed to the user.

Contributing

This is an open-source project, and contributions are welcome. If you'd like to contribute, please follow these steps:

1. Fork this repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new pull request.

License

This project is open-source and is not licensed any one can use it I prove it for free. See the LICENSE file for more details.

 Acknowledgements

- [XAMPP](https://www.apachefriends.org/index.html) for local server hosting.
- [PHP](https://www.php.net/) for the backend scripting.
- [MySQL](https://www.mysql.com/) for the database.
