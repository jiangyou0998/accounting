<?php

return [
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'users',
        'users_model' => App\User::class,

        // Role table and model.
        'roles_table' => 'roles',
        'roles_model' => App\Models\Role::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => App\Models\Permission::class,

        // Menu table and model.
        'menu_table' => 'menu',
        'menu_model' => App\Models\Menu::class,

        // Pivot table for table above.
//        'operation_log_table' => 'admin_operation_log',
//        'role_users_table' => 'admin_role_users',
//        'role_permissions_table' => 'admin_role_permissions',
//        'role_menu_table' => 'admin_role_menu',
//        'permission_menu_table' => 'admin_permission_menu',
    ],

];
