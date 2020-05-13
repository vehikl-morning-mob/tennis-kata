<?php

class TennisGame3 implements TennisGame
{
    private const MAX_SCORE = 4;
    private const SUM_OF_SCORES = 6;
    private const STRINGIFIED_SCORES = ["Love", "Fifteen", "Thirty", "Forty"];
    private $p2 = 0;
    private $p1 = 0;
    private $p1N = '';
    private $p2N = '';

    public function __construct($p1N, $p2N)
    {
        $this->p1N = $p1N;
        $this->p2N = $p2N;
    }

    public function getScore()
    {
        if ($this->p1 < self::MAX_SCORE && $this->p2 < self::MAX_SCORE && !($this->p1 + $this->p2 == self::SUM_OF_SCORES)) {
            $s = self::STRINGIFIED_SCORES[$this->p1];
            return ($this->p1 == $this->p2) ? "{$s}-All" : $s."-".self::STRINGIFIED_SCORES[$this->p2];
        } else {
            if ($this->p1 == $this->p2) {
                return "Deuce";
            }
            $s = $this->p1 > $this->p2 ? $this->p1N : $this->p2N;
            return (($this->p1 - $this->p2) * ($this->p1 - $this->p2) == 1) ? "Advantage {$s}" : "Win for {$s}";
        }
    }

    public function wonPoint($playerName)
    {
        if ($playerName == "player1") {
            $this->p1++;
        } else {
            $this->p2++;
        }
    }
}

