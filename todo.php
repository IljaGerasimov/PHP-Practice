<?php 

$file = 'todos.json';

if (file_exists($file)) {
$todos = json_decode(file_get_contents($file), true);
} else {
  $todos = [];
}

$today = date('Y-m-d');
$soon = date('Y-m-d', strtotime('+2 days'));

// Infinite loop for terminal menu 
while (true) {
  echo "\033[H\033[J";
  echo "\n=== My To-Do List (Today: $today ===\n";

  if (empty($todos)) {
    echo "(Task list empty)\n";
  }
  // 1. go through entries with foreach
  foreach ($todos as $nr => $todo) {
    $hook = $todo['finished'] ? '[X]' : '[ ]';
    $info = '';

    // Check expiration date (only if task not finished and a Date is given)
    if (!$todo['finished'] && $todo['date'] !== '') {
      if ($todo['date'] < $today) {
        $info = ' -> EXPIRED (' . $todo['date'] . ')';
      } elseif ($todo['date'] <= $soon) {
        $info = ' -> EXPIRES SOON (' . $todo['date'] . ')';
      } else {
        $info = ' (Until: '. $todo['date'] . ')';
      }
    }
    echo "$nr: $hook " . $todo['text'] . "$info\n";
  }
  // 2. show Menu and read userinput
  echo "\nWhat to do? [1] New [2] Mark finished [3] Delete [4] End\n";
  $choice = readline("Choice: ");

  if ($choice === '1') {
    $text = readline("Task: ");
    $date = readline("Expiry-Date (YYYY-MM-DD or Enter for None): ");
    $todos[] = ['text' => $text, 'date' => $date, 'finished' => false];
  } elseif ($choice === '2') {
    $nr = (int)readline("Which Number is finished? ");
    if (isset($todos[$nr])) {
      $todos[$nr]['finished'] = true;
    }
  } elseif ($choice === '3') {
    $nr = (int)readline("Which Number to delet? ");
    if (isset($todos[$nr])) {
      unset($todos[$nr]);
      $todos = array_values($todos);
    }
  } elseif ($choice === '4') {
      break; // Ends the while loop and the program
  }
  // after every action save array as text in todos.json
  file_put_contents($file, json_encode($todos, JSON_PRETTY_PRINT));
}
