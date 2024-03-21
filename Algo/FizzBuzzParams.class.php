<?php

/**
 * Class to declare a couple divider and text for FizzBuzz class
 *
 * @author Jérémy Rossignol [2024-03-21 13:41]
 */
class FizzBuzzParams
{
   private $divider;
   private $text;

   /**
    * Constructor
    *
    * @param  [int] $divider The divider used by FizzBuzz class
    * @param  [string] $text The text to display in FizzBuzz class when the number can be divided by the divider
    * @return [FizzBuzzParams|false] Returns the object, or false if the parameters are bad
    */
   public function __construct($divider, $text)
   {
      if (is_int($divider) && is_string($text) && $divider > 0) {
         $this->divider = $divider;
         $this->text = $text;
      } else {
         return false;
      }
   }

   /**
    * Get the divider used by FizzBuzz class
    *
    * @return int
    */
   public function getDivider()
   {
      return $this->divider;
   }

   /**
    * Get the text to display in FizzBuzz class when the number can be divided by the divider
    *
    * @return string
    */
   public function getText()
   {
      return $this->text;
   }

   public function __toString()
   {
      return $this->text;
   }
}
