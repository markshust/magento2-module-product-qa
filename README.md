# Magento 2 Product Q&A Module

A Magento 2 module that implements a Q&A feature on product pages where customers can ask and answer questions.

## Features

- Questions and answers on product pages
- User-friendly forms for question and answer submission
- Admin management of questions and answers
- Moderation system with approval workflow
- Works for guest users and logged-in customers
- Full emoji support
- Fully responsive design

## Installation

```bash
# Install via composer
composer require markshust/magento2-module-product-qa

# Enable the module
bin/magento module:enable MarkShust_ProductQA

# Run setup upgrade
bin/magento setup:upgrade

# Flush cache
bin/magento cache:flush
```

## Database Configuration

For full emoji support, you must configure your database connection to use `utf8mb4` encoding. Edit your `app/etc/env.php` file and modify the database connection section:

```php
'db' => [
    'table_prefix' => '',
    'connection' => [
        'default' => [
            'host' => 'db',
            'dbname' => 'magento',
            'username' => 'magento',
            'password' => 'magento',
            'model' => 'mysql4',
            'engine' => 'innodb',
            'initStatements' => 'SET NAMES utf8mb4;',
            'active' => '1',
            'driver_options' => [
                1014 => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ]
        ]
    ]
],
```

After making these changes, clean the cache and restart your PHP process:

```bash
bin/magento cache:clean
```

## Usage

1. Navigate to the product page to see the Q&A tab
2. Users can submit questions about the product
3. Other users can answer the questions
4. Admins can moderate questions and answers from the admin panel under Catalog > Product Q&A

## Admin Configuration

The module provides administrative interfaces at:

- **Catalog > Product Q&A > Questions** - Manage product questions
- **Catalog > Product Q&A > Answers** - Manage answers to questions

Questions and answers require admin approval before appearing on the frontend.
