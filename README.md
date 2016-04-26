### Requirements
* PHP 5.6+ with PGSQL driver
* Composer 1.0+
* VirtualBox 5+
* Vagrant 1.7+
* Bower 1.7+

### Getting started
* spin up virtual machine ```$ vagrant up```
* install php deps via ```$ composer install```
* install front-end deps ```$ bower install```
* apply database migrations ```$ ./phinx migrate```
* run database seeds (for dev) ```$ ./phinx seed:run```
* start PHP embedded server ```$ ./scripts/run.sh```
* open in browser: http://localhost:8000

### Running automated tests
* ```$ ./scripts/test.sh```

Mikk Tarvas
