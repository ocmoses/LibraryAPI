# Library API

This is just a test to simulate requesting a book from a library. The requests are granted by a Librarian and user roles takes precedence over whose request get granted for a certain book if it is requested by more than one user.

## Requirements

-   ### php^7.1
    You should have installed php with a version 7.2 or higher.
-   ### Apache WebServer
    This is the server used to serve the files
-   ### MySQL Database

    The chosen database is MYSQL. A vrsion 5.7 or higher is fine.

-   ### You can get all these by downloading and installing XAMPP: [Download](https://www.apachefriends.org/download.html)
-   ### composer
    If you don't have composer, follow these directions to install for your OS: [Install Composer](getcomposer.org/doc/00-intro.md)

## Installation

If you have everything set up, clone the repository to folder in your `xampp/htdocs` directory:

```bash
    git clone https://github.com/ocmoses/LibraryAPI.git libraryAPI
```

-   Create a database called `library_api` or whatever you prefer.
-   Copy the `.env.exampe` file and name it as `.env`
-   Edit your `.env` file as follows:
    -   Change `APP_NAME=Laravel` to `APP_NAME=LibraryAPI`
    -   Change
        ```
        DB_DATABASE=laravel
        DB_USERNAME=root
        DB_PASSWORD=
        ```
        to
        ```
        DB_DATABASE=library_api
        DB_USERNAME=root
        DB_PASSWORD=<Your password>
        ```
-   If you are on a linux machine, ensure that your `<project root>/artisan` file is executable.
    ```
    sudo chmod 755 artisan
    ```
-   In your Command Line or Terminal, `cd` into your project root directory. Then run:
    ```bash
    composer install
    ```
    to install all dependencies.

## Setting up the project

The following commands will get the project up and running:

-   Run:

    ```bash
    php artisan key:generate
    ```

    to generate an `APP_KEY`

-   Run:

    ```bash
    php artisan migrate
    ```

    to create your database

-   Run:

    ```bash
    php artisan db:seed
    ```

    to populate your databse with some records

-   Run:
    ```bash
    php artisan serve
    ```
    to start the server on `localhost:8000`

Go to `http://localhost:8000` in your browser
Your database has been prepopulated with four yours with the following credentials:

-   ```bash
    username: teacher@library.com
    password: password
    ```
-   ```bash
    username: junior@library.com
    password: password
    ```
-   ```bash
    username: senior@library.com
    password: password
    ```
    and
-   ```bash
        username: librarian@library.com
        password: password
    ```

You can login with any of the credentials to perform the operations of requesting to borrow a book or granting a request (as a Librarian only)

## Licence

None :)
