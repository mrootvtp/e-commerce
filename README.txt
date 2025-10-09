# Mini E-commerce Module

A mini e-commerce web application built with **Laravel (Backend)** and **Vue.js/Blade (Frontend)**, demonstrating clean architecture, API integration, and basic e-commerce features including cart, checkout, and fake payment flow.

---

## Technologies Used

- **Backend:** Laravel 10, MySQL, Eloquent ORM, Repository & Service Pattern
- **Frontend:** Blade, Vue.js (optional), Bootstrap 5
- **HTTP Client:** Axios for API calls
- **Other:** Faker for seeding, Laravel Sanctum for authentication (optional)

---

##  Features Implemented

### 1. Products
- Product CRUD via **API**
- Fields: `id`, `name`, `description`, `price`,
- Repository & Service pattern used
- Search/filter functionality implemented via Axios

### 2. Cart
- Add products to cart
- Increase/decrease quantity dynamically
- Remove items from cart via Axios
- Cart persists per authenticated user

### 3. Checkout
- View all products in the order
- Calculate total price
- Place order via Axios POST `/api/order`
- Fake payment simulation via Axios POST `/api/payment`
- Dynamic updates and confirmations

### 4. Orders
- Store orders with `Order` and `OrderItem` models
- Track order status (`pending`, `paid`, `canceled`)
- Web view for order summary

### 5. Database Modules
- **Products:** CRUD
- **Inventory:** Track `IN`/`OUT` transactions
- **Order & OrderItems:** For checkout
- **Seeders & Factories:** Sample products, warehouses, countries, inventory

### 6. API Endpoints

| Method | Endpoint | Description |
|--------|---------|-------------|
| GET | `/api/products` | List all products with optional search |
| POST | `/api/cart` | Add products to cart |
| POST | `/api/order` | Create an order |
| POST | `/api/payment` | Simulate fake payment |

---

##Installation

composer install
npm install
npm run build
php artisan migrate --seed
php artisan serve

Access via http://localhost:8000

email = mohammed@gmail.com
pass  = password