## Information

This is an e-commerce project, including features such as showing products, add to cart, checkout, wish list, login with Facebook - Google, sending email when customer makes the checkout (using queue in Laravel), and also has an admin page for management, etc.

Website Demo : [http://adike-ecommerce.herokuapp.com](http://adike-ecommerce.herokuapp.com/)


## Installation

1. Clone the repo and ```cd``` into it
2. ```composer install```
3. Rename or copy ```.env.example``` file to ```.env```
4. ```php artisan key:generate```
5. Set your database credentials in your ```.env``` file
6. Set your mail credentials in your ```.env``` file
7. ```php artisan migrate:fresh --seed``` 
8. ```php artisan serve```
