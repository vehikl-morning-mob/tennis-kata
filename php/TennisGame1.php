<?php

class TennisGame1 implements TennisGame
{
    private const MAX_TOTAL = 4;
    private const LOVE_ALL = "Love-All";
    private const FIFTEEN_ALL = "Fifteen-All";
    private const THIRTY_ALL = "Thirty-All";
    private const DEUCE = "Deuce";
    private const LOVE = "Love";
    private const FIFTEEN = "Fifteen";
    private const THIRTY = "Thirty";
    private const FORTY = "Forty";
    private const ADVANTAGE_PLAYER_1 = "Advantage player1";
    private const ADVANTAGE_PLAYER_2 = "Advantage player2";
    private const WIN_FOR_PLAYER_1 = "Win for player1";
    private const WIN_FOR_PLAYER_2 = "Win for player2";
    private const PLAYER_1_NAME = 'player1';
    private $m_score1 = 0;
    private $m_score2 = 0;
    private $player1Name = '';
    private $player2Name = '';

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function wonPoint($playerName)
    {
        if (self::PLAYER_1_NAME == $playerName) {
            $this->m_score1++;
        } else {
            $this->m_score2++;
        }
    }

    public function getScore()
    {
        $score = "";
        if ($this->m_score1 == $this->m_score2) {
            $score = $this->stringifyScoreForTiedGame();
        } elseif ($this->m_score1 >= self::MAX_TOTAL || $this->m_score2 >= self::MAX_TOTAL) {
            $minusResult = $this->m_score1 - $this->m_score2;
            $score = $this->stringifyScoreForLateGame($minusResult);
        } else {
            $score = $this->stringifyScoreForUntiedGame($score);
        }
        return $score;
    }

    public function stringifyScoreForLateGame(int $minusResult): string
    {
        if ($minusResult == 1) {
            $score = self::ADVANTAGE_PLAYER_1;
        } elseif ($minusResult == -1) {
            $score = self::ADVANTAGE_PLAYER_2;
        } elseif ($minusResult >= 2) {
            $score = self::WIN_FOR_PLAYER_1;
        } else {
            $score = self::WIN_FOR_PLAYER_2;
        }
        return $score;
    }

    public function stringifyScoreForUntiedGame(string $score): string
    {
        for ($i = 1; $i < 3; $i++) {
            if ($i == 1) {
                $tempScore = $this->m_score1;
            } else {
                $score .= "-";
                $tempScore = $this->m_score2;
            }
            switch ($tempScore) {
                case 0:
                    $score .= self::LOVE;
                    break;
                case 1:
                    $score .= self::FIFTEEN;
                    break;
                case 2:
                    $score .= self::THIRTY;
                    break;
                case 3:
                    $score .= self::FORTY;
                    break;
            }
        }
        return $score;
    }

    public function stringifyScoreForTiedGame(): string
    {
        switch ($this->m_score1) {
            case 0:
                $score = self::LOVE_ALL;
                break;
            case 1:
                $score = self::FIFTEEN_ALL;
                break;
            case 2:
                $score = self::THIRTY_ALL;
                break;
            default:
                $score = self::DEUCE;
                break;
        }
        return $score;
    }
}

