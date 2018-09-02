<?php

/**
 * Table person_entry
 */
$GLOBALS ['TL_DCA'] ['tl_sis_league'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'sisId' => 'index'
            ]
        ],
        'onsubmit_callback' => [
            [
                'Mindbird\Contao\SisBundle\Table\League',
                'onsubmitCallback'
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
        'default' => '{name_legend},sisId,user,password,favoriteTeam;'
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sisId' => [
            'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['sisId'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
                'maxlength' => 64
            ],
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'title' => [
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'standingsXml' => [
            'sql' => "text() NULL"
        ],
        'gamesXml' => [
            'sql' => "text() NULL"
        ],
        'user' => [
            'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['user'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'tl_class' => 'w50',
                'maxlength' => 255
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'password' => [
            'label' => &$GLOBALS ['TL_LANG'] ['tl_sis_league'] ['password'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'tl_class' => 'w50',
                'maxlength' => 255
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'favoriteTeam' => [
            'label' => &$GLOBALS['TL_LANG']['tl_company']['category'],
            'exclude' => true,
            'inputType' => 'select',
            'filter' => true,
            'eval' => [
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(64) NOT NULL default ''",
            'options_callback' => [
                'Mindbird\Contao\SisBundle\Table\League',
                'optionsCallbackTeam'
            ]
        ],
    ]
];

