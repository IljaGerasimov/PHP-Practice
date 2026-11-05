<?php 

$board = ['¹', '²', '³', '⁴', '⁵', '⁶', '⁷', '⁸', '⁹'];
$currentPlayer = 'X';
$turns = 0;
$gameOver = false;

function printBoard(array $board): void {
  clearScreen();
  echo "==TikTakToe==\n";
  echo "\n";
  echo " {$board[0]} | {$board[1]} | {$board[2]} \n";
  echo "---+---+---\n";
  echo " {$board[3]} | {$board[4]} | {$board[5]} \n";
  echo "---+---+---\n";
  echo " {$board[6]} | {$board[7]} | {$board[8]} \n";
  echo "\n";
}

function clearScreen(): void {
  echo "\033[H\033[J";
}

function checkWin(array $board, string $player): bool {
  $winningLanes = [
    // horizontal
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    // vertical
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    // diagonal
    [0, 4, 8],
    [2, 4, 6],
  ];

  foreach ($winningLanes as $line) {
    if ($board[$line[0]] === $player &&
      $board[$line[1]] === $player &&
      $board[$line[2]] === $player) {
      return true;
    }
  }

  return false;

}

while (true) {
  printBoard($board);

  echo "\033[?25h";
  $input = readline("Player $currentPlayer, choose field (1-9)... ");
  echo "\033[?25l";
  $index = (int)$input - 1;

  if (!is_numeric($input) || $input < 1 || $input > 9 || $board[$index] === 'X' || $board[$index] === 'O') {
    echo "Invalid Move! Please choose a free Number between 1 and 9...\n";
    sleep(3);
    continue;
  }
  $board[$index] = $currentPlayer;
  $turns++;

  if (checkWin($board, $currentPlayer)) {
    $gameOver = true;
    $winner = $currentPlayer; 
  } elseif ($turns === 9) {
    $gameOver = true;
    $winner = null;
  } else {
    $currentPlayer = ($currentPlayer === 'X') ? 'O' : 'X';
  }

  if ($gameOver) {
    printBoard($board);
    if ($winner !== null) {
      echo "Player $winner wins!\n";
    } else {
      echo "It's a draw!\n";
    }
    echo "\033[?25h";
    readline("Press Enter to Exit");
    break;
  }
}

?>
