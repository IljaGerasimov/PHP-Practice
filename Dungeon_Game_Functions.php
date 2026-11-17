<?php

require_once __DIR__ . '/Dungeon_Game_Const.php';

// $traps = [['x' => 4, 'y' => 5],['x' => 4, 'y' => 5]];
function generateTraps(): array
{
  $result = [];
  for ($y = 0; $y < HEIGHT - 1; $y++) {
    //
  }
  return $result;
}



function gameOver(int $roomNumber): int
{
  echo "\e[2J";
  $cursorReset = "\e[H";
  $cursorReset .= "    ===== PHPrison =====\n\n";
  $cursorReset .= "GAME OVER ON ROOM $roomNumber\n\nDo you wish to start again?\n[n] New Game [q] Quit\n";
  while (true) {
    $input = fread(STDIN, 1);
    switch ($input) {
      case 'n':
        return (1);
      case 'q':
        return (2);
    }
    echo $cursorReset;
  }
}

function drawDungeon(array $player, array $rock, array $target, bool $doorOpen): void
{
  $width = WIDTH;
  $height = HEIGHT;
  $cursorReset = "\e[H";
  $cursorReset .= "    ===== PHPrison =====\n\n";

  for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
      if ($x === $player['x'] && $y === $player['y']) {
        $cursorReset .= PLAYER_SYMBOL;
      } elseif ($x === $target['x'] && $y === $target['y']) {
        $cursorReset .= ($target['x'] === $rock['x'] && $target['y'] === $rock['y']) ? HOLESYMBOL_FULL : HOLESYMBOL_EMPTY;
      } elseif ($x === $rock['x'] && $y === $rock['y']) {
        $cursorReset .= ROCK_SYMBOL;
      } elseif ($x === $width - 1 && $y === intdiv($height, 2) && $doorOpen === true) {
        $cursorReset .= " ";
      } elseif ($x === 0 || $x === $width - 1 || $y === 0 || $y === $height - 1) {
        $cursorReset .= "#";
      } else {
        $cursorReset .= ".";
      }
    }
    $cursorReset .= "\n";
  }
  echo $cursorReset;
}
