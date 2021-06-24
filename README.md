# CABP Resource List

<p align="center">
  <a href="LICENSE.md">
    <img alt="MIT License" src="https://img.shields.io/github/license/roots/bedrock?color=%23525ddc&style=flat-square" />
  </a>
</p>

Resource List is a Wordpress Plugin for the Inpsyde coding challenge.

## Scaffolding
Wordpress was installed using composer. To that effect I'm using the [Bedrock](https://roots.io/bedrock/) boilerplate, which provides a standardized scaffolding for WP projects. As a result, there are a few additional packages:

- [composer/installers](https://github.com/composer/installers) - Install a package in a location based on the package type
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) - Load environment variables from .env files
- [oscarotero/env](https://github.com/oscarotero/env) - Get environment variables converted to simple types
- [bedrock](https://roots.io/docs/bedrock/master/installation/) - Read more about the boilerplate used in this project.

The codebase for the plugin is in the `cabp_packages` directory, `composer.json` has an entry in the `repositories` key, allowing to install it from where the codebase is.

## Installation

This plugin requires [PHP](https://php.net/) v7.4.11+ to run.

1. Clone this repo.

    ```sh
    git clone https://github.com/cabp-ec/inpsyde.git cabp-inpsyde
    cd cabp-inpsyde
    composer install
    ```

2. Set your database connection settings in the .env file

    ```sh
    DB_NAME='my_database'
    DB_USER='dbuser'
    DB_PASSWORD='dbpass'
    ```

3. Install WordPress as usual

## Usage

Navigate to `/cabp` and you'll see the plugin in action.


## Autoloading

The plugin has been updated to use autoloading with Composer:

    autoload": {
      "psr-4": {
        "Cabp\\ResourceList\\": "includes",
        "Cabp\\ResourceList\\Admin\\": "admin",
        "Cabp\\ResourceList\\_Public\\": "public"
      }
    }
    

## Dependency Injection

This is the first time I use DI with WordPress.
My first attempt was to use Symfony's DI component, unfortunately
it didn't work because it's throwing an error about compatibility
with PSR-11. That happens because PHP Fig already updated the PSR
interfaces while the [php-psr](https://github.com/jbboehr/php-psr)
library did not, and that library is required by
[Phalcon](https://github.com/composer/installers) (which I use frequently).
Therefore, I decided to use [PHP/DI]() instead, using autowiring and PHP definitions.

## Unit Testing

This is the first time I do unit testing with WordPress, so I wasn't
sure how this was going to work or what exactly to test.
The [Brain Monkey](https://giuseppe-mazzapica.gitbook.io/brain-monkey/)
library have been included in the project, with a basic implementation.
The library looks and feels nice and easy enough to start with; however,
—so far, it's failing when using the SP function `flush_rewrite_rules`,
which I thought was going to be recognized by Brain Monkey.
I'm further reading about this library in order to sove that issue
but also implementing more tests.
