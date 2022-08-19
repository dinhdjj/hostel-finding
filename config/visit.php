<?php

declare(strict_types=1);

// config for dinhdjj/laravel-visit package
return [
    // Table name for visit logs
    'table' => 'visits',

    // The model class name that will be used to store visit logs, must be a subclass of \Dinhdjj\Visit\Models\Visit
    'model' => App\Models\Visit::class,
];
