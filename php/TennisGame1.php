<?php

class Player
{
    public $name;
    public $score = 0;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getScoreAsString(): string
    {
        return self::STRINGIFIED_SCORES[$this->score];
    }

    public function hasReachedFortyPoints(): bool
    {
        return $this->score >= count(self::STRINGIFIED_SCORES);
    }
}

class TennisGame1 implements TennisGame
{
    private const PLAYER_1_NAME = 'player1';
    private const WINNING_DIFF = 2;
    private const DEUCE = "Deuce";
    private const TIED_SCORE_SUFFIX = "-All";

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
            $this->player1->score++;
        } else {
            $this->player2->score++;
        }
    }

    public function getScore()
    {
        if ($this->player1->score == $this->player2->score) {
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
        return $this->player1->getScoreAsString() . '-' . $this->player2->getScoreAsString();
    }

    public function stringifyScoreForTiedGame(): string
    {
        if ($this->player1->score > 2) {
            return self::DEUCE;
        }
        return $this->player1->getScoreAsString() . self::TIED_SCORE_SUFFIX;
    }

    public function hasSomeoneReachedFortyPoints(): bool
    {
        return $this->player1->hasReachedFortyPoints() || $this->player2->hasReachedFortyPoints();
    }

    public function getDeltaScore(): int
    {
        return abs($this->player1->score - $this->player2->score);
    }

    public function getLeadingPlayerName()
    {
        return $this->player1->score > $this->player2->score ? $this->player1->name : $this->player2->name;
    }
}