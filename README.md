# Ecommerce Laravel Vue

A Laravel + Vue ecommerce application with storefront pages, API endpoints, and an admin panel for managing products.

## Features

- Storefront product listing, product details, cart, checkout, and user authentication
- Admin login and dashboard
- Admin product management: list, create, edit, delete
- API routes for product data, cart actions, orders, and authentication
- Vue 3 frontend powered by Vite

## Installation

1. Clone the repository:

```bash
git clone https://github.com/NyeinChanSu/Ecommerce-laravel-vue.git
cd Ecommerce-laravel-vue
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install frontend dependencies:

```bash
npm install
```

4. Copy the environment file and generate the app key:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in .env.

6. Run database migrations:

```bash
php artisan migrate
```

7. Build assets for development or production:

```bash
npm run dev
# or
npm run build
```

8. Start the local server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

## Admin Panel

- Access the admin login at: http://127.0.0.1:8000/admin
- After login, manage products from the admin dashboard

## Notes

- Do not commit your `.env` file.
- `vendor/` and `node_modules/` are ignored by `.gitignore`.
- Use `php artisan optimize:clear` if you need to clear cached config or routes.

## License

This project is open source and available under the MIT license.
