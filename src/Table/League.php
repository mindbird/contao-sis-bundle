<?php

/*
 * This file is part of [contao-sis-bundle].
 *
 * (c) mindbird
 *
 * @license LGPL-3.0-or-later
 */

namespace Mindbird\Contao\SisBundle\Table;

use Mindbird\Contao\SisBundle\Model\SisLeagueModel;

class League
{
    public function optionsCallbackTeam($dc)
    {
        $link = 'https://www.sis-handball.de/xmlexport/xml_dyn.aspx?user=%s&pass=%s&art=4&auf=%s';
        $xml = file_get_contents(
            sprintf($link, $dc->activeRecord->user, $dc->activeRecord->password, $dc->activeRecord->sisId)
        );
        $clubs = [];
        if ($xml !== '') {
            $xml = simplexml_load_string($xml);
            if ($xml->Platzierung) {
                foreach ($xml->Platzierung as $club) {
                    $clubs[(string)$club->Verein] = (string)$club->Name;
                }
            }
        }

        return $clubs;
    }

    public function onsubmitCallback($dc)
    {
        $link = 'https://www.sis-handball.de/xmlexport/xml_dyn.aspx?user=%s&pass=%s&art=4&auf=%s';
        $rawXml = file_get_contents(
            sprintf($link, $dc->activeRecord->user, $dc->activeRecord->password, $dc->activeRecord->sisId)
        );
        if ($rawXml !== '') {
            $link = 'https://www.sis-handball.de/xmlexport/xml_dyn.aspx?user=%s&pass=%s&art=1&auf=%s';
            $rawXmlGames = file_get_contents(
                sprintf($link, $dc->activeRecord->user, $dc->activeRecord->password, $dc->activeRecord->sisId)
            );
            $xml = simplexml_load_string($rawXml);
            $xmlGames = simplexml_load_string($rawXmlGames);
            if ($xml->Spielklasse) {
                $league = SisLeagueModel::findByPk($dc->activeRecord->id);
                $league->title = (string)$xml->Spielklasse->Name;
                $league->standingsXml = $rawXml;
                $league->gamesXml = $rawXmlGames;
                $league->ascentCount = (int)$xml->Spielklasse->Aufstiegsplaetze;
                $league->descentCount = (int)$xml->Spielklasse->Abstiegsplaetze;
                $league->save();
            }
        }
    }
}
