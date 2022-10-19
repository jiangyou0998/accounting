<?php

return [
    'route' => [
        'prefix'     => 'admin/dcat-logs',
        'namespace'  => 'Dcat\LogViewer',
        'middleware' => config('admin.route.middleware'),
    ],

    'directory' => storage_path('logs'),

    'search_page_items' => 500,

    'page_items' => 30,
];
