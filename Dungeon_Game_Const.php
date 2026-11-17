<?php

const WIDTH = 29;
const HEIGHT = 9;

$width = WIDTH;
$height = HEIGHT;
$room = 1;

$player = $defaultPlayer = ['x' => 2, 'y' => 4];
$rock = $defaultRock = ['x' => 5, 'y' => 3];

$target = ['x' => ($width - 2), 'y' => 4];
$targetFilled = false;
$doorOpen = false;

const PLAYER_SYMBOL = 'ඞ';
const ROCK_SYMBOL = '@';
const HOLESYMBOL_EMPTY = '▰';
const HOLESYMBOL_FULL = '▱';
