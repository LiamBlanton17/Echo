# Echo
Echo is a lightweight, Express style framework for PHP.


## Concept
Echo only works with JSON. JSON in, JSON out.

This keeps the core of the framework extremely lightweight; easy to use, easy to build, easy to maintain.

The focus is on easy to plug in and out middleware, speed, and reusability.

In addition, the base version of Echo requires one dependency, however support for more dependencies will be added.

## Usage
Check out the example folder in the project for a complete example.

However, below is a breif usage.

### app.php
```
// Load in Echo
require(__DIR__.'/core/EchoRequire');

// Start an app
$app = new EchoApp();

// Define a route
$app->get('/', function(EchoRequest $req, EchoResponse $res){
    $res->status(200)->json([
        'message' => 'Creating a GET route with Echo!'
    ]);
});

// Build the app
$app->build(__DIR__.'/app/app');
```

### server.php
```
// Load in Echo
require(__DIR__.'/core/EchoRequire');

// Boot the app
$app = EchoApp::boot(__DIR__.'/app/app');

// Handle the request
$app->start();
```

## Dependcies
Echo requires Laravel\SerializableClosure\SerializableClosure

https://github.com/laravel/serializable-closure

Closures are not serializable by default in PHP.

## Next
CL Tool - Provide a command line tool for Echo.

EchoTable - Write Relational tables in PHP, and migrate them with the CL Tool.

## Future
More database support - MySQL, PostgresSQL and MariaDB support.

Redis Middleware Plugin - provide a seemless way to plugin and use Redis with Echo.

MongoDB support - Provide NoSQL database support.

Rate Limiting - Provide more advanced rate limiting on the App, Routers, and Routes.

EchoTest - A testing framework designed specifically for Echo.

Better caching - The caching system could use a major rework, and more policies.

EchoViews - Provide an abstraction on top of but detached from EchoTables. In combination, the two will provide an ORM-like abstraction but without the "magic".
