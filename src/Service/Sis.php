<?php

namespace Mindbird\Contao\SisBundle\Service;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use Doctrine\DBAL\Connection;
use Mindbird\Contao\SisBundle\Model\SisGamesModel;
use Mindbird\Contao\SisBundle\Model\SisLeagueModel;
use Mindbird\Contao\SisBundle\Model\SisStandingsModel;
use Psr\Log\LogLevel;

class Sis
{
    protected $sisUrl = 'https://www.sis-handball.de/xmlexport/xml_dyn.aspx?user=%s&pass=%s&art=%s&auf=%s';

    public function updateLeague($sisId): void
    {
        /** @var $league SisLeagueModel|null */
        $league = SisLeagueModel::findOneBy('sisId', $sisId);
        if ($league !== null && $league->user !== '' && $league->password !== '') {
            $gamesXml = $this->fetchGamesXmlFromSis($league->user, $league->password, $sisId);
            if ($gamesXml !== null) {
                $league->gamesXml = $gamesXml;
                $games = $this->parseGamesXml($gamesXml, $league->favoriteTeam);
                if (\count($games) > 0) {
                    $this->writeGameDataToDb($sisId, $games);
                }

            }

            $standingsXml = $this->fetchStandingsXmlFromSis($league->user, $league->password, $league->sisId);
            if ($standingsXml !== null) {
                $league->$standingsXml = $standingsXml;
                $standings = $this->parseStandingsXml($standingsXml);
                if (\count($standings) > 0) {
                    $this->writeStandingsDataToDb($sisId, $standings);
                }
            }

            $league->save();
        }
    }

    public function fetchGamesXmlFromSis($user, $password, $sisId)
    {
        $xml = $this->fetchXmlFromSis($user, $password, $sisId, 1);

        return $this->checkIfXmlContainsValidSpielklasse($xml);
    }

    protected function fetchXmlFromSis($user, $password, $sisId, $type)
    {
        $xml = file_get_contents(
            sprintf($this->sisUrl, $user, $password, $type, $sisId)
        );

        if ($xml !== '') {
            return $xml;
        }

        return null;
    }

    protected function checkIfXmlContainsValidSpielklasse($xml)
    {
        if ($xml !== null) {
            $xmlObject = simplexml_load_string($xml);
            if ($xmlObject !== false && $xmlObject->Spielklasse) {
                return $xml;
            }
        }

        return null;
    }

    protected function parseGamesXml($xml, $favoriteTeam): array
    {
        $games = [];
        $xmlObject = simplexml_load_string($xml);
        foreach ($xmlObject->Spiel as $game) {
            if ((string)$game->Mannschaft1 === $favoriteTeam || (string)$game->Mannschaft2 === $favoriteTeam) {
                $games[] = [
                    'date' => new \DateTime((string)$game->SpielVon),
                    'homeTeam' => (string)$game->Heim,
                    'homeGoals' => (int)$game->Tore1,
                    'homePoints' => (int)$game->Punkte1,
                    'enemyTeam' => (string)$game->Gast,
                    'enemyGoals' => (int)$game->Tore2,
                    'enemyPoints' => (int)$game->Punkte2,
                    'address' => (string)$game->HallenName . ', '
                        . (string)$game->HallenStrasse . ', '
                        . (string)$game->HallenOrt

                ];
            }
        }

        return $games;
    }

    /**
     * @param $sisId
     * @param $games
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function writeGameDataToDb($sisId, $games): void
    {
        try {
            /** @var $db Connection */
            $db = System::getContainer()->get('doctrine')->getConnection();
            $deleteStatment = $db->prepare("DELETE FROM tl_sis_games WHERE leagueSisId = :leagueSisId");
            $deleteStatment->bindParam('leagueSisId', $sisId);
            $deleteStatment->execute();

            foreach ($games as $game) {
                $gameModel = new SisGamesModel();
                $gameModel->setRow($game);
                $gameModel->date = $game['date']->format('Y-m-d H:i:s');
                $gameModel->leagueSisId = $sisId;
                $gameModel->save();
            }
        } catch (\Exception $e) {
            System::getContainer()->get('monolog.logger.contao')
                ->log(
                    LogLevel::EMERGENCY,
                    'Can not access db',
                    [
                        'contao' => new ContaoContext(__CLASS__ . '::' . __FUNCTION__, TL_ERROR)
                    ]
                );
        }

    }

    protected function parseStandingsXml($xml): array
    {
        $standings = [];
        $xmlObject = simplexml_load_string($xml);
        foreach ($xmlObject->Platzierung as $position) {
                $standings[] = [
                    'position' => (int)$position->Nr,
                    'team' => (string)$position->Name,
                    'actualGames' => (int)$position->Spiele,
                    'maxGames' => (int)$position->SpieleInsgesamt,
                    'gamesWon' => (int)$position->Gewonnen,
                    'gamesDraw' => (int)$position->Unentschieden,
                    'gameslost' => (int)$position->Verloren,
                    'goalsScored' => (int)$position->TorePlus,
                    'goalsCaught' => (int)$position->ToreMinus,
                    'goalsDifference' => (int)$position->D,
                    'pointsScored' => (int)$position->PunktePlus,
                    'pointsCaught' => (int)$position->PunkteMinus,
                ];
        }

        return $standings;
    }

    /**
     * @param $sisId
     * @param $standings
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function writeStandingsDataToDb($sisId, $standings): void
    {
        try {
            /** @var $db Connection */
            $db = System::getContainer()->get('doctrine')->getConnection();
            $deleteStatment = $db->prepare("DELETE FROM tl_sis_standings WHERE leagueSisId = :leagueSisId");
            $deleteStatment->bindParam('leagueSisId', $sisId);
            $deleteStatment->execute();

            foreach ($standings as $position) {
                $standingModel = new SisStandingsModel();
                $standingModel->setRow($position);
                $standingModel->leagueSisId = $sisId;
                $standingModel->save();
            }
        } catch (\Exception $e) {
            System::getContainer()->get('monolog.logger.contao')
                ->log(
                    LogLevel::EMERGENCY,
                    'Can not access db',
                    [
                        'contao' => new ContaoContext(__CLASS__ . '::' . __FUNCTION__, TL_ERROR)
                    ]
                );
        }

    }

    public function fetchStandingsXmlFromSis($user, $password, $sisId)
    {
        $xml = $this->fetchXmlFromSis($user, $password, $sisId, 4);

        return $this->checkIfXmlContainsValidSpielklasse($xml);
    }
}
