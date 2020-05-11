<?php

class Player
{
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

class TennisGame1 implements TennisGame
{
    private const PLAYER_1_NAME = 'player1';
    private const WINNING_DIFF = 2;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private const DEUCE = "Deuce";
    private const TIED_SCORE_SUFFIX = "-All";
    private int $player1NumericalScore = 0;
    private int $player2NumericalScore = 0;

    private Player $player1;
    private Player $player2;

    public function __construct(string $player1Name, string $player2Name)
    {
        $this->player1 = new Player($player1Name);
        $this->player2 = new Player($player2Name);
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
        if ($this->hasSomeoneReachedFortyPoints()) {
            $prefix = $this->getDeltaScore() >= self::WINNING_DIFF ? 'Win for' : 'Advantage';
            return "{$prefix} {$this->getLeadingPlayerName()}";
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

    public function hasSomeoneReachedFortyPoints(): bool
    {
        return $this->player1NumericalScore >= count(self::STRINGIFIED_SCORES)
            || $this->player2NumericalScore >= count(self::STRINGIFIED_SCORES);
    }

    public function getDeltaScore(): int
    {
        return abs($this->player1NumericalScore - $this->player2NumericalScore);
    }

    public function getLeadingPlayerName()
    {
        return $this->player1NumericalScore > $this->player2NumericalScore ? $this->player1->name : $this->player2->name;
    }
}