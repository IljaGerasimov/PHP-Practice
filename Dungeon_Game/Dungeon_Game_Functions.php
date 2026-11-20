<?php

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

function drawDungeon(array $roomData): int
{
  $width = $roomData['width'];
  $height = $roomData['height'];


  $cursorReset = "\e[2J" . "\e[H";
  $title = "    ===== PHPrison =====\n\n";

  $map = array_fill(0, $height, array_fill(0, $width, '.'));
  $map[0] = array_fill(0, $width, '#');
  $map[$height - 1] = array_fill(0, $width, '#');
  for ($y = 1; $y < ($height - 1); $y++) {
    $map[$y][0] = "#";
    $map[$y][$width - 1] = "#";
  }

  foreach ($roomData['renderList'] as $entities) {
    $map[$entities['y']][$entities['x']] = $entities['symbol'];
  }

  //
  $mapString = "";
  for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
      $mapString .= $map[$y][$x];
    }
    $mapString .= "\n";
  }

    $poemRotating = substr($roomData['poem'], $roomData['poemSettings']['pos']) . substr($roomData['poem'], 0, $roomData['poemSettings']['pos']);         // \r jumps back to line start and overwrites
    $poemLine1 = substr($poemRotating, 0 ,$roomData['poemSettings']['len']);
    $poemLine2 = substr($poemRotating, $roomData['poemSettings']['len'] ,$roomData['poemSettings']['len']);
    $poemLine3 = substr($poemRotating, $roomData['poemSettings']['len'] * 2 ,$roomData['poemSettings']['len']);

    echo $cursorReset . $title . $mapString;
    echo "\n" . $poemLine1 . PHP_EOL . $poemLine2 . PHP_EOL . $poemLine3;

    $newPoemPosition = ($roomData['poemSettings']['pos'] + 1) % $roomData['poemSettings']['len'];
    return $newPoemPosition;
}
