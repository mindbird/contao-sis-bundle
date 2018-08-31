<?php

/**
 * Table person_entry
 */
$GLOBALS ['TL_DCA'] ['tl_sis_clubs'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => [
                'title'
            ]
        ],
        'label' => [
            'fields' => [
                'title'
            ],
            'format' => '%s'
        ],
        'global_operations' => [],
        'operations' => []
    ],
    // Palettes
    'palettes' => [
        'default' => '{name_legend},title;'
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'title' => [
            'sql' => "varchar(255) NOT NULL default ''"
        ]
    ]
];

