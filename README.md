# User Management System

## 1. Project Overview

The User Management System is a web-based application developed using CodeIgniter 3, PHP, MySQL, HTML, CSS, Bootstrap and JavaScript.


## 2. Technologies Used

| Technology | Purpose |
|---|---|
| PHP 8.1 | Backend programming |
| CodeIgniter 3 | PHP MVC framework |
| MySQL  | Database |
| HTML5 | Page structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive design |
| JavaScript | User functionality |
| XAMPP | server |

## 3. System Requirements

- Used XAMPP with PHP 8.1 
- MySQL .
- Visual Studio Code .

## 4. Installation Steps

### Step 1: Install XAMPP

Download and install XAMPP 8.1.25.

Start the following services from the XAMPP Control Panel:

- Apache
- MySQL

### Step 2: Copy the Project

Copy the project folder into the XAMPP `htdocs` directory.

`C:\xampp81\htdocs\user_management`

### Step 3: Configure the Database

Open phpMyAdmin:

`http://localhost/phpmyadmin/`

Create the database using Import the provided `database.sql` file.

or, open the SQL tab in phpMyAdmin and execute the SQL file contents.

Database name:

`user_management_db`

The database contains the `users` table with the following fields:

| Column | Description |
|---|---|
| id | Unique user ID |
| name | User's name |
| email | Unique email address |
| password | Securely hashed password |
| role | ADMIN or OPERATOR |
| status | ACTIVE or INACTIVE |
| created_at | Account creation date |
| updated_at | Last account update date |

### Step 4: Configure Database Connection

Open:

`application/config/database.php`

Update the database configuration according to your local MySQL settings.

Example configuration:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => '127.0.0.1',
    'port'     => 6666,
    'username' => 'root',
    'password' => '',
    'database' => 'user_management_db',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

### On my laptop MYSQL server uses port'6666' so use port according to your MYSQL port.


Also in Xampp For Apache config in config.inc.php under  
/* Bind to the localhost ipv4 address and tcp */ \
Mention the Port Number for me its "6666" same as MYSQL Server\

$cfg['Servers'][$i]['host'] = '127.0.0.1';\
$cfg['Servers'][$i]['port'] = '6666';\
$cfg['Servers'][$i]['connect_type'] = 'tcp';


If your MySQL root account has a password, enter it in the `password` field.


### Step 5: Configure Base URL

Open:

`application/config/config.php`

Set base URL to :" $config['base_url'] = 'http://localhost/user_management/'; "



### Step 6: Configure Encryption Key

In the same `config.php` file, configure a unique encryption key:

$config['encryption_key'] = 'YOUR_UNIQUE_SECRET_KEY';

this is what i have set \
$config['encryption_key'] = 'userManagmnt2026SecureKey#X8pQ!';

**NOTE** i have mentioned the config encryption key because it is my Assessment Submission



### Step 7: Open the Application

Open your browser and visit:

`http://localhost/user_management/index.php/auth`

 login page Loads .

## 5. Default Test Credentials

The following accounts are provided for testing.

### Administrator Account

login AS ADMIN

Email: admin@example.com
Password: Admin@123


Login as OPERATOR

Email : alex123@gmail.com 
Password : Alex@123 

Email : priya123@gmail.com 
Password : Priya@123

All other Users Password is Their Name With First Capital Letter and Then "@" then "123",
example 
if user Name is Smith the Password is "Smith@123"

## 6. User Roles and Permissions

Admin 
- Create user 
- Edit user 
- Delete/deactivate user 
- View all users 

Operator 
-View users 
- Edit users 

## 7. Project Folder Structure

```
user_management/
│
├── application/
│   ├── controllers
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   └── Users.php
│   │
│   ├── models/
│   │   └── User_model.php
│   │
│   ├── views/
│        ├── login.php
│        ├── dashboard.php
│        ├── users.php
│        ├── add_user.php
│        └── edit_user.php

```

## 8. Security

- Passwords are stored using PHP `password_hash()`.
- Passwords are verified using `password_verify()`.
- Session-based authentication is used.
- Unauthenticated users are redirected to the login page.
- Role-based authorization is checked on the server side.
- Password hashes are not displayed in user listing pages.
- Email addresses are unique in the database.

