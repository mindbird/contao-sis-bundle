<?php

namespace Mindbird\Contao\SisBundle\Module;

use Contao\BackendTemplate;
use Contao\Module;
use Mindbird\Contao\SisBundle\Model\SisLeagueModel;
use Mindbird\Contao\SisBundle\Model\SisStandingsModel;

class Standings extends Module
{
    protected $strTemplate = 'mod_sis_standings';

    public function generate()
    {
        if (TL_MODE === 'BE') {
            $template = new BackendTemplate('be_wildcard');
            $template->wildcard = '### SIS - STANDINGS ###';
            $template->title = $this->name;
            $template->id = $this->id;

            return $template->parse();
        }

        return parent::generate();
    }

    protected function compile()
    {
        $position = [];
        /** @var $league SisLeagueModel */
        $league = SisLeagueModel::findByPk($this->sisLeague);
        if ($league !== null) {
            $standings = SisStandingsModel::findBy('leagueSisId', $league->sisId);
            if ($standings !== null) {
                $ascentPosition = [];
                $descentPosition = [];
                $maxPosition = $standings->count();
                for ($i = 1; $i <= $maxPosition; $i++) {
                    if ($i <= $league->ascentCount) {
                        $ascentPosition[] = $i;
                    }
                    if ($i >= $maxPosition - $league->descentCount) {
                        $descentPosition[] = $i;
                    }
                }

                while ($standings->next()) {
                    $cssClass = [];
                    if ($standings->teamSisId === $league->favoriteTeam) {
                        $cssClass[] = 'favoriteTeam';
                    }

                    if (\in_array($standings->position, $ascentPosition)) {
                        $cssClass[] = 'ascent';
                    }

                    if (\in_array($standings->position, $descentPosition)) {
                        $cssClass[] = 'descent';
                    }

                    $position[] = array_merge(
                        $standings->row(),
                        [
                            'cssClass' => implode(' ', $cssClass)
                        ]
                    );
                }
            }
        }

        $this->Template->position = $position;
    }
}
