<?php

class TennisGame3 implements TennisGame
{
    private const MAX_SCORE = 4;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private const DEUCE = "Deuce";
    private const FORTY_POINTS = 3;
    private $player2NumericalScore = 0;
    private $player1NumericalScore = 0;
    private $player1Name = '';
    private $player2Name = '';

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function getScore()
    {
        if ($this->isTied()) {
            return $this->player1NumericalScore >= self::FORTY_POINTS
                ? self::DEUCE
                : self::STRINGIFIED_SCORES[$this->player1NumericalScore] . "-All";
        }
        if ($this->isLateGame()) {
            $prefix = abs($this->player1NumericalScore - $this->player2NumericalScore) == 1
                ? "Advantage"
                : "Win for";
            return "{$prefix} {$this->getLeadingPlayerName()}";
        }

        return $this->getRegularScore();
    }

    public function wonPoint($playerName)
    {
        if ($playerName == "player1") {
            $this->player1NumericalScore++;
        } else {
            $this->player2NumericalScore++;
        }
    }

    public function isLateGame(): bool
    {
        return $this->player1NumericalScore >= self::MAX_SCORE || $this->player2NumericalScore >= self::MAX_SCORE;
    }

    public function isTied(): bool
    {
        return $this->player1NumericalScore == $this->player2NumericalScore;
    }

    public function getLeadingPlayerName(): string
    {
        return $this->player1NumericalScore > $this->player2NumericalScore ? $this->player1Name : $this->player2Name;
    }

    public function getRegularScore(): string
    {
        return self::STRINGIFIED_SCORES[$this->player1NumericalScore] . "-" . self::STRINGIFIED_SCORES[$this->player2NumericalScore];
    }
}

