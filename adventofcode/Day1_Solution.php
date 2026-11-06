<?php

$text = file("elves.txt", FILE_IGNORE_NEW_LINES);
// print_r($text);

$groups = []; 
// $gIndex = 0;

$sum = 0;
foreach ($text as $key => $line) {
  if (is_numeric($line)) {
    $sum += $line;
    if (count($text) !== $key + 1) {
      continue;
    }
  }
  $groups[] = $sum;
  $sum = 0;

  // if (empty($line) || count($text) === $key + 1) {
  //   $groups[] = $sum;
  //   $sum = 0;
  // } else {
  //   $sum += $line;
  // }
}

echo 'The biggest number is: ' . max($groups) . PHP_EOL;

rsort($groups);

echo 'The total of top three: ' . $groups[0] + $groups[1] + $groups[2] . PHP_EOL;
