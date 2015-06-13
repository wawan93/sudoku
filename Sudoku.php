<?php

class Sudoku {
    private $_initial_board = [];
    private $_working_board = [];

    public function Sudoku($input_file)
    {
        $file = file_get_contents($input_file);
        $lines = explode("\n", $file);

        $i=0;
        foreach($lines as $line) {
            $this->_initial_board[$i++] = array_map('intval', explode(',',$line));
        }

        $this->_working_board = $this->_initial_board;

    }

    public function print_result()
    {
        for($i=0;$i<9;$i++) {
            for($j=0;$j<9;$j++) {
                echo $this->_working_board[$i][$j]." ";
            }
            echo "\n";
        }
    }

    public function validate_result()
    {
        return $this->_validate($this->_working_board);
    }

    public function solve()
    {
        $empty_cell = $this->_get_empty();
        if($empty_cell !== null) {
            list($x, $y) = $empty_cell;
            $this->_try($x, $y);
        }
        $this->print_result();
    }

    private function _validate_line(array $line)
    {
        $unique = array_unique($line);
        if(array_sum($unique) == array_sum($line)) {
            return true;
        } else {
            return false;
        }
    }

    private function _validate(array $array)
    {
        for($i=0;$i<9;$i++) {
            $validate_row = $this->_validate_line($array[$i]);
            $validate_column = $this->_validate_line(array_column($array,$i));
            if(!$validate_column || !$validate_row) {
                return false;
            }
        }

        for($i=0;$i<3;$i++) {
            for($j=0;$j<3;$j++) {
                $square = [
                    $array[3*$i][3*$j],   $array[3*$i][3*$j+1],   $array[3*$i][3*$j+2],
                    $array[3*$i+1][3*$j], $array[3*$i+1][3*$j+1], $array[3*$i+1][3*$j+2],
                    $array[3*$i+2][3*$j], $array[3*$i+2][3*$j+1], $array[3*$i+2][3*$j+2],
                ];

                if(!$this->_validate_line($square)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function _get_empty()
    {
        for($i=0;$i<9;$i++) {
            for($j=0;$j<9;$j++) {
                if($this->_working_board[$i][$j]===0) {
                    return [$i, $j];
                }
            }
        }

        return null;
    }

    private function _try($x, $y)
    {
        for($i=1; $i<=9; $i++) {
            $this->_working_board[$x][$y] = $i;
            if(!$this->_validate($this->_working_board)) {
                continue;
            }

            $empty_cell = $this->_get_empty();
            if($empty_cell !== null) {
                list($m, $n) = $empty_cell;
                if($this->_try($m, $n)) {
                    return true;
                }
            } else {
                return true;
            }
        }


        if($i==9 or $this->_get_empty()) {
            $this->_working_board[$x][$y] = 0;
            return false;
        } else {
            return true;
        }

    }

}