<?php

namespace Mindbird\Contao\SisBundle\Module;

use Contao\BackendTemplate;
use Contao\Module;
use Mindbird\Contao\SisBundle\Model\SisGamesModel;
use Mindbird\Contao\SisBundle\Model\SisLeagueModel;

class Games extends Module
{
    protected $strTemplate = 'mod_sis_games';

    public function generate()
    {
        if (TL_MODE === 'BE') {
            $template = new BackendTemplate('be_wildcard');
            $template->wildcard = '### SIS - GAMES ###';
            $template->title = $this->name;
            $template->id = $this->id;

            return $template->parse();
        }

        return parent::generate();
    }

    protected function compile()
    {
        $days = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
        $games = [];
        /** @var $league SisLeagueModel */
        $league = SisLeagueModel::findByPk($this->sisLeague);
        if ($league !== null) {
            $options = [
                'column' => [
                    'leagueSisId = ?'
                ],
                'value' => [
                    $league->sisId
                ]
            ];
            if ($this->sisUpcomingGames === 1) {
                $date = new \DateTime();
                $options['column'][] = 'date >= ?';
                $options['value'][] = $date->format('Y-m-d H:i');
            }

            if ($this->sisNumberOfGames > 0) {
                $options['limit'] = $this->sisNumberOfGames;
            }

            $game = SisGamesModel::findAll($options);
            if ($game !== null) {
                while ($game->next()) {
                    $cssClass = [];
                    $date = new \DateTime($game->date);

                    $games[] = array_merge(
                        $game->row(),
                        [
                            'date' => $date->format('d.m.Y'),
                            'time' => $date->format('H:i'),
                            'dayOfWeek' => $days[$date->format('w')],
                            'cssClass' => implode(' ', $cssClass)
                        ]
                    );
                }
            }
        }

        $this->Template->games = $games;
    }
}
