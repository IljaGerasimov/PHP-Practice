<?php 

// function fak(int $n): int|float {
function fak(int $n): string {
  if ($n <= 1) {
    echo "1 => 1\n";
    return 1;
  }
  // bis 170
  // $sum1 = $n * fak($n - 1);
  // bis 99999
  $sum1 = bcmul((string)$n, fak($n - 1));
  echo "$n => $sum1\n";
  return $sum1;
}

$number = (int)readline("Enter a number to factorialize...");

if ($number < 0) {
  echo "Factorial for negative numbers is not defined, try again...";
  exit(1);
}

$sum = fak($number);
echo "The factorial of $number ($number!) is: $sum\n";

?>
