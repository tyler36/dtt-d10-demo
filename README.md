# Drupal Test Traits <!-- omit in toc -->

- [Overview](#overview)
- [Installation](#installation)

## Overview

Drupal Test Traits allows you to perform tests on a site with content.
Typically, functional tests wipe the database and initialize a new Drupal site on each test.

## Installation

1. Install via composer

   ```shell
   composer require weitzman/drupal-test-traits --dev
   ```

2. Make sure you also have `drupal/core-dev`

    ```shell
    composer require drupal/core-dev --dev --update-with-all-dependencies
    ```
