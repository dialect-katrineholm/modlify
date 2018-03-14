# Modlify
Modlify generates stubs for Laravel-components using existing models. Modlify tries to figure out model-validation and factories based on the migrated table for the model.

## Installation

Install via composer

    composer require dialect/modlify

It is possible publish the views modlify uses to generate the stubs if custom modification is wanted.

    php artisan vendor:publish --provider="Dialect\TransEdit\TransEditServiceProvider"

## Usage

Modlify can currently generate:
    
``php artisan modlify:controller`` - Generates Controller.
    
``php artisan modlify:factory`` - Generates Factory.
    
``php artisan modlify:policy`` - Generates Policy and adds it to AuthServiceProvider.php
    
``php artisan modlify:route`` - Adds route to web.php
    
``php artisan modlify:tests`` - Generates tests
    
``php artisan modlify:views`` - Generates views
    
``php artisan modlify:all`` Generates all of the components.
    

You can either specify a model, or use the ``--all`` parameter to make Modlify find all available models in the app directory.
By default Modlify doesn't overwrite existing files, it is possible to force overwrites with the ``-force`` parameter

## Customization

All the views has access to the following variables:

``model`` - Empty instance of the model

``modelName`` - Name of Model, e.g User or ArticleType

``databaseName`` - Name of database, e.g Forge

``tableName`` - Name of table, e.g users or article_types

``variableName`` - Name of variable e.g $user or $aricleTypes

``collectionName`` - Name of variable of collection of models e.g $users or $articleTypes

``resourceName`` - Name of resource, e.g users or article-types

``columns`` - Array of columns avaiable in table

Some generators has extra varables:

Controller

``validations`` - Validation rules
``hasPassword`` - Model has password

Factory

``fakers`` - List of calls to the faker instance.

Policy

``argumentName``- name of model varaible to avoid collition with $user.

Test

``checkColumn``- name of column to use to check if model is seen in view.
``hasPassword`` - Model has password
