# Toro

Toro is a PHP router for developing RESTful web applications and APIs. It is designed for minimalists who want to get work done.

## Travis
https://travis-ci.org/cedricroc/ToroPHP.png!":https://travis-ci.org/cedricroc/ToroPHP

## Quick Links

- [Official Website](http://toroweb.org)
- [Changelog](https://github.com/anandkunal/ToroPHP/wiki/Changelog)
- [Design Goals](https://github.com/anandkunal/ToroPHP/wiki/Design-Goals)


## Features

- RESTful routing using strings, regular expressions, and defined types (`number`, `string`, `alpha`)
- Flexible error handling and callbacks via `ToroPHP_Hook`
- Intuitive and self-documented core (`toro.php`)
- Tested with PHP 5.3 and above


## "Hello, world"

The canonical "Hello, world" example:

```php
<?php

class HelloHandler
{
    public function get(ToroPHP_Request $request = null)
    {
      echo "Hello, world";
    }
    
    public function get_xhr()
    {
        echo 'Test OK XHR';
    }
}

class NotFound
{
    public function get()
    {
        echo 'NOT FOUND !';
    }
}

$routes = array(
    "/" => "HelloHandler",
    "404" => "NotFound",
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();
```


## Routing Basics

Routing with Toro is simple:

```php
<?php

$routes = array(
    "/" => "SplashHandler",
    "/catalog/page/:number" => "CatalogHandler",
    "/product/:alpha" => "ProductHandler",
    "/manufacturer/:string" => "ManufacturerHandler"
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();
```

An application's route table is expressed as an associative array (`route_pattern => handler`). This is closely modeled after [Tornado](http://tornadoweb.org) (Python). Routes are not expressed as anonymous functions to prevent unnecessary code duplication for RESTful dispatching.

From the above example, route stubs, such as `:number`, `:string`, and `:alpha` can be conveniently used instead of common regular expressions. Of course, regular expressions are still welcome. The previous example could also be expressed as:

```php
<?php

$routes = array(
    "/" => "SplashHandler",
    "/catalog/page/([0-9]+)" => "CatalogHandler",
    "/product/([a-zA-Z0-9-_]+)" => "ProductHandler",
    "/manufacturer/([a-zA-Z]+)" => "ManufacturerHandler"
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();
```

Pattern matches are passed in order as arguments to the handler's request method. In the case of `ProductHandler` above:

```php
<?php

class ProductHandler
{
    function get(ToroPHP_Request $request = null)
    {
        echo "You want to see product: " . $request->getValue('get', 'urlParameter_1');
    }
}
```


## RESTful Handlers

```php
<?php

class ExampleHandler
{
    function get(ToroPHP_Request $request = null) {}
    function post(ToroPHP_Request $request = null) {}
    function get_xhr(ToroPHP_Request $request = null) {}
    function post_xhr(ToroPHP_Request $request = null) {}
}
```

From the above, you can see two emergent patterns.

1. Methods named after the HTTP request method (`GET`, `POST`, `PUT`, `DELETE`) are automatically called.

2. Appending `_xhr` to a handler method automatically matches JSON/`XMLHTTPRequest` requests. If the `_xhr` method is not implemented, then the given HTTP request method is called as a fallback.


## ToroPHP_Hook (Callbacks)

As of v2.0.0, there are a total of five Toro-specific hooks (callbacks):

```php
<?php

// Fired for 404 errors
ToroPHP_Hook::add("404",  function() {});

// Before/After callbacks in order
ToroPHP_Hook::add("before_request", function() {});
ToroPHP_Hook::add("before_handler", function() {});
ToroPHP_Hook::add("after_handler", function() {});
ToroPHP_Hook::add("after_request",  function() {});
```

`before_handler` and `after_handler` are defined within handler's constructor:

```php
<?php

class SomeHandler
{
    function __construct()
    {
        ToroPHP_Hook::add("before_handler", function() { echo "Before"; });
        ToroPHP_Hook::add("after_handler", function() { echo "After"; });
    }

    function get(ToroPHP_Request $request = null)
    {
        echo "I am some handler.";
    }
}
```

Hooks can also be stacked. Adding a hook pushes the provided anonymous function into an array. When a hook is fired, all of the functions are called sequentially.


## Installation

Grab a copy of the repository and move `ToroPHP`, `ToroPHP_Autoloader`, `bootstrap` to your htdocs or library directory. You may need to add the following snippet in your Apache virtual host configuration or `.htaccess`:

    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond $1 !^(index\.php)
    RewriteRule ^(.*)$ /index.php/$1 [L]


## Contributions

- Toro was inspired by the [Tornado Web Server](http://www.tornadoweb.org) (FriendFeed/Facebook)
- [Berker Peksag](http://berkerpeksag.com), [Martin Bean](http://www.martinbean.co.uk), [Robbie Coleman](http://robbie.robnrob.com), and [John Kurkowski](http://about.me/john.kurkowski) for bug fixes and patches
- [Danillo César de O. Melo](https://github.com/danillos/fire_event/blob/master/Event.php) for `ToroHook`
- [Jason Mooberry](http://jasonmooberry.com) for code optimizations and feedback
- [Cédric ROCHART](http://cedric-rochart.com) for code optimizations

Contributions to Toro are welcome via pull requests.


## License

ToroPHP was created by [Kunal Anand](http://kunalanand.com) and released under the MIT License.
