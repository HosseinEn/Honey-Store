# Honey store

This project is a single-product shop for buying and selling honey implemented by Laravel 8 and Vue 3, which includes the basic features of a store; registering an order, shopping cart, payment within the software and etc.

## Requirements

- PHP 7.3+
- Composer
- Git
- MYSQL 5.7+

## Installation

1. Clone the repo and cd into it. (git clone https://github.com/HosseinEn/Honey-Store.git)
4. composer install (you have to install and add composer to you system env path before running this command
5. Rename or copy .env.example file to .env
6. php artisan key:generate
7.  php artisan storage:link (Make sure you have storage directory in public folder or image and files won't show up!)
8. Set your database credentials in your .env file.
9. php artisan migrate:fresh --seed
10. php artisan serve
11. Visit 127.0.0.1:8000 in your browser.

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
...


## Demo
You can checkout the online demo at https://bobby.adiosmfs.ga/