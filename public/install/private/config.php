<?php

$config = [
    'requirement' => [
        'php' => '^8.1.0',

        'extension' => [
            'openssl',
            'pdo',
            'mbstring',
            'json',
            'curl',
            'tokenizer',
            'xml',
            'zip',
            'gd',
            'mysqli',
            'session',
        ],
        'apache' => [
            'mod_rewrite' => true,
        ],

    ],
    'dir_permission' => [
        '/ (root_path)' => base_dir('/'),
        'storage/framework' => base_dir('storage/framework'),
        'storage/logs' => base_dir('storage/logs'),
        'storage/app/public' => base_dir('storage/app/public'),
        'bootstrap/cache' => base_dir('bootstrap/cache'),
    ],

    'menu' => [
        'requirement' => 'Requirement',
        'envato_license' => 'Envato License',
        'env_requirement' => 'Environment Requirement',
        'db_configuration' => 'Database Configuration',
        // 'migration_seeding'   => 'Migration & Seeding',
        'admin_configuration' => 'Admin Configuration',
        // 'finish'           => 'Finish',
    ],
];
