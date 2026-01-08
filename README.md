<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## CRUD API using Laravel for the backend and Blade, VueJS with Vue-Bootstrap and Axios for the frontend

## Requirements

To run the application the following needs to be installed

- PHP 8.1^
- Composer
- Node.js >= 20
- NPM
- PostgreSQL

## Installation & Setup

1. Clone the repository

```bash
git clone https://github.com/VladeCV/laravel-test.git
cd laravel-test
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install JS dependencies

 ```bash
npm install
```

4. Configure database
 ```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crud_test
DB_USERNAME=postgres
DB_PASSWORD=your_password

```
5. Run migrations
```bash
php artisan migrate

```
6. Install authentication scaffolding (Laravel Breeze)
```bash
```
8. Create a test user
```bash
php artisan tinker

\App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
]);
```
8. Generate a password for the test user
```bash
$user->password = Hash::make('password');
$user->save();
```
9. Start the application
```bash
php artisan serve
npm run dev
```
## Authentication

- Login is handled via Laravel Breeze
- API authentication uses Laravel Sanctum
- Axios is configured to send cookies automatically

## Available routes

```http
API Routes
```

| Method | URI               | Description    |
|:-------|:------------------|:---------------|
| GET    | `/api/items`      | List items     |
| GET    | `/api/items/{id}` | Get item by id |
| POST   | `/api/items/{id}` | Create item    |
| PUT    | `/api/items/{id}` | Update item    |
| DELETE | `/api/items/{id}` | Delete item    |

```
WEB Routes
```

| Parameter | Type   | Description    |
|:----------|:-------|:---------------|
| GET       | /login | Login page     |
| GET       | /items | Item list page |
