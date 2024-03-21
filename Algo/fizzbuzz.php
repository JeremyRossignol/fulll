<?php

require_once("FizzBuzz.class.php");

/**
 * Classical FizzBuzz
 * Display numbers between **1** and **N** by following the rules:
 * - if number can be divided by 3: display **Fizz** ;
 * - if number can be divided by 5: display **Buzz** ;
 * - if number can be divided by 3 **AND** 5 : display **FizzBuzz** ;
 * - else: display the number.
 *
 * @param  [int] $number the number of loops
 * @return void
 */
function classicalFizzBuzz($number)
{
   $params = [
      new FizzBuzzParams(3, "Fizz"),
      new FizzBuzzParams(5, "Buzz")
   ];
   $fizzBuzz = new FizzBuzz($params, $number);
   if ($fizzBuzz !== false) {
      echo $fizzBuzz;
   }
}
