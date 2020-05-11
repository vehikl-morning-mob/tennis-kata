<?php

class TennisGame1 implements TennisGame
{
    private const MAX_TOTAL = 4;
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
    private const WINNING_DIFF = 2;
    private const STRINGIFIED_SCORES = [self::LOVE, self::FIFTEEN, self::THIRTY, self::FORTY];
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
        if ($this->player1NumericalScore == $this->player2NumericalScore) {
            return $this->stringifyScoreForTiedGame();
        }
        if ($this->isAtLeastOnePlayerAboveTheMaxScore()) {
            return abs($this->getDeltaScore()) >= self::WINNING_DIFF ? $this->showWinnerName() : $this->showAdvantageeName();
        }
        return $this->stringifyScoreForUntiedGame();
    }

    public function stringifyScoreForUntiedGame(): string
    {
        $player1StringifiedScore = self::STRINGIFIED_SCORES[$this->player1NumericalScore];
        $player2StringifiedScore = self::STRINGIFIED_SCORES[$this->player2NumericalScore];
        return $player1StringifiedScore . '-' . $player2StringifiedScore;
    }

    public function stringifyScoreForTiedGame(): string
    {
        if ($this->player1NumericalScore > 2) {
            return self::DEUCE;
        }
        return self::STRINGIFIED_SCORES[$this->player1NumericalScore] . "-All";
    }

    public function isWinPlayer1(): bool
    {
        return $this->getDeltaScore() >= self::WINNING_DIFF;
    }

    public function isAtLeastOnePlayerAboveTheMaxScore(): bool
    {
        return $this->player1NumericalScore >= self::MAX_TOTAL || $this->player2NumericalScore >= self::MAX_TOTAL;
    }

    public function getDeltaScore(): int
    {
        return $this->player1NumericalScore - $this->player2NumericalScore;
    }

    public function showWinnerName(): string
    {
        return $this->isWinPlayer1() ? self::WIN_FOR_PLAYER_1 : self::WIN_FOR_PLAYER_2;
    }

    public function showAdvantageeName(): string
    {
        if ($this->getDeltaScore() == 1) {
            return self::ADVANTAGE_PLAYER_1;
        }
        if ($this->getDeltaScore() == -1) {
            return self::ADVANTAGE_PLAYER_2;
        }
        return '';
    }
}

