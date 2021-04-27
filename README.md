# CABP Resource List

<p align="center">
  <a href="LICENSE.md">
    <img alt="MIT License" src="https://img.shields.io/github/license/roots/bedrock?color=%23525ddc&style=flat-square" />
  </a>

  <a href="https://carlos-bucheli.com/repos">
    <img alt="Build Status" src="https://img.shields.io/circleci/build/gh/roots/bedrock?style=flat-square" />
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
