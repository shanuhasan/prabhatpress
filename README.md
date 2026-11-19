# Prabhat Press — Order & Accounts Management

A web app for running a printing press. It tracks customer print orders from booking to delivery, records payments (cash and online, per receiving account), logs expenses and walk-in sales, manages supplier work and payments, and shows daily and yearly financial reports.

Built on **Laravel 10** (PHP 8.1+), Blade views, Laravel Breeze authentication, MySQL, and Vite + Tailwind/Alpine for assets.

---

## Features

| Module | What it does |
| --- | --- |
| **Dashboard** | Today's orders and order value, money received today (cash vs. online per account), today's expenses, order counts by status, and outstanding balances on delivered orders. |
| **Orders** | Create, edit, delete and print orders (order no., order book no., particulars, quantity, total, discount, advance, balance, delivery date). Filtered lists for **Pending**, **Completed**, **Delivered** and **Pending amount**. Status flow: `Pending → Printing → Completed → Delivered`. |
| **Customers** | Customer records (name, phone, email, address, company), each customer's orders, and recording payments against an order. |
| **Payments / Sales** | Payments are stored in `order_items`. Walk-in sales that aren't tied to an order go in the same table with `type = 1` (`OrderItem::SALE`). Each entry records payment method (Cash/Online), the receiving account (`in_account`) and any discount. |
| **Expenses** | Daily expenses with payment method and the account paid from (`from_account`). |
| **Suppliers** | Supplier records, supplier work items (particulars, qty, sizes, rate, amount, balance, mail / print-received flags, type *Flex* / *Other*), payments to suppliers (cash/online, discount), and **CSV export** of a supplier's items. |
| **Reports** | Received amounts vs. expenses, broken down by account, filterable by date and year. Includes a separate online-payment report. |
| **Users** | Staff user management (role, status, phone, image), profile editing and password change. |

---

## Tech stack

- **Backend:** Laravel 10, PHP ≥ 8.1, Sanctum, Breeze (auth scaffolding)
- **Database:** MySQL (developed under XAMPP)
- **Frontend:** Blade templates, Tailwind CSS 3, Alpine.js, Vite 4
- **Testing:** PHPUnit 10

---

## Project structure (key parts)

```
app/
  Helpers/helper.php          Global helpers (getUserName, getCustomerName, statusList,
                              statusColor, years, GUIDv4, type, numberOfDays, ...)
  Http/Controllers/
    DashboardController.php   Dashboard figures
    OrderController.php       Orders + print view
    CustomerController.php    Customers, customer orders & payments
    SaleController.php        Walk-in sales (OrderItem type = SALE)
    ExpenseController.php     Expenses
    SupplierController.php    Suppliers, supplier items & payments
    ExportController.php      Supplier items CSV export
    ReportController.php      Financial & online-payment reports
    UserController.php        Staff users
    ProfileController.php     Profile & change password
    Auth/                     Breeze authentication controllers
  Models/                     Order, OrderItem, Customer, Expense, Supplier,
                              SupplierItem, SupplierItemDetail, User
database/migrations/          Schema (see below)
resources/views/              Blade views per module; layouts/ is the active
                              sidebar layout
routes/web.php                All app routes (behind `auth` middleware)
routes/auth.php               Login / register / password reset routes
```

### Database tables

| Table | Purpose |
| --- | --- |
| `users` | Staff accounts (`role`, `status`, `phone`, `image`) |
| `customers` | Customer master |
| `orders` | Print orders: amounts, discount, advance/balance, `status`, `delivery_at`, `is_pending_amount`, `payment_status` |
| `order_items` | Payments received against orders **and** walk-in sales (`type`), with `payment_method`, `in_account`, `discount` |
| `expenses` | Expenses with `payment_method`, `from_account`, `type` |
| `suppliers` | Supplier master (with `guid`) |
| `supplier_items` | Work/items ordered from a supplier (with `guid`) |
| `supplier_item_details` | Payments made to suppliers (cash/online, discount) |

---

## Local setup (XAMPP / Windows)

Requirements: PHP 8.1+, Composer, Node.js 18+, MySQL.

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database details:

```env
APP_NAME="Prabhat Press"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prabhatpress
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 3. Create the database (e.g. via phpMyAdmin), then migrate
php artisan migrate

# 4. Build assets (or `npm run dev` while developing)
npm run build

# 5. Run
php artisan serve
```

Open http://127.0.0.1:8000. The root URL redirects to the login page. Register the first user at `/register`. Registration closes once any user exists, and further staff accounts are added from the **Users** module.

---

## Useful commands

```bash
php artisan migrate            # run new migrations
php artisan route:list         # list all routes
php artisan test               # run tests
./vendor/bin/pint              # format code (Laravel Pint)
npm run dev                    # Vite dev server with hot reload
```

---

## Notes

- **Global helpers** in `app/Helpers/helper.php` are autoloaded through `autoload.files` in `composer.json`. After changing that file list, run `composer dump-autoload`.
- **`/clear-cache`** clears the application and route caches. It requires login.
- **Deletes** of users, customers and suppliers use `DELETE` routes, called via AJAX with the CSRF token.
- **Registration** at `/register` only works while the `users` table is empty. After that it returns 404.
- `resources/views/layouts1/` holds the original Breeze layout. The app uses `resources/views/layouts/` (sidebar layout).

---

## License

Private project for Prabhat Press. Built on the Laravel framework, which is MIT-licensed.
