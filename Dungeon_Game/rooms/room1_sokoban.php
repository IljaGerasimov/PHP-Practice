<?php

// $traps = [['x' => 4, 'y' => 5],['x' => 4, 'y' => 5]];
function generateTraps(): array
{
  $result = [];
  for ($y = 0; $y <  $width - 1; $y++) {
    //
  }
  return $result;
}

function initRoom1(): array
{
  // $traps = generateTraps();
  return [
    'width' => 29,
    'height' => 9,
    'player' => ['x' => 3, 'y' => 4],
    'doorOpen' => false,
    'target_filled' => false,
    'renderList' => [
      'rock' => ['x' => 5, 'y' => 3, 'symbol' => '@'],
      'target' => ['x' => 27, 'y' => 4, 'symbol' => 'E'],
      //     'traps' => [$traps, 'SYMBOL' => 'E']
    ]
  ];
}

function updateRoom1(array $next, array &$player, array &$roomData, bool &$doorOpen, int &$room, bool &$running): void
{
  $nextX = $next['x'];
  $nextY = $next['y'];
  $dx = $next['dx'];
  $dy = $next['dy'];
  $width = $roomData['width'];
  $height = $roomData['height'];
  $rock = &$roomData['rock'];
  $target = $roomData['target'];

  if ($nextX + 1) {
    // Fall A: Player kommt ans Ziel
    if ($doorOpen === true && $nextX  === $width - 1 && $nextY === intdiv($height, 2)) {
      $room++;
      $player;
      $doorOpen = false;
      // Fall B: Spieler Bewegt sich herum
    } elseif (
      $nextX > 0 && $nextX < $width - 1
      && $nextY > 0 && $nextY < $height - 1
    ) {
      if (
        $nextX === $rock['x'] && $nextX + $dx > 0 && $nextX + $dx < $width - 1
        && $nextY === $rock['y']  && $nextY + $dy > 0 && $nextY + $dy < $height - 1
        && ($rock['x'] !== $target['x'] || $rock['y'] !== $target['y'])
      ) {
        $rock['x'] += $dx;
        $rock['y'] += $dy;
      }
      if ($rock['x'] === $target['x'] && $rock['y'] === $target['y']) {
        $roomData['target_filled'] = true;
        $roomData['renderList']['target']['SYMBOL'] = 'F';



        $doorOpen = true;
      }

      if ($targetFilled === false && $nextX === $target['x'] && $nextY === $target['y']) {
        $newOrQuit = gameOver($room);
        if ($newOrQuit === 1) {
          echo "\e[2J";
          $room = 1;
          $player = ['x' => 2, 'y' => 4];
          $roomData = initRoom1();
          $doorOpen = false;
        } elseif ($newOrQuit === 2) {
          $running = false;
        }
      } else {
        $player['x'] += $dx;
        $player['y'] += $dy;
      }
    }
  }
}
