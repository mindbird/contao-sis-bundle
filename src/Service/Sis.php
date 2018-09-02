<?php

namespace Mindbird\Contao\SisBundle\Service;

use Mindbird\Contao\SisBundle\Model\SisLeagueModel;

class Sis
{
    public function updateLeague($id)
    {
        $league = SisLeagueModel::findByPk($id);
        if ($league !== null) {
            $link = 'https://www.sis-handball.de/xmlexport/xml_dyn.aspx?user=%s&pass=%s&art=4&auf=%s';
            $xml = file_get_contents(
                sprintf($link, $league->user, $league->password, $league->sisId)
            );

            if ($xml !== '') {
                $league->standingsXml = $xml;
                $xml = simplexml_load_string($xml);
                if ($xml->Platzierung) {
                    foreach ($xml->Platzierung as $club) {
                        $clubs[(string)$club->Verein] = (string)$club->Name;
                    }
                }
            }
        }


    }
}
