<?php

namespace Mindbird\Contao\SisBundle\Module;

use Contao\BackendTemplate;
use Contao\Module;
use Mindbird\Contao\SisBundle\Model\SisGamesModel;

class Weekend extends Module
{
    protected $strTemplate = 'mod_sis_weekend';

    public function generate()
    {
        if (TL_MODE === 'BE') {
            $template = new BackendTemplate('be_wildcard');
            $template->wildcard = '### SIS - GAMES WEEKEND ###';
            $template->title = $this->name;
            $template->id = $this->id;

            return $template->parse();
        }

        return parent::generate();
    }

    protected function compile()
    {
        $games = $this->getNextWeekendWithGames(new \DateTime());

        $this->Template->games = $games;
    }

    protected function getNextWeekendWithGames(\DateTime $date, $counter = 0)
    {
        $gamesOnWeekend = false;
        /**
         * @var $saturday \DateTime
         * @var $sunday \DateTime
         */
        $weekend = $this->calcWeekend($date);
        $saturday = $weekend['saturday'];
        $sunday = $weekend['sunday'];
        $games = [
            'saturday' => ['date', 'games'],
            'sunday' => ['date', 'games']
        ];


        $saturdayEnd = clone $saturday->setTime(23, 59, 59);
        $saturdayStart = clone $saturday->setTime(0, 0, 0);
        $gamesSaturday = SisGamesModel::findBy(['date >= ? ', 'date <= ?'], [$saturdayStart->format('Y-m-d H:i'), $saturdayEnd->format('Y-m-d H:i')], ['order' => 'date ASC']);
        if ($gamesSaturday !== null && $gamesSaturday->count() > 0) {
            $games['saturday']['date'] = $saturday->format('d.m.Y');
            $games['saturday']['games'] = $gamesSaturday;
            $gamesOnWeekend = true;
        }

        $sundayEnd = clone $sunday->setTime(23, 59, 59);
        $sundayStart = clone $sunday->setTime(0, 0, 0);
        $gamesSunday = SisGamesModel::findBy(['date >= ?', 'date <= ?'], [$sundayStart->format('Y-m-d H:i'), $sundayEnd->format('Y-m-d H:i')], ['order' => 'date ASC']);
        if ($gamesSunday !== null && $gamesSunday->count() > 0) {
            $games['sunday']['date'] = $sunday->format('d.m.Y');
            $games['sunday']['games'] = $gamesSunday;
            $gamesOnWeekend = true;
        }

        if ($gamesOnWeekend || $counter > 5) {
            return $games;
        }

        $counter++;
        return $this->getNextWeekendWithGames($date->add(new \DateInterval('P7D')), $counter);
    }

    protected function calcWeekend(\DateTime $date): array
    {
        $dayOfWeek = $date->format('N'); //monday = 1, tuesday = 2, etc.
        $satDiff = 6 - $dayOfWeek; //for monday we need to add 5 days -> 6 - 1

        $saturday = clone $date;
        if ($satDiff > 0) {
            $saturday = $saturday->add(new \DateInterval('P' . $satDiff . 'D'));
        } elseif ($satDiff < 0) {
            $saturday = $saturday->sub(new \DateInterval('P' . -1*$satDiff . 'D'));
        }

        $sunday = clone $saturday;
        $sunday->add(new \DateInterval('P1D'));
        return [
            'saturday' => $saturday,
            'sunday' => $sunday
        ];
    }
}