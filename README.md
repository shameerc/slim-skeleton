## Slim 3 Project Skeleton

This is a simple Slim 3 project skeleton with Doctrine, Twig, Monolog, etc. Heavily inspired by [akrabat/slim3-skeleton](https://github.com/akrabat/slim3-skeleton)  
We have replaced Pimple Container with Aura.Di for dependency injection. 

###Installation
```
composer create-project shameerc/slim-skeleton
```

###Configuration
This project uses [phpdotenv](https://github.com/vlucas/phpdotenv) for the managing configuration values. We have a `.env.example` file in the root of the project, as a placeholder for the required config values. Copy this file to `.env` and change the values as needed for your development machine.

###Directory Permissions
Once you install the project, you may need to change the permission for `app/storage/*` directories to make it writable by the web server.

###Run it!
Now we are ready to run the application
```
php -S localhost:9000 -t public/
```