<?php

class TennisGame1 implements TennisGame
{
    private const MAX_TOTAL = 4;
    private const DEUCE = "Deuce";
    private const PLAYER_1_NAME = 'player1';
    private const WINNING_DIFF = 2;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private const TIED_SCORE_SUFFIX = "-All";
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
        return self::STRINGIFIED_SCORES[$this->player1NumericalScore] . self::TIED_SCORE_SUFFIX;
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
        return 'Win for '.($this->isWinPlayer1() ? $this->player1Name : $this->player2Name);
    }

    public function showAdvantageeName(): string
    {
        $advantageeName = 'no one';
        if ($this->getDeltaScore() == 1) {
            $advantageeName = $this->player1Name;
        }
        if ($this->getDeltaScore() == -1) {
            $advantageeName = $this->player2Name;
        }
        return 'Advantage '.$advantageeName;
    }
}

