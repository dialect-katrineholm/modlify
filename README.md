# Modlify
Modlify generates stubs for Laravel-components using existing models. Modlify tries to figure out model-validation and factories based on the migrated table for the model.

## Installation

Install via composer

    composer require dialect/modlify

It is possible publish the views modlify uses to generate the stubs if custom modification is wanted.

    php artisan vendor:publish --provider="Dialect\TransEdit\TransEditServiceProvider"

## Usage
