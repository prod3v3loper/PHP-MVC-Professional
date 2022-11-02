# 🏗 PHP MVC Professional

> Model View Controller

# IDEA

MVC has a clear and understandable structure. A basic framework for smaller or larger projects.
Working with it should be easy and understandable, which is why most of the names are named accordingly.

At the moment there is (further information will follow):

- The Model View and Controller folders are named in the same way.
- Everything that is still needed is in core folder e.g. templates, less, javascript etc.
- The Autoloader runs independently equal to - https://github.com/prod3v3loper/php-auto-autoloader
- The Database connection is available PDO

# DOCUMENTATION

Route all acces to site to the index.php with a `.htaccess` file otherwise routing will not work.

```php
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php [L]
</IfModule>
```

# CONTROLLER

The controller handle the routing of the sites.

> The front controller is the router and directs all inquiries that come from the index.php to the respective controller and action (class method).

`URL/controller/action/`

If we enter the following in the url:
`URL/index/about/`
the IndexController class and the aboutAction method are called

With our index controller, however, we do not need the index in the URL but can call it up:
`URL/about/`

```php
class IndexController extends AbstractController
 {
    public function aboutAction(array $params = [])
    {
        V::addContext('data', array());
        V::display();
    }

    public function contactAction(array $params = [])
    {
        V::addContext('data', array());
        V::display();
    }
 }
```

**EXAMPLE**

`URL/contact/`

This does not apply to all other controllers only to the IndexController.

```php
class UserController extends AbstractController
{
    public function loginAction(array $params = [])
    {
        V::addContext('data', array());
        V::display();
    }

    public function registerAction(array $params = [])
    {
        V::addContext('data', array());
        V::display();
    }
}
```

**EXAMPLE**

`URL/user/register/`

`URL/user/login/`

# MODEL

The modals handle the database processing. Query, insert, update, delete and validation.

> The database should not be accessed anywhere else, but always via the modals. If a new one is required, it must be created.

## GETTER & SETTER

**SETTER** - It's done in the setter because we then transfer it to the variable. This is later transferred to the database in the variable.

**GETTER** - We use the getter to call it anywhere, e.g. an output on the page.

> Setter can be use to harmless incoming data.

```php
    /**
     *
     * @param string $email
     */
    public function setEmail(string $email = '')
    {
        // Add extra check before set
        if (is_string($email) && strlen($email) > 0 && strlen($email) <= 255) {
            $this->email = str_replace('@', ' _*_ ', $email);
            $this->email = htmlspecialchars(strip_tags($this->email));
            // Use more masks...
        }
    }

    public function getEmail()
    {
        return (string) $this->email;
    }
```

## VALIDATOR

The validators check whether the incoming data is also valid. We put checks there so we don't have to write one over and over again.

> Validator can use to check before set incoming data

```php
    /**
     *
     * @param string $email
     *
     * @see http://php.net/manual/de/filter.examples.sanitization.php
     */
    public function validateEmail(string $email = '')
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (empty($email) or $email == '') {
            $this->addError('Please enter a E-Mail-Address');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('This E-Mail-Address is invalid');
        } else if (strlen($email) < $this->minTextLength) {
            $this->addError(sprintf('The email should be at least %d characters long.', $this->minTextLength));
        }
        // Add more checkpoints...
    }
```

## MODEL USAGE EXAMPLE

```php
    // OTHER CODE

    public function contactAction(array $params = [])
    {
        $smailer = new SM();

        // EXAMPLE USE OF A MODAL
        /**
         * Contact model instance
         * Call from class.ContactModel.php
         */
        $contact = new C();
        $contact->setCsrf(); // Create csrf token for form in template
        // If contact form send
        if (isset($_POST["contact"])) {
            // Validate all fields in validator
            $contact->validateByArray($_POST);
            // Is valid ?
            if ($contact->isValid()) {
                // Set all data to User modal
                $contact->setByArray($_POST);
                /**
                 * Save user in db
                 * Call from class.UserModel.php
                 */
                if ($contact->saveObject()) {
                    if ($smailer->sendMail($contact->getEmail(), 'Thanks for contact', 'We have received your contact message')) {
                        $contact->addSuccess('Mail send thanks for contact us');
                        $contact->cleanCsrf(); // Clean csrf token on success
                    } else {
                        $contact->addError('Mail not send, please try again');
                    }
                }
            }
        }

    // OTHER CODE
```

# VIEW

The view handles all template uses and context.

