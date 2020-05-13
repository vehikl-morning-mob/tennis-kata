<?php

class TennisGame2 implements TennisGame
{
    private const MAX_SCORE = 4;
    private const FORTY_SCORE = 3;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private const DEUCE = "Deuce";
    private const DELTA_SCORE_TO_WIN = 2;
    private $player1NumericalScore = 0;
    private $player2NumericalScore = 0;

    private $player1StringifiedScore = "";
    private $player2StringifiedScore = "";
    private $player1Name = "";
    private $player2Name = "";

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function getScore()
    {
        if ($this->isGameTied()) {
            return $this->isLateGame() ? self::DEUCE : self::STRINGIFIED_SCORES[$this->player1NumericalScore] . "-All";
        }

        if ($this->isGameOver()) {
            return "Win for " . $this->getLeadingPlayer();
        }

        if ($this->isLateGame()) {
            return "Advantage " . $this->getLeadingPlayer();
        }

        $this->player1StringifiedScore = self::STRINGIFIED_SCORES[$this->player1NumericalScore];
        $this->player2StringifiedScore = self::STRINGIFIED_SCORES[$this->player2NumericalScore];
        return "{$this->player1StringifiedScore}-{$this->player2StringifiedScore}";
    }

    public function wonPoint($player)
    {
        if ($player == "player1") {
            $this->player1NumericalScore++;
        } else {
            $this->player2NumericalScore++;
        }
    }

    public function isGameOver()
    {
        return ($this->player1NumericalScore >= self::MAX_SCORE || $this->player2NumericalScore >= self::MAX_SCORE)
            && abs($this->player1NumericalScore - $this->player2NumericalScore) >= self::DELTA_SCORE_TO_WIN;
    }

    private function getLeadingPlayer()
    {
        return $this->player1NumericalScore > $this->player2NumericalScore ? "player1" : "player2";
    }

    private function isLateGame()
    {
        return $this->player2NumericalScore >= self::FORTY_SCORE && $this->player1NumericalScore >= self::FORTY_SCORE;
    }

    public function isGameTied(): bool
    {
        return $this->player1NumericalScore == $this->player2NumericalScore;
    }
}
