# Laravel REST API with Test-Driven Development & JWT-Auth

![GitHub repo size](https://img.shields.io/github/repo-size/vamuigua/tdd-journey) ![GitHub Workflow Status](https://img.shields.io/github/workflow/status/vamuigua/tdd-journey/Run_Tests_in_mysql) ![Twitter Follow](https://img.shields.io/twitter/follow/VictorAllen22?style=social)

A Laravel REST CRUD API build using Test-Driven Development & Json Web Token Authentication.

The REST API has CRUD functionality for Recipes that have a HasMany Relationship to a User. The project also includes Tests to check on the reponses returned from the requests.

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   Npm 6.15.4 or latest
-   Node.js 12.18.0 or latest
-   Composer 1.9.0 or latest
-   PHPUnit PHPUnit 8.5.6 or latest

## Project Setup

Open Terminal / Command Prompt and type:

```
git clone https://github.com/vamuigua/tdd-journey.git
```

Then change your directory to the project you have cloned

```
cd tdd-journey
```

### Install Packages

```
npm install
```

### Compile Assets

```
npm run dev
```

### Setting up the Database

Create .env file in root of the project

```
touch .env
```

Copy contents of .env.example and paste them to .env

```
cp .env.example .env
```

Setup the Database variables

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
```

Migrate the Database

```
php artisan migrate
```

### Generate JWT Secret

```
php artisan jwt:secret
```

### Run Application

```
php artisan serve
```

Your done...The app should now be running on [http://127.0.0.1:8000](http://127.0.0.1:8000) 👍

## Run Tests

```
vendor/bin/phpunit
```

## Built With

-   Laravel 7
-   JSON Web Token Authentication

## Authors

-   **Victor Allen** - [vamuigua](https://github.com/vamuigua) :v:

## Contact

If you want to contact me you can reach me at <vamuigua@gmail.com>.
