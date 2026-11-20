<?php

function initRoom2(): array
{
  $width = 19;
  return [
    'width' => $width,
    'height' => 25,
    'doorOpen' => false,
    'poem' => "I spoon-feed death my passing days,\nWith games that keep my mind at bay, \nFrom the sluggish boring haze, \nOf a well-spent fruitful day.",
    'poemSettings' => ['pos' => 0, 'len' => $width],
    'renderList' => [
      'door' => ['x' => 18, 'y' => 12, 'symbol' => '🚪'],
      'plate' => ['x' => 3, 'y' => 9, 'symbol' => '▣'],
      'player' => ['x' => 3, 'y' => 23, 'symbol' => PLAYER_SYMBOL],
    ]
  ];
}

function updateRoom2(array $next, array &$roomData, int &$room, bool &$running): void
{
  $nextX = $next['x'];
  $nextY = $next['y'];
  $dx = $next['dx'];
  $dy = $next['dy'];
  $width = $roomData['width'];
  $height = $roomData['height'];
  $doorOpen = &$roomData['doorOpen'];

  if ($nextX + 1) {
    // Fall A: Player kommt ans Ziel
    if ($doorOpen === true && $nextX  === $width - 1 && $nextY === intdiv($height, 2)) {
      $room++;
      $doorOpen = false;
      // Fall B: Spieler Bewegt sich herum
    } elseif (
      $nextX > 0 && $nextX < $width - 1
      && $nextY > 0 && $nextY < $height - 1
    ) {
      $roomData['renderList']['player']['x'] += $dx;
      $roomData['renderList']['player']['y'] += $dy;
    }
  }
}
