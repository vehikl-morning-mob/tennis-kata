<?php

class TennisGame3 implements TennisGame
{
    private const MAX_SCORE = 4;
    private const SUM_OF_SCORES = 6;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private const DEUCE = "Deuce";
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
        if ($this->isEarlyGame() && !($this->player1NumericalScore + $this->player2NumericalScore == self::SUM_OF_SCORES)) {
            return ($this->player1NumericalScore == $this->player2NumericalScore)
                ? self::STRINGIFIED_SCORES[$this->player1NumericalScore]."-All"
                : self::STRINGIFIED_SCORES[$this->player1NumericalScore]."-".self::STRINGIFIED_SCORES[$this->player2NumericalScore];
        } else {
            if ($this->player1NumericalScore == $this->player2NumericalScore) {
                return self::DEUCE;
            }
            $leadingPlayerName = $this->player1NumericalScore > $this->player2NumericalScore ? $this->player1Name : $this->player2Name;
            return (abs($this->player1NumericalScore - $this->player2NumericalScore) == 1)
                ? "Advantage {$leadingPlayerName}"
                : "Win for {$leadingPlayerName}";
        }
    }

    public function wonPoint($playerName)
    {
        if ($playerName == "player1") {
            $this->player1NumericalScore++;
        } else {
            $this->player2NumericalScore++;
        }
    }

    public function isEarlyGame(): bool
    {
        return $this->player1NumericalScore < self::MAX_SCORE && $this->player2NumericalScore < self::MAX_SCORE;
    }
}

