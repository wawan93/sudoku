<?php

require_once 'Sudoku.php';

$sudoku = new Sudoku('in.txt');

$s = microtime(true);
$sudoku->solve();
$e = microtime(true);

$time = ($e-$s)*1000;
echo "\n{$time}\n";