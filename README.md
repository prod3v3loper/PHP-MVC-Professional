# PHP MVC Pro

**Model View Controller** Pro to bring the way closer.

This MVC has a good structure, with a example validation yourself in the Model. 
We represent a database table with each of our models to save, get data etc. we use model repository and we can also write a validation to validate data.

In this environment there are some examples from other projects that I have already presented, e.g. the layout with less.
You can use whatever tool you want to minify your css, you don't have to use this design. Exactly the same goes for javascript, I didn't add much more.

Change the data in the **settings.php**:
```
define('DB_PREFIX', 'w_');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'dbname');
define('DB_DSN', 'mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME);
define('DB_USER', 'root');
define('DB_PASS', 'password');

// Debug
define('DEBUG', true);
```

# Attention

This one should not use in a real environment but unfortunately there is also something in real environments.

# Contribute

Please an [issue](https://github.com/prod3v3loper/php-mvc-professional/issues) if you
think something could be improved. Please submit Pull Requests when ever
possible.

# Authors

**[Samet Tarim](https://www.prod3v3loper.com)** - *All works*

# Supporter

[Tnado](https://www.tnado.com/blog/)
[Hyperly](https://www.hyperly.de)

# License

[MIT](https://github.com/prod3v3loper/php-mvc-professional/blob/master/LICENSE) - [prod3v3loper](https://www.tnado.com/author/prod3v3loper/)