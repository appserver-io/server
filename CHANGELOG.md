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