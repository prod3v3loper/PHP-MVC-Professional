# 🏗 PHP MVC Professional

**Model View Controller**

To bring the way closer.

I have already released two versions and this would be where you could build.
If you want, have a look at the other versions:

https://github.com/prod3v3loper/php-mvc-beginner

https://github.com/prod3v3loper/php-mvc-advanced

# Idea

MVC has a clear and understandable structure

- The Model View and Controller folders are named in the same way.
- Everything that is still needed is in core templates, less, javascript etc.
- The Autoloader runs independently
- The Database connection is available

## Controller

> The front controller is the router and directs all inquiries that come from the index.php to the respective controller and action (class method).

`URL/controller/action/`

If we enter the following in the url:
`URL/index/about/`
the IndexController class and the aboutAction method are called

With our index controller, however, we do not need the index in the URL but can call it up:
`URL/about/`

This does not apply to all other controllers.

**EXAMPLE**

`URL/index/contact/`

`URL/user/register/`

`URL/user/login/`

## Modal

The modals handle the database processing. Query, save, update, etc.

The database should not be accessed anywhere else, but always via the modals. If a new one is required, it must be created.

### Validator

The validators check whether the incoming data is also valid. We put checks there so we don't have to write one over and over again.

# Roots

In the `root.php` there are path variables that have been defined. And should always be used for links or when loading a file.

**The root.php uses functions from the core / func folder**

> It doesn't matter which folder you are in, whether on the server or locally.
> The `root.php` always determines the root (main) directory

```
PROJECT_DOCUMENT_ROOT
```

```
DOCUMENT_ROOT
```

```
PROJECT_HTTP_ROOT
```

**EXAMPLE**

```php
echo '<a href="' . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . '/user/login/">Link</a>';
```

```php
require_once DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/classes/">Link</a>';
```

# Settings

The database connections are defined in settings.php. Change the data in the `settings.php`:

## Database

```
define('DB_PREFIX', 'w_');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'dbname');
define('DB_DSN', 'mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME);
define('DB_USER', 'root');
define('DB_PASS', 'password');
```

## Debug

```
// Debug
define('DEBUG', true);
```

# ToDos

- [ ] Complete the user register, login and password actions
- [ ] Complete the admin area with a query as to whether you are logged in
- [ ] Add a ext folder for Frameworks

# Attention

This one should not use in a real environment but unfortunately there is also something in real environments.

# Contribute

Please an [issue](https://github.com/prod3v3loper/php-mvc-professional/issues) if you
think something could be improved. Please submit Pull Requests when ever
possible.

# Authors

**[Samet Tarim](https://www.prod3v3loper.com)** - _All works_

# Supporter

[Hyperly](https://www.hyperly.de)

# License

[MIT](https://github.com/prod3v3loper/php-mvc-professional/blob/master/LICENSE) - [prod3v3loper](https://www.tnado.com/author/prod3v3loper/)
