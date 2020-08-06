<?php

function NumberToLetterInFrench($x) { 
	$nwords = array( "zéro", "un", "deux", "trois", "quatre", "cinq", "six", "sept",
                   "huit", "neuf", "dix", "onze", "douze", "treize",
                   "quatorze", "quinze", "seize", "dix-sept", "dix-huit",
                   "dix-neuf", "vingt", 30 => "trente", 40 => "quarante",
                   50 => "cinquante", 60 => "soixante", 70 => "soixante-dix", 80 => "quatre-vingt",
                   90 => "quatre-vingt-dix" , 100 => "cent", 1000 => "mille", 1000000=>"million", 1000000000=>"milliard",
                   "separator"=>"", "minus"=>"moins", "and"=>"et");

	   if(!is_numeric($x))
	      $w = '#';
	   else if(fmod($x, 1) != 0)
	      $w = '#';
	   else {
	      if($x < 0) {
	         $w = 'minus ';
	         $x = -$x;
	      } else
	         $w = '';
	      // ... now $x is a non-negative integer.

	      if($x < 21)   // 0 to 20
	         $w .= $nwords[$x];
	      elseif ($x == 30 || $x == 40 || $x == 50 || $x == 60){
	         $w .= $nwords[$x];
	      }
	      else if($x < 100) {   // 21 to 99
	        if(($x > 70 && $x<80) || ($x >= 91)){
	            $w .= $nwords[10 * floor($x/10) - 10];
	            $r = fmod($x, 10 * floor($x/10) - 10);
	            $w .= '-'. $nwords[$r];
	        } else {
	            $w .= $nwords[10 * floor($x/10)];
	             $r = fmod($x, 10);
	             if($r == 1 && $x < 70){
	                 $w .= ' et '. $nwords[$r];
	             } else {
	                $w .= '-'. $nwords[$r];
	             }
	        }
	         
	            
	      } else if($x < 1000) {   // 100 to 999
	        if($x < 200){
	            $w .= $nwords[100]; 
	        } else {
	            $w .= $nwords[floor($x/100)] .' '.$nwords[100];
	            
	        }
	         $r = fmod($x, 100);
	         if($r == 0 && $x >= 200){
	            $w .= 's';
	         }elseif($r > 0){
	            
	            $w .= ' '. NumberToLetterInFrench($r);
	         }
	      } else if($x < 1000000) {   // 1000 to 999999
	        if($x < 2000){
	            $w .= $nwords[1000]; 
	        } else {
	            $w .= NumberToLetterInFrench(floor($x/1000)) .' '.$nwords[1000];
	            
	        }
	         
	         $r = fmod($x, 1000);
	         if($r == 0 && $x >= 2000){
	            $w .= 's';
	         }elseif($r > 0){
	            
	            $w .= ' ';
	            $w .= NumberToLetterInFrench($r);
	         }
	      } else if($x < 1000000000) {    //  millions
	         $w .= NumberToLetterInFrench(floor($x/1000000)) .' '.$nwords[1000000];
	         $r = fmod($x, 1000000);
	         if($r == 0 && $x >= 200000){
	            $w .= 's';
	         }elseif($r > 0){
	            
	            $w .= ' ';
	            $w .= NumberToLetterInFrench($r);
	         }
	      } else { //  milliard
	         $w .= NumberToLetterInFrench(floor($x/1000000000)) .' '.$nwords[1000000000];
	         $r = fmod($x, 1000000000);
	         if($r == 0 && $x >= 2000000000){
	            $w .= 's';
	         }elseif($r > 0){
	            
	            $w .= ' ';
	            $w .= NumberToLetterInFrench($r);
	         }
	      }
	   }
	   return $w;
	}
// }