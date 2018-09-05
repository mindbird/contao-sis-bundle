<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['sis_standings'] = '{title_legend},name,type;{sis_legend},sisLeague;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['sis_games'] = '{title_legend},name,type;{sis_legend},sisLeague,sisUpcomingGames,sisNumberOfGames;{template_legend:hide},customTpl;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['sis_weekend'] = '{title_legend},name,type;';

$GLOBALS['TL_DCA']['tl_module']['fields']['sisLeague'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['sisLeague'],
    'default' => '',
    'exclude' => true,
    'inputType' => 'select',
    'foreignKey' => 'tl_sis_league.title',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50'
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['sisNumberOfGames'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['sisNumberOfGames'],
    'default' => '',
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ],
    'sql' => "tinyint(2) unsigned NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['sisUpcomingGames'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['sisUpcomingGames'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'options' => [1 => 'Nur zukünftige Spiele anzeigen'],
    'eval' => [
        'tl_class' => 'clr w50 m12'
    ],
    'sql' => "varchar(255) NOT NULL default ''"
];
