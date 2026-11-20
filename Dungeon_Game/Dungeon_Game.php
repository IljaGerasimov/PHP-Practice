<?php

require_once __DIR__ . '/Dungeon_Game_Functions.php';
require_once __DIR__ . '/rooms/room1_sokoban.php';
require_once __DIR__ . '/rooms/room2_simonsays.php';
require_once __DIR__ . '/rooms/room3_maze.php';

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
  echo "\n\nGoodbye cruel world";
  sleep(3);
  echo "\e[?25h"; // Zeigt den Cursor wieder
  system('stty sane'); // Normales Tipp-verhalten
  echo "\e[?1049l"; // Zurück zum normalen Terminal
});

const PLAYER_SYMBOL = 'ඞ';

$lastRoom = 1;
$room = 1;
$roomData = initRoom1();

// Die Playermovement Logik
$running = true;
while ($running) {
  $input = fread(STDIN, 1);
  if ($input === 'q') break;

  $next = calcNextPosition($roomData['renderList']['player'], $input);

  if ($next['dx'] !== 0 || $next['dy'] !== 0) {
    ('updateRoom' . $room)($next, $roomData, $room, $running);
  }
  if ($lastRoom != $room) {
    $roomData = ('initRoom' . $room)();
    $lastRoom++;
  }

  drawDungeon($roomData);
  //echo "$input";

  usleep(33000);
}
