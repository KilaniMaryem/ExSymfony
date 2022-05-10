<?php

class MyCustomTwigExtensions extends \Twig\Extension\AbstractExtension
{
 public function getFilters()
 {
     return [
         new \Twig\TwigFilter('default',[$this,'defaultImage'])
     ];
 }
 public function defaultImage(string $path ) : string
 {
   if (strlen(trim($path))==0)  {
       return 'téléchargement.png';
   }
   return $path;
 }
}