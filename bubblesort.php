<?php

$arr = [18, 5, 24, 11, 2, 15, 29, 8, 21, 13];

function drawVisualizer(array $arr, int $active1 = -1, int $active2 = -1): void {
    echo "\033[H";
    echo "=== PHP BUBBLE SORT PRÄSENTATION ===\n\n";
    $maxVal = max($arr);
    for ($row = $maxVal; $row >= 1; $row--) {
        echo " ";
        foreach ($arr as $idx => $val) {
            if ($val >= $row) {
                if ($idx === $active1 || $idx === $active2) {
                    echo "\033[36m ██ \033[0m"; 
                } else {
                    echo "\033[95m ██ \033[0m";
                }
            } else {
                echo "    ";
            }
        }
        echo "\n";
    }
    echo " " . str_repeat("----", count($arr)) . "\n";
    echo " ";
    foreach ($arr as $val) {
        printf(" %2d ", $val);
    }
    echo "\n\n";
    usleep(500000);
}
echo "\033[2J\033[H";
echo "\033[?25l";

$n = count($arr);

for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
        
        drawVisualizer($arr, $j, $j + 1);

        if ($arr[$j] > $arr[$j + 1]) {
            $temp = $arr[$j];
            $arr[$j] = $arr[$j + 1];
            $arr[$j + 1] = $temp;
        }
    }
}

drawVisualizer($arr);
echo "\033[32m[+] Erfolgreich sortiert!\033[0m\n";
echo "\033[?25h";
