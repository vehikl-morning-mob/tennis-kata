<?php

class TennisGame2 implements TennisGame
{
    private const MAX_SCORE = 4;
    private const LOVE_SCORE = 0;
    private const THIRTY_SCORE = 2;
    private const FORTY_SCORE = 3;
    private const FIFTEEN_SCORE = 1;
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
        if ($this->player1NumericalScore == $this->player2NumericalScore && $this->player1NumericalScore >= self::FORTY_SCORE) {
            return "Deuce";
        }

        if ($this->player1NumericalScore == $this->player2NumericalScore && $this->player1NumericalScore < self::MAX_SCORE) {
            return $this->getStringifiedScore($this->player1NumericalScore) . "-All";
        }

        if ($this->isWinningPlayer1()) {
            return "Win for player1";
        }

        if ($this->isWinningPlayer2()) {
            return "Win for player2";
        }

        if ($this->player1NumericalScore > $this->player2NumericalScore && $this->player2NumericalScore >= self::FORTY_SCORE) {
            return "Advantage player1";
        }

        if ($this->player2NumericalScore > $this->player1NumericalScore && $this->player1NumericalScore >= self::FORTY_SCORE) {
            return "Advantage player2";
        }

        $this->player1StringifiedScore = $this->getStringifiedScore($this->player1NumericalScore);
        $this->player2StringifiedScore = $this->getStringifiedScore($this->player2NumericalScore);
        return "{$this->player1StringifiedScore}-{$this->player2StringifiedScore}";
    }

    private function P1Score()
    {
        $this->player1NumericalScore++;
    }

    private function P2Score()
    {
        $this->player2NumericalScore++;
    }

    public function wonPoint($player)
    {
        if ($player == "player1") {
            $this->P1Score();
        } else {
            $this->P2Score();
        }
    }

    public function getStringifiedScore(int $numericalScore): string
    {
        $score = "";
        if ($numericalScore == self::LOVE_SCORE) {
            $score = "Love";
        }
        if ($numericalScore == self::FIFTEEN_SCORE) {
            $score = "Fifteen";
        }
        if ($numericalScore == self::THIRTY_SCORE) {
            $score = "Thirty";
        }

        if ($numericalScore == self::FORTY_SCORE) {
            $score = "Forty";
        }
        return $score;
    }

    public function isWinningPlayer1(): bool
    {
        return $this->player1NumericalScore >= self::MAX_SCORE && $this->player2NumericalScore >= self::LOVE_SCORE && ($this->player1NumericalScore - $this->player2NumericalScore) >= self::THIRTY_SCORE;
    }

    public function isWinningPlayer2(): bool
    {
        return $this->player2NumericalScore >= self::MAX_SCORE && $this->player1NumericalScore >= self::LOVE_SCORE && ($this->player2NumericalScore - $this->player1NumericalScore) >= self::THIRTY_SCORE;
    }
}
