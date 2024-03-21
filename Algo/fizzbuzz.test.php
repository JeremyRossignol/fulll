<?php
require_once("fizzbuzz.php");

function testClassicalFizzBuzz($number)
{
   echo "======== " . __FUNCTION__ . " [" . $number . "] ========" . PHP_EOL;
   classicalFizzBuzz($number);
}

testClassicalFizzBuzz(null);
testClassicalFizzBuzz(0);
testClassicalFizzBuzz(1);
testClassicalFizzBuzz(3);
testClassicalFizzBuzz(5);
testClassicalFizzBuzz(100);
testClassicalFizzBuzz(300);
