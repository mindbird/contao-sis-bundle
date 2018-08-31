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
            'inputType' => 'password',
            'eval' => [
                'tl_class' => 'w50',
                'maxlength' => 255
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'favoriteTeam' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_company']['category'],
            'exclude' => true,
            'inputType' => 'select',
            'filter' => true,
            'foreignKey' => 'tl_company_category.title',
            'eval' => array(
                'mandatory' => false,
                'multiple' => true
            ),
            'sql' => "int(10) unsigned NULL",
            'relation' => array(
                'type' => 'hasOne',
                'load' => 'eagerly'
            ),
            'options_callback' => array(
                'Mindbird\Contao\SisBundle\Table;',
                'optionsCallbackCategory'
            )
        ),
    ]
];

