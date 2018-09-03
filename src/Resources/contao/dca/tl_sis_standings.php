<?php

/**
 * Table person_entry
 */
$GLOBALS ['TL_DCA'] ['tl_sis_standings'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'leagueSisId' => 'index'
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
                'sisId',
                'title'
            ],
            'format' => '[%s] %s'
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS ['TL_LANG'] ['MSC'] ['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            ]
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ],
            'copy' => [
                'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'delete' => [
                'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS ['TL_LANG'] ['MSC'] ['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ]
        ]
    ],
    // Palettes
    'palettes' => [
        'default' => '{name_legend},sisId,user,password;'
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'leagueSisId' => [
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'position' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'team' => [
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'teamSisId' => [
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'actualGames' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'maxGames' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'gamesWon' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'gamesDraw' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'gamesLost' => [
            'sql' => "smallint(2) unsigned NOT NULL default '0'"
        ],
        'goalsScored' => [
            'sql' => "smallint(4) unsigned NOT NULL default '0'"
        ],
        'goalsCaught' => [
            'sql' => "smallint(4) unsigned NOT NULL default '0'"
        ],
        'goalsDifference' => [
            'sql' => "smallint(4) signed NOT NULL default '0'"
        ],
        'pointsScored' => [
            'sql' => "smallint(3) unsigned NOT NULL default '0'"
        ],
        'pointsCaught' => [
            'sql' => "smallint(3) unsigned NOT NULL default '0'"
        ]
    ]
];

