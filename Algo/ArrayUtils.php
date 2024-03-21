<?php

/**
 * Array utils functions
 *
 * @author Jérémy Rossignol [2024-03-21 13:46]
 */
class ArrayUtils
{

   /**
    * Check if an array is an array of objects $className
    *
    * @param  array  $array
    * @param  string  $className
    * @return boolean
    */
   public static function isArrayOf($array, $className)
   {
      if (is_array($array)) {
         foreach ($array as $item) {
            if (!is_a($item, $className)) {
               return false;
            }
         }
         return true;
      }
      return false;
   }

   /**
    * Check if an array is an array of objects $className and if it's not empty
    *
    * @param  array $array
    * @param  string $className
    * @return boolean
    */
   public static function isNotEmptyArrayOf($array, $className)
   {
      return self::isArrayOf($array, $className) && !empty($array);
   }
}
