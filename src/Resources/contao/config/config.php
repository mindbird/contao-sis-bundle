<?php

$GLOBALS ['BE_MOD'] ['content'] ['sis'] = array(
    'tables' => array(
        'tl_sis_league'
    )
);

$GLOBALS['TL_MODELS']['tl_sis_league'] = '\Mindbird\Contao\SisBundle\Model\SisLeagueModel';
$GLOBALS['TL_MODELS']['tl_sis_games'] = '\Mindbird\Contao\SisBundle\Model\SisGamesModel';
$GLOBALS['TL_MODELS']['tl_sis_standings'] = '\Mindbird\Contao\SisBundle\Model\SisStandingsModel';
