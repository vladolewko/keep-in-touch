Keep-In-Touch social network
========================

This is a simple social network called "Keep-In-Touch".
It provides a platform for users to connect, share updates, and interact with each other.

Requirements
----------------
- php >= 8.2
- composer
- laravel >= 11.0
- mysql

Installation
----------------
- `composer create-project "laravel/laravel:^11.0" keep-in-touch`
- `cd keep-in-touch`
- `git clone `https://github.com/vladolewko/keep-in-touch.git`
- `composer install`
- `npm install`
- dublicate file .env.example and make it .env
-  php artisan key:generate
- Configure your database in the .env file:
  - DB_DATABASE=keep-in-touch
  - DB_USERNAME=root
  - DB_PASSWORD=password
  - DB_HOST=127.0.0.1
  - DB_PORT=8889
- create database keep-in-touch in phpMyAdmin

- `php artisan migrate`
- `php artisan db:seed`

For Running Project
----------------
- `npm run dev`



