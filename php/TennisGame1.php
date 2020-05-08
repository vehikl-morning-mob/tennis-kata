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
    private $player1NumericalScore = 0;
    private $player2NumericalScore = 0;
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
            $this->player1NumericalScore++;
        } else {
            $this->player2NumericalScore++;
        }
    }

    public function getScore()
    {
        $score = "";
        if ($this->player1NumericalScore == $this->player2NumericalScore) {
            $score = $this->stringifyScoreForTiedGame();
        } elseif ($this->isAtLeastOnePlayerAboveTheMaxScore()) {
            $score = $this->stringifyScoreForLateGame();
        } else {
            $score = $this->stringifyScoreForUntiedGame($score);
        }
        return $score;
    }

    public function stringifyScoreForLateGame(): string
    {
        if ($this->isAdvantagePlayer(1)) {
            $score = self::ADVANTAGE_PLAYER_1;
        } elseif ($this->isAdvantagePlayer(-1)) {
            $score = self::ADVANTAGE_PLAYER_2;
        } elseif ($this->isWinPlayer1()) {
            $score = self::WIN_FOR_PLAYER_1;
        } else {
            $score = self::WIN_FOR_PLAYER_2;
        }
        return $score;
    }

    public function stringifyScoreForUntiedGame(string $score): string
    {
        $stringifiedScores = [self::LOVE, self::FIFTEEN, self::THIRTY, self::FORTY,];
        $player1StringifiedScore = $stringifiedScores[$this->player1NumericalScore];
        $player2StringifiedScore = $stringifiedScores[$this->player2NumericalScore];
        return $score.$player1StringifiedScore.'-'.$player2StringifiedScore;
    }

    public function stringifyScoreForTiedGame(): string
    {
        switch ($this->player1NumericalScore) {
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

    public function isAdvantagePlayer(int $score)
    {
        return ($this->player1NumericalScore - $this->player2NumericalScore) == $score;
    }

    public function isWinPlayer1(): bool
    {
        return ($this->player1NumericalScore - $this->player2NumericalScore) >= 2;
    }

    public function isAtLeastOnePlayerAboveTheMaxScore(): bool
    {
        return $this->player1NumericalScore >= self::MAX_TOTAL || $this->player2NumericalScore >= self::MAX_TOTAL;
    }
}

