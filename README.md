# Honey store

This is a single-product shop and RESTful API project for buying and selling honey, implemented using Laravel 8 and Vue 3. It includes the basic features of a store, such as registering an order, a shopping cart, payment within the software and etc.

## Requirements

- PHP 7.3+
- Composer
- Git
- MYSQL 5.7+

## Installation

1. Clone the repo and cd into it. (git clone https://github.com/HosseinEn/Honey-Store.git)
4. composer install (you have to install and add composer to you system env path before running this command
5. Rename or copy .env.example file to .env
6. npm install & npm run dev
7. php artisan key:generate
8.  php artisan storage:link (Make sure you have storage directory in public folder or image and files won't show up!)
9. Set your database credentials in your .env file.
10. php artisan migrate:fresh --seed
11. php artisan serve
12. Visit 127.0.0.1:8000 in your browser.

<br/>
<br/>


## Features

- Single page application
- Sanctum cookie-based session authentication service
- Admin panel for managing orders, discounts, products, users and ... 
- Shopping cart
- Zarinpal and Shetabit Payment
- Data pagination
- Sorting and filtering 
- Searchable tables
- Vuex for state management and SPA authentication
- persian-tools and jalali-moment for persian date and number formatting
- axios for ajax requests
- ...


## Demo
You can check out the online demo at https://bobby.adiosmfs.ga/

Shopping cart page:
![shopping_cart](https://user-images.githubusercontent.com/83599557/234820873-4dcb5800-4e9c-4ed3-9dd8-d045ee5a6e7f.png)

Checkout page:
![user_orders](https://user-images.githubusercontent.com/83599557/234820959-e238d89b-23e7-44c4-bf1d-b5d24068470c.png)

Admin panel products table:
![products_table](https://user-images.githubusercontent.com/83599557/234820995-9437c0ba-04d9-4127-af51-3db71b2fd674.png)

Admin panel orders table:
![orders_table](https://user-images.githubusercontent.com/83599557/234821030-be464121-0418-418c-8313-6b1a5d2d5781.png)


