# Version 0.1.9

## Bugfixes

* None

## Features

* Add dependency to appserver-io/logger
* Add monitoring and profiling logger to MultiThreadedServer

# Version 0.1.8

## Bugfixes

* Removed enum like server state usage to simple consts due to incompatibility with pthreads v1.0.2

## Features

* None

# Version 0.1.7

## Bugfixes

* None

## Features

* Added dummy loggers

# Version 0.1.6

## Bugfixes

* Removed deprecated server.php script
* Refactored ZTS check

## Features

* None

# Version 0.1.5

## Bugfixes

* None

## Features

* Added server states

# Version 0.1.4

## Bugfixes

* Replace UNIX directory separators with OS specific directory separators when loading SSL certificate

## Features

* None

# Version 0.1.3

## Bugfixes

* None

## Features

* Replace local $serverUp variable with a member variable that holds the server state

# Version 0.1.2

## Bugfixes

* Bugfix for invalid mime type key 3gpp 3gp => add separate key/value pair
* Add PHPUnit test for MimeTypes class

## Features

* None

# Version 0.1.1

## Bugfixes

* None

## Features

* Refactoring ANT PHPUnit execution process
* Composer integration by optimizing folder structure (move bootstrap.php + phpunit.xml.dist => phpunit.xml)
* Switch to new appserver-io/build build- and deployment environment
