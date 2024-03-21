<?php
require_once('FizzBuzzParams.class.php');
require_once('ArrayUtils.php');

/**
 * Class FizzBuzz used to calculate the string to display using FizzBuzzParams to declare the couples text/divider
 *
 * @author Jérémy Rossignol [2024-03-11 19:42]
 */
class FizzBuzz
{
   private $arrayFizzBuzzParams;
   private $loopNumber;

   private $text = "";

   /**
    * Constructor of FizzBuzz, construct also the string to display
    *
    * @param  [FizzBuzzParams[]] $fizzBuzzParams array of FizzBuzzParams to declare the couples text/divider
    * @param  [int] $loopNumber number of loops
    * @return [FizzBuzz|false] Returns the object, or false if the parameters are bad
    */
   public function __construct($arrayFizzBuzzParams, $loopNumber)
   {
      if (ArrayUtils::isNotEmptyArrayOf($arrayFizzBuzzParams, "FizzBuzzParams") && is_int($loopNumber)) {
         $this->arrayFizzBuzzParams = $arrayFizzBuzzParams;
         $this->loopNumber = $loopNumber;
         $this->genText();
      } else {
         return false;
      }
   }

   /**
    * Constructs the string to display
    *
    * @return void
    */
   private function genText()
   {
      for ($i = 1; $i <= $this->loopNumber; $i++) {
         $textIncremented = false;
         foreach ($this->arrayFizzBuzzParams as $fizzBuzzParams) {
            if ($i % $fizzBuzzParams->getDivider() === 0) {
               $this->text .= $fizzBuzzParams;
               $textIncremented = true;
            }
         }
         if (!$textIncremented) {
            $this->text .= $i;
         }
         $this->text .= PHP_EOL;
      }
   }

   public function __toString()
   {
      return $this->text;
   }
}
