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

    $app = new EchoApp(); // Start the app

    $app->use($middleware);  // Use some sort of middleware

    // Define a GET route 
    $app->get('/', function($req, $res){
        res->status(200)->json(['message' => 'A get route on the root']);
    });

    // Handle the request
    $app->start();

## Dependcies
Echo requires Laravel\SerializableClosure\SerializableClosure;

https://github.com/laravel/serializable-closure

## Future
More database support - MySQL, PostgresSQL and MariaDB support.

Redis Middleware Plugin - provide a seemless way to plugin and use Redis with Echo.

MongoDB support - Provide NoSQL database support.

Rate Limiting - Provide rate limiting on the App, Routers, and Routes.

EchoTest - A testing framework designed specifically for Echo.

Better caching - The caching system could use a major rework, and more policies.

ORM Support - Either EchoORM or provide a middleware plugin to utilize an ORM.

CL Tool - Provide a command line tool for Echo.
