# User Management System Project

## Project Overview

A PHP-based User Management System built with Core PHP, JavaScript, and MySQL. This project provides CRUD (Create, Read,
Update, Delete) functionalities for managing user data.

### Pre-requisites

- docker
- PHP
- Node.js and npm
- MySQL database

## Steps

1. Clone the repository:

``` 
git clone https://github.com/rdbindia/UserForm.git
cd UserForm
```

2. Build and run the Docker containers:

```
docker-compose up --build -d
```

3. Access the application:

- Open http://localhost:8081 in your browser.

4. Install dependencies for PHP:

```
docker exec -it php_app composer install
```

5. Run database migrations and seed tables:

```
docker exec -it php_app php database/run_migrations.php
docker exec -it php_app php /var/www/html/database/run_seeder.php
```

6. Install JavaScript dependencies:
```
npm install
```

## Usage

### CRUD Operations

1. View All Users:
   - Access the home page to see all users in a table format.
2. Create User:
    - Use the “Create User” button to open the create form.
3. Update User:
    - Click the “Edit” button next to a user to update their details.
4. Delete User:
   - Click the “Delete” button, with a confirmation dialog, to remove a user.


## Running the Tests for frontend and backend:

- **Front end test**:

```npx jest```

- **Backend test**

``` docker exec -it php_app vendor/bin/phpunit --testdox ```