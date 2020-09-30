# Garrett's CommentSold Test

## Setup

This application is using Laravel 8. You can follow the [Laravel Installation Instructions](https://laravel.com/docs/8.x/installation) for configuring the proper environment you would need to run the application.

After installing the environmental dependencies, perform the following after cloning this repository at the root directory of the project.

-   `composer install`
-   `npm install && npm run dev`
-   `cp .env.example .env`

Configure the `.env` file to a local database where you can run the projects migrations.

```
DB_DATABASE=MY_DATABASE
DB_USERNAME=DATABASE_USER
DB_PASSWORD=DATABASE_PASSWORD
```

Then run `php artisan migrate` to build the database and load the initial data.

## Features Implemented

### Section A: Setup:

-   The required database tables are created via Laravel migration files.
-   The data provided is created in its own migration file so that it's available after running the migrations.

### Section B: Authentication

-   Laravel 8 comes with the Fortify plugin that offers authentication out of the box. However, I altered the logic slightly so that users who are not enabled cannnot login. This can be seen in the `JetStreamServiceProvider.php` file.

### Section C: Products

-   Upon entering the application, the first page is a table of all products associated to the current account. You're able to create new products, edit them, and also delete them.

### Section D: Inventory Display and Interaction

-   Skipped this in favor of Section E.

### Section E: Order Display and Interaction

-   A basic view of all orders associated to the current user can be seen by selecting the `Orders` navigation link in the menu.
-   More order details can be seen by clicking `View` in each order record.
-   A basic view of how many orders are in each status can be seen at the top of the page.
-   Total orders, total revenue, and average order total can all be seen on the orders page as well.
-   You can filter by the name of the product associated to an order, or the SKU associated to the order.
-   When applying a filter, the number of orders per status, as well as total revenue and average total changes based on the records returned.

## Demo

While I did not set up a web host environment for this, I will provide a mechanism a little prior to our next call that will allow you to interact with the application as well.

## Testing

I utilized [Laravel Dusk](https://laravel.com/docs/8.x/dusk) for my test suite. To run them, host the application by running `php artisan serve --port=8080`, and then run the command `php artisan dusk`.
It's possible it won't run due to your Chrome version being out of sync with the most recent version of ChromeDriver. However, you can use the command `php artisan dusk:chrome-driver 85` to change the version
of ChromeDriver used. Ensure it matches up with your browser's version by viewing `chrome://version` in your browser.
