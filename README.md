Media manager for open-developer
===============================

Media manager for `local` disk.

## Installation

```shell
composer require open-developer-ext/media-manager
```

```
php artisan developer:import media-manager
```

Add a disk config in `config/developer.php`:

```php

    'extensions' => [

        'media-manager' => [

            // Select a local disk that you configured in `config/filesystem.php`
            'disk' => 'public'
        ],
    ],

```

Open `http://localhost/developer/media`.
