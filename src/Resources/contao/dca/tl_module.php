<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['sis_standings'] = '{title_legend},name,type;{sis_legend},sisLeague;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['sis_games'] = '{title_legend},name,type;{sis_legend},sisLeague;';

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
