# Laravel Test Project README

## Introduction

This is a Laravel test project.

## Getting Started

To run this project, follow the steps below:

### Installation

1. Clone the repository to your local machine:

```bash
git remote add origin https://github.com/ZakariaZhlat125/DigitalEdge-test.git
```

2. Navigate to the project directory:

```bash
cd <project_directory>
```

3. Install project dependencies using Composer:

```bash
composer install
```

### Database Setup

1. Make sure you have XAMPP or any other similar environment set up.

2. Create a new database for the project.

### Migration and Seeding

Run the following command to generate tables in the database and seed them with initial data:

```bash
php artisan migrate --seed
```

### JWT Secret Generation

Generate a secret key to handle token encryption:

```bash
php artisan jwt:secret
```

### Running the Server

Finally, you can run the Laravel development server:

```bash
php artisan serve
```

This will start the server, and you can access the project via `http://localhost:8000` in your web browser.

## Usage

### Credentials

> Admin

```json
{
  "first_name": "Admin",
  "last_name": "admin",
  "email": "admin@nowui.com",
  "passsword": "secret"
}
```

### data users

```json
[
  {
    "first_name": "zakaria",
    "last_name": "zhlat",
    "email": "zakaria@seeder.com",
    "password": "123456"
  },
  {
    "first_name": "firsttest",
    "last_name": "lasttest",
    "email": "test@seeder.com",
    "password": "123456"
  }
]
```

### Registration

To register a new user with an email, send a POST request to the following endpoint:

```

http://127.0.0.1:8000/api/register

```

Include the following data in the request body:

```json
{
  "first_name": "zakaria",
  "last_name": "zhlat",
  "email": "zakaaaria@gmail.com",
  "password": "123465798"
}
```

This will create a new user with the provided information and send a verification code to the provided email address.

To register a new user with a phone number, send a POST request to the same endpoint with the following data:

```json
{
  "first_name": "zakaria",
  "last_name": "zhlat",
  "phone": "123465798",
  "email": "zakaaaria@gmail.com",
  "password": "123465798"
}
```

This will create a new user with the provided information and send a verification code to the provided phone number.

### Verify Account

To verify your account, send a POST request to the following endpoint:

```
http://127.0.0.1:8000/api/verify-account
```

Include the following data in the request body:

```json
{
  "verification_code": "1234",
  "email": "zakaaaria@gmail.com"
}
```

> Replace `"1234"` with the code you received via email. This will verify your account associated with the provided email address.

### login

to login use this api with post request :

```
http://127.0.0.1:8000/api/login
```

Include the data registertion in the request body:
with email :

```json
{
  "email": "zakaaaria@gmail.com",
  "password": "123465798"
}
```

with phone :

```json
{
  "phone": "123465798",
  "password": "123465798"
}
```

### forgetpassword

```
http://127.0.0.1:8000/api/forgot-password
```

body

```json
email:email@gmail.com
```

show this message `"Password reset email sent"` go to email and copy code and go to url

http://127.0.0.1:8000/api/reset-password/{token}
replace token with code
and request body

```json
{ "password": "123456789", "password_confirmation": "123456789" }
```

## Change Password

To change your password, you must first log in to your account.

## Products

Access to products requires authentication. Please log in to view products.
show by id and list  for any user 
stor and update and destory from  admin