```php
class IndexController extends AbstractController
 {
    public function aboutAction(array $params = [])
    {
        V::addContext('data', array(
            "templates" => array(
                "header",
                "nav",
                "about",
                "footer"
            ),
            "meta-title" => "About",
            "robots" => "index, follow, noodp",
            "title" => "About us",
            "description" => "About us.",
            "nav-active" => "about",
            "content" => "<h2>About</h2><p>About us.</p>",
        ));

        V::display();
    }
 }
```

Here as example the `V::display()` searches for an index.php in core/tpl folder to load it.

The context `V::addContext('data', array)` add data `$data` with array `$data['templates']` for the template index.php to use it in there.

```php
"templates" => array(
    "header",
    "nav",
    "about",
    "footer"
)
```

The part of templates is for the second template we load in our index.php

Use in templates core/tpl/index.php

```php
    if (isset($data['templates'])) {
        // If templates loop it
        foreach ($data['templates'] as $template) {
            // Create template file path
            $file = PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl' . DIRECTORY_SEPARATOR . $template . '.tpl.php';
            // Check if exitst and load
            if (file_exists($file)) {
                require_once $file;
            } else {
                echo 'Tpl not found!';
            }
        }
    }
```

# Roots

In the `root.php` there are path variables that have been defined. And should always be used for links or when loading a file.

**The root.php uses functions from the core / func folder**

> It doesn't matter which folder you are in, whether on the server or locally.
> The `root.php` always determines the root (main) directory

```php
PROJECT_DOCUMENT_ROOT
```

```php
DOCUMENT_ROOT
```

```php
PROJECT_HTTP_ROOT
```

**USAGE EXAMPLE**

```php
echo '<a href="' . PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . '/user/login/">Link</a>';
```

```php
require_once DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/classes/';
```

# LANGUAGE

English is the first and main language, all other languages ever translated from that.

To translate string use the follwed functions:

```php
_e('Username'); // This echos the output
```

or use for later echo the output

```php
$variable = '# ' . __('Username');
echo $variable;
```

The languages files are in `includes` folder e.g. `de_DE.json`

```json
{
  "Username": "Benutzername",
  "E-Mail-Address": "E-Mail-Adresse",
  "Message": "Nachricht",
  "Send": "Senden"
}
```

You can add other langauges, create another file with `tr_TR.json` or language you want.

```json
{
  "Username": "Kullanıcı adı",
  "E-Mail-Address": "E-Posta Adresi",
  "Message": "İleti",
  "Send": "Gönder"
}
```

If language file exists you can call the language via:

**LANG USAGE EXAMPLE**

`URL/de/contact/`

`URL/tr/contact/`

`URL/de/user/login/`

`URL/tr/user/login/`

# Settings

The database connections are defined in .env Create a `.env` file:

## Database

In file `.env`

```php
DB_PREFIX=
DB_HOST=localhost
DB_PORT=3306
DB_NAME=dbname
DB_USER=root
DB_PASS=password
```

## MAIL

To activate the mail function, download [PHPMailer](https://github.com/PHPMailer/PHPMailer) and create a folder `ext` in `core` dir `core/ext`.
Now move your PHPMailer in the folder e.g. `core/ext/phpmailer-6.5.5` that's it.

Add your SMTP data in `.env`

```php
MAIL_HOST=
MAIL_SMTP=tls
MAIL_PORT=587
MAIL_CHARSET=UTF-8
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_MAIL_FROM=
MAIL_ADMIN=
```

## DEBUG

In file `com.php` the common file.

```php
define('DEBUG', true);
```

In file `settings.php` the settings file.

```php
/**
 * Debug setting
 */
define('DEBUG_DISPLAY', true); // Screen errors on website
define('DEBUG_LOG', true); // Log errors in file
define('DEBUG_LOG_FOLDER', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'debug');
define('DEBUG_LOG_FILE', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'debug/debug.log');
define('DEBUG_DB_LOG', false); // Log errors in database
define('DEBUG_MAIL_LOG', true); // Send errors per mail
define('DEBUG_ADMIN_MAIL', ''); // Send errors to this email
```

# CORE

The core folder is to use for help with e.g. logging, session, js, templates, css, less etc.

/classes

/css

/debug - Debug log files was generated here

/ext

/func - Functions to load fast and overall

/img

/js

/less

/tpl

# ToDos

- [ ] Expanding the admin area
- [ ] Create Forgot password reset with auth email
- [ ] Override internal session handlers
- [ ] Create command for scaffold controller and models
- [ ] Add bundler and co webpack, typescript etc.
- [ ] Add composer for paypal etc.

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
