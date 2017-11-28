<?php
declare(strict_types=1);


namespace AdventOfCode\Bootstrap;


interface Day
{
    public function firstPuzzle(string $input);
    public function secondPuzzle(string $input);
}
