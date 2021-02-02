# blog
Demo blog application written in PHP using no frameworks. This app implements the MVC pattern in order to serve up content.

Allows creation of blog posts as well as commenting on created posts.

## To Run
1. Clone repository
2. either setup a virtual host with the DocumentRoot set as the root of this repo OR use PHP's built in webserver - php -S localhost:8080

## Routing
Routing is taken care of within the App class' run method. Routes comprise of a controller and a view.
Example:
localhost:8080/post/create
This would direct you to the PostController and call the create() method.

If no view is specified, then the fallback is to index()
If no controller is specfified then the fallback is to HomeController

Any leftover parts of the uri (so anything after the view) will be passed down as a variable to the view's function.

## Templating and Rendering
Template files are stored in App/Views and use plain PHP. To pass data to a view, in your controller, use the set() method.

To render your view, at the end of your controller method call the render() function. NOTE: You NEED to set the protected $view property of your controller class in order to tell the base controller what file to load.
