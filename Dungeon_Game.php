<?php

require_once __DIR__ . '/Dungeon_Game_Functions.php';
require_once __DIR__ . '/Dungeon_Game_Const.php';

// Tastendrücke sofort lesen, nicht ausgeben
system('stty -icanon -echo');
stream_set_blocking(STDIN, false); // Spiel-loop läuft weiter, selbst bei inaktivität
echo "\e[?1049h"; // Alt Screen
echo "\e[?25l"; // Cursor invis

pcntl_async_signals(true);                       // handle signals immediately, not only at checkpoints
pcntl_signal(SIGINT, fn() => exit(130));         // Ctrl+C while PHP code runs: clean exit, shutdown still runs

// Fallback zum Standard bei Ctrl + C
register_shutdown_function(function () {
  pcntl_signal(SIGINT, fn() => null);          // handles ctrl+c correctly
  echo "\e[?25h"; // Zeigt den Cursor wieder
  system('stty sane'); // Normales Tipp-verhalten
  echo "\e[?1049l"; // Zurück zum normalen Terminal
});




// Die Playermovement Logik
$running = true;
while ($running) {
  $input = fread(STDIN, 1);

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
    case 'q':
      $running = false;
      break 2;
  }

  if ($dx !== 0 || $dy !== 0) {
    $nextX = $player['x'] + $dx;
    $nextY = $player['y'] + $dy;

    if ($nextX + 1) {
      // Fall A: Player kommt ans Ziel
      if ($doorOpen === true && $nextX  === $width - 1 && $nextY === intdiv($height, 2)) {
        $room++;
        $player = $defaultPlayer;
        $doorOpen = false;
        // Fall B: Spieler Bewegt sich herum
      } elseif (
        $nextX > 0 && $nextX < $width - 1
        && $nextY > 0 && $nextY < $height - 1
      ) {
        if (
          $nextX === $rock['x'] && $nextX + $dx > 0 && $nextX + $dx < WIDTH - 1
          && $nextY === $rock['y']  && $nextY + $dy > 0 && $nextY + $dy < HEIGHT - 1
          && ($rock['x'] !== $target['x'] || $rock['y'] !== $target['y'])
        ) {
          $rock['x'] += $dx;
          $rock['y'] += $dy;
        }
        if ($rock['x'] === $target['x'] && $rock['y'] === $target['y']) {
          $targetFilled = true;
          $doorOpen = true;
        }

        if ($targetFilled === false && $nextX === $target['x'] && $nextY === $target['y']) {
          $newOrQuit = gameOver($room);
          if ($newOrQuit === 1) {
            echo "\e[2J";
            $room = 1;
            $player = $defaultPlayer;
            $doorOpen = false;
            $rock = $defaultRock;
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
  drawDungeon($player, $rock, $target, $doorOpen);
}
