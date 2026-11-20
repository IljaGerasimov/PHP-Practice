<?php

// $traps = [['x' => 4, 'y' => 5],['x' => 4, 'y' => 5]];
// function generateTraps(): array
// {
//   $result = [];
//   for ($y = 0; $y <  $width - 1; $y++) {
//     //
//   }
//   return $result;
// }

function initRoom1(): array
{
  $width = 29;
  // $traps = generateTraps();
  return [
    'width' => $width,
    'height' => 9,
    'doorOpen' => false,
    'target_filled' => false,
    'poem' => "𝑊𝑒 𝑏𝑢𝑖𝑙𝑑 𝑢𝑝𝑜𝑛 𝑡ℎ𝑒 𝑠𝑎𝑛𝑑𝑠 𝑜𝑓 𝑏𝑜𝑟𝑟𝑜𝑤𝑒𝑑 𝑡𝑖𝑚𝑒, \n𝑇ℎ𝑒 𝑟𝑎𝑑𝑖𝑎𝑛𝑡 𝑐𝑎𝑠𝑡𝑙𝑒𝑠 𝑜𝑓 𝑜𝑢𝑟 𝑓𝑙𝑒𝑒𝑡𝑖𝑛𝑔 𝑝𝑟𝑖𝑑𝑒. \n𝑇ℎ𝑜𝑢𝑔ℎ 𝑏𝑟𝑖𝑒𝑓 𝑜𝑢𝑟 𝑑𝑎𝑛𝑐𝑒 𝑏𝑒𝑛𝑒𝑎𝑡ℎ 𝑡ℎ𝑒 𝑠𝑡𝑎𝑟𝑟𝑦 𝑛𝑖𝑔ℎ𝑡, \n𝐺𝑟𝑖𝑒𝑣𝑒 𝑛𝑜𝑡 𝑤ℎ𝑎𝑡'𝑠 𝑠𝑤𝑒𝑝𝑡 𝑎𝑤𝑎𝑦 𝑏𝑦 𝑚𝑜𝑜𝑛𝑙𝑖𝑡 𝑡𝑖𝑑𝑒.",
    'poemSettings' => ['pos' => 0, 'len' => $width],
    'renderList' => [
      'rock' => ['x' => 5, 'y' => 4, 'symbol' => '@'],
      'target' => ['x' => 27, 'y' => 4, 'symbol' => '▰'],
      'door' => ['x' => 28, 'y' => 4, 'symbol' => '#'],
      'player' => ['x' => 3, 'y' => 4, 'symbol' => PLAYER_SYMBOL],
      //     'traps' => [$traps, 'SYMBOL' => 'E']
    ]
  ];
}

function updateRoom1(array $next, array &$roomData, int &$room, bool &$running): void
{
  $nextX = $next['x'];
  $nextY = $next['y'];
  $dx = $next['dx'];
  $dy = $next['dy'];
  $width = $roomData['width'];
  $height = $roomData['height'];
  $rock = &$roomData['renderList']['rock'];
  $target = &$roomData['renderList']['target'];
  $doorOpen = &$roomData['doorOpen'];

  // Fall A: Player kommt ans Ziel
  if ($doorOpen === true && $nextX  === $width - 1 && $nextY === intdiv($height, 2)) {
    $room++;
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
      $roomData['renderList']['target']['symbol'] = '▱';
      $doorOpen = true;
      $roomData['renderList']['door']['symbol'] = ' ';
    }

    if ($roomData['target_filled'] === false && $nextX === $target['x'] && $nextY === $target['y']) {
      $newOrQuit = gameOver($room);
      if ($newOrQuit === 1) {
        echo "\e[2J";
        $room = 1;
        $roomData['renderList']['player'] = ['x' => 2, 'y' => 4];
        $roomData = initRoom1();
        $doorOpen = false;
      } elseif ($newOrQuit === 2) {
        $running = false;
      }
    } else {
      $roomData['renderList']['player']['x'] += $dx;
      $roomData['renderList']['player']['y'] += $dy;
    }
  }
}
