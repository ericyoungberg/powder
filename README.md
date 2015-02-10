# Powder
A RESTful API framework for PHP. _0.2.0_

###Installation
1. `git clone` the repository into your existing project.
2. Move the _.htaccess_ file into your project's root folder.

###.htaccess Disabled
A key strength to using Powder is that you can still have it work in a restrictive server environment.
In the config section of the _env.php_ file, set:

```php
define('HTACCESS_ENABLED', false);
```

Whenever you make calls to your API, you will have to manually call the Powder router by prefixing your calls with
`powder/router.php?restful=`, turning your calls from `/posts`, to `powder/router.php?restful=/posts`

Or using Ember for example:

```javascript
// app/adapters/application.js

export default Ember.RESTAdapter.extend({
  namespace: 'powder/router.php?restful=' 
});
```

###Controllers
The best way to build out your API is through calling methods from controllers. After you define a new controller file in the 
__controllers__ directory, make sure to add it to you _manifest.php_ file. Powder will not be able to find your controllers otherwise!

###Router
After you have defined some controllers, we can start adding routes to your router. The Router class comes with basic HTTP verbs as 
methods. The structure of a route is shown below.

```php
$router->get('/users', 'UserController', 'find');
$router->post('/users', 'UserController');
```

You define your endpoint, the name of your controller, and optionally, you can list the method to be called. 
Each method comes with a default call so you don't have to list it. The pairings are:

- get -> find
- post -> create
- put -> udpate
- delete -> remove

###Classes
There are a few utility classes that come include with Powder.

__Network__

::parseRequest() - Will grab the data from the client, sanitize it, and then hand it over so you can work with it.

::respond(<T> data, int status-code) - Responds the to the client. Use to send the return data or error message.

__Database__

::connect() - Creates a new database connection using PDO and the database settings from _env.php_.

###Configuration
Look in the _env.php_ file for all possible configurations and environment variables. ex: Database settings.

###Questions?

If there are any questions or suggested improvements, either submit a issue, pull request, or email me at eric@lmtlss.net.
