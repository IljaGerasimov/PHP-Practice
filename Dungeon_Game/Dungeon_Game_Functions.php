<?php

require_once __DIR__ . '/Dungeon_Game_Const.php';

function calcNextPosition(array $pos, string $input): array
{
  $dx = 0;
  $dy = 0;

  switch ($input) {
    case 'w':
      $dy = -1;
      break;
    case 's':
      $dy = 1;
      break;
    case 'a':
      $dx = -1;
      break;
    case 'd':
      $dx = 1;
      break;
  };
  return ['x' => $pos['x'] + $dx, 'y' => $pos['y'] + $dy, 'dx' => $dx, 'dy' => $dy];
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

function drawDungeon(array $roomData): void
{
  $width = $roomData['width'];
  $height = $roomData['height'];


  $cursorReset = "\e[H";
  $title = "    ===== PHPrison =====\n\n";

  $map = array_fill(0, $height, array_fill(0, $width, false));;

  print_r($map);
  exit();

  for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
      if ($x === $player['x'] && $y === $player['y']) {
        $cursorReset .= PLAYER_SYMBOL;
      }
      if ($x === $roomData['renderList']['target']['x'] && $y === $roomData['renderList']['target']['y']) {
        $cursorReset .= ($roomData['rock']['x'] === $rock['x'] && $target['y'] === $rock['y']) ? HOLESYMBOL_FULL : HOLESYMBOL_EMPTY;
      }
      if ($x === $roomData['renderList']['rock']['x'] && $y === $roomData['renderList']['rock']['y']) {
        $cursorReset .= ROCK_SYMBOL;
      }
      if ($x === $width - 1 && $y === intdiv($height, 2) && $doorOpen === true) {
        $cursorReset .= " ";
      }
      if ($x === 0 || $x === $width - 1 || $y === 0 || $y === $height - 1) {
        $cursorReset .= "#";
      } else {
        $cursorReset .= ".";
      }
    }
    $cursorReset .= "\n";
  }
  echo $cursorReset;
}
  
//  for ($y = 0; $y < $height; $y++) {
//     for ($x = 0; $x < $width; $x++) {
//       if ($x === $player['x'] && $y === $player['y']) {
//         $cursorReset .= PLAYER_SYMBOL;
//       } 
//       if ($x === $roomData['renderList']['target']['x'] && $y === $roomData['renderList']['target']['y']) {
//         $cursorReset .= ($roomData['rock']['x'] === $rock['x'] && $target['y'] === $rock['y']) ? HOLESYMBOL_FULL : HOLESYMBOL_EMPTY;
//       } 
//       if ($x === $roomData['renderList']['rock']['x'] && $y === $roomData['renderList']['rock']['y']) {
//         $cursorReset .= ROCK_SYMBOL;
//       } 
//       if ($x === $width - 1 && $y === intdiv($height, 2) && $doorOpen === true) {
//         $cursorReset .= " ";
//       } 
//       if ($x === 0 || $x === $width - 1 || $y === 0 || $y === $height - 1) {
//         $cursorReset .= "#";
//       } else {
//         $cursorReset .= ".";
//       }
//     }
//     $cursorReset .= "\n";
//   }
//   echo $cursorReset;
// }
