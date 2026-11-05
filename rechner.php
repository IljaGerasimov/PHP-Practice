<?php

echo "=== PHP Terminal Rechner ===\n";

$zahl1 = (float) readline("Erste Zahl:");
$operator = trim(readline("Operator (+, -, *, /): "));
$zahl2 = (float) readline("Zweite Zahl:");


$ergebnis = match ($operator) {
    '+' => $zahl1 + $zahl2,
    '-' => $zahl1 - $zahl2,
    '*' => $zahl1 * $zahl2,
    '/' => $zahl2 != 0 ? $zahl1 / $zahl2 : "Fehler: Division durch 0!",
    default => "Ungültiger Operator!"
};

echo "Ergebnis: " . $ergebnis . "\n";
?>
