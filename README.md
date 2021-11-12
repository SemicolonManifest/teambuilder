# TeamBuilder

TeamBuilder is a PHP application for the module PRW-1 at [CPNV](https://www.cpnv.ch).

## Installation

Use the package manager [composer](https://getcomposer.org/download/).

This project require [phpUnit](https://phpunit.de/getting-started/phpunit-9.html)

```bash
git clone https://github.com/TGACPNV/teambuilder.git
composer install
```

This project use SCSS styles so you need to install sass and execute it in this directory : ```views/styles/SCSS```
It has to create the css in a directory named "CSS" next to the SCSS directory.

This project uses MariaDB 10.5.10 too.
## Usage

1. Execute the sql script below to create the database in your MariaDb engine.

    ```doc/sql/teambuilder.sql```
2. Copy Controller/.testCreds.exemple.php into Controller/.testCreds.php
3. Copy Model/.env.example.php into Model/.env.php
4. Complete both files