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

1. Make sure you also have `drupal/core-dev`

    ```shell
    composer require drupal/core-dev --dev --update-with-all-dependencies
    ```

1. Create / update `./phpunit.xml` to include additional Tests Suites

    ```xml
    <testsuites>
        ...
        <testsuite name="existing-site">
            <directory>./web/modules/custom/*/tests/src/ExistingSite</directory>
        </testsuite>
        <testsuite name="existing-site-javascript">
            <directory>./web/modules/custom/*/tests/src/ExistingSiteJavascript</directory>
        </testsuite>
    ```

1. Update `./phpunit.xml` to use DTT's `bootstrap-fast.php`.

    ```diff
    - <phpunit bootstrap="web/core/tests/bootstrap.php"
    + <phpunit bootstrap="vendor/weitzman/drupal-test-traits/src/bootstrap-fast.php"
    ```

1. Update `./phpunit.xml` to set environmental variables.

    ```xml
    <php>
        ...
        <env name="DTT_BASE_URL" value="http://example.com"/>
        <env name="DTT_API_URL" value="http://localhost:9222"/>
        <!-- <env name="DTT_MINK_DRIVER_ARGS" value='["chrome", { "chromeOptions" : { "w3c": false } }, "http://localhost:4444/wd/hub"]'/> -->
        <env name="DTT_MINK_DRIVER_ARGS" value='["firefox", null, "http://localhost:4444/wd/hub"]'/>
        <env name="DTT_API_OPTIONS" value='{"socketTimeout": 360, "domWaitTimeout": 3600000}' />
    ```

    - DDEV uses can install `ddev-selenium-standalone-chrome`

    ```shell
    ddev get ddev/ddev-selenium-standalone-chrome
    ddev restart
    ```

    - They can also be set via `.env`, or specific at runtime.
