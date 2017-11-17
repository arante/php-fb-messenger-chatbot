<?php

function getGender($gender_name){
  $command = " Please try again.\n GENDER <name>";

  if(checkValidity($gender_name, 'name') == 1){
    $url = 'https://api.genderize.io/?name='.$gender_name;
    $proc = file_get_contents($url);
    $proc = json_decode($proc, true);
    $prob = $proc['probability'] * 100;
    $name = $proc['name'];

    if ($prob != 0){
      $output = ucfirst($name) . " is " . $prob  . "% " . $proc['gender'] . " name. This is based on ". $proc['count']. ' participants.';
      return $output;
    }else{
      if (str_word_count($name) != 1){
        if(is_numeric($name)){
          $output = "Numbers are not names.".$command;
        }else{
          $output = "We only recognize one word name. Separate ". ucwords($gender_name) ." into different queries.".$command;
        }
        //$output = str_word_count($name);
      }else{
        $output = "Sorry! ". ucfirst($name) . " is not a recognized name.".$command;
      }
      return $output;
    }
  }else{
    return "Name is using invalid characters.".$command;
  }
}

function getPhone($p_num){

   $url = 'http://apilayer.net/api/validate?access_key=2ac4a493788c736a4adb8d8b5a4c3876&number=' . $p_num . '&country_code=&format=1';
   $proc = file_get_contents($url);
   $proc = json_decode($proc, true);

   $valid = $proc['valid'];
   $loc_format  = $proc['local_format'];
   $int_format = $proc['intl_format'];
   $ccode = $proc['country_code'];
   $cname  = $proc['country_name'];
   $loc = $proc['location'];
   $carr  = $proc['carrier'];
   $line = $proc['line_type'];

      if($valid==1){

	     $output  = "Phone number details\n-------------------------\n" .
                    "\nLocal Format: " . $loc_format .
					 "\nInternational Format:  " . $int_format .
					"\nCountry Code:  " . $ccode .
					"\nCountry Name:  " . $cname .
					"\nLocation:  " . $loc .
					"\nCarrier:  " . $carr .
					"\nLine Type:  " . $line;
	 }else $output = "Phone number is invalid. Please try again.\nPHONE <2 digit country code><2 digit area code><phone number>";

   return $output;
}


function getIP($ip_add){

	$url = 'https://ipapi.co/' . $ip_add . '/json';
	$proc = file_get_contents($url);
	$proc = json_decode($proc, true);

	$city = $proc['city'];
	$reg = $proc['region'];
	$regcode = $proc['region_code'];
	$cntry = $proc['country'];
	$cname = $proc['country_name'];
	$pcode = $proc['postal'];
	$lat = $proc['latitude'];
	$long = $proc['longitude'];
	$time = $proc['timezone'];
	$asn = $proc['asn'];
	$org = $proc['org'];

	if($city!=NULL){

	 $output  = "IP address details\n-------------------------\n" .
                     "IP:  " . $ip_add .
					 "\nCity:  " . $city .
					 "\nRegion:  " . $reg .
					 "\nRegion Code:  " . $regcode .
					 "\nCountry: " . $cntry .
					 "\nCountry Name:  " . $cname .
					 "\nPostal Code:  " . $pcode .
					 "\nLatitude: " . $lat .
					 "\nLongitude:  " . $long .
					 "\nTime Zone: " . $time .
					 "\nASN:  " . $asn .
					 "\nOrg:  " . $org;

	}else $output = "IP address is invalid. Please try again. \nIP <IP address in 8.8.8.8 format>";

    return $output;

}


function getHistoryDate($history_date = NULL){
  $command = " Please try again.\nHISTORY <mm/dd>";
  if (!empty($history_date)){
    if(checkValidity($history_date, 'date') == 1){
      $history_date = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $history_date)));
      $history_date = str_replace(array('/','-'),' ', $history_date);

      $cd_space = explode(' ',$history_date);
      $m = $cd_space[0];
      $d = $cd_space[1];


      if((is_numeric($m) && is_numeric ($d)) && (!empty($d) || !is_null($d))){
        $m = intval($m);
        $d = intval($d);

        if(($m != 0) && ($d != 0)){
          $month_names = array( '1' => "January",'2' => "February",'3' => "March",'4' => "April",
                                '5' => "May",'6' => "June",'7' => "July",'8' => "August",'9' => "September",
                                '10' => "October",'11' => "November",'12' => "December" );

          if (preg_match("/^(?:[1-9]|0[1-9]|1[0-2])$/",$m) && preg_match("/^(?:[0-9]|0[1-9]|1[0-9]|2[0-9]|3[0-1])$/",$d)) {
            $pass = false;

            do{
              if (($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 12 ) && ($d <= 31 )){
                $pass = true;
              }elseif(( $m == 4 || $m == 6 || $m == 9 || $m == 11 ) && ($d <= 30 )){
                $pass = true;
              }elseif(( $m == 2 ) && ($d <= 29 )){
                $pass = true;
              }else{
                return 'Sorry, you miscounted the days for '. $month_names[$m].". ".$command;
              }
            }while($pass == false);

            if($pass==true){
              $url = 'http://numbersapi.com/'. $m . '/' . $d .'/date';
              $proc = file_get_contents($url);
              $message = "History Trivia on \n". $month_names[$m] . " " . $d ."\n----------\n";
              $output = $message . $proc;
            }

          } else {
            $output = "Invalid date.".$command;
          }
        }else{
          $output = "Dates must be more than 0.".$command;
        }
      }else{
        if(is_numeric($m)){
          $output = "Date is missing one more value.".$command;
        }else{
          $output = "Dates must be numeric values.".$command;
        }
      }
    }else{
      $output = "Using invalid characters.".$command;
    }

  }else{
    $url = 'http://numbersapi.com/random/date';
    $proc = file_get_contents($url);
    $output = "RANDOM History Trivia\n----------\n".$proc;
  }

  return $output;
}

function checkValidity($buffer,$type)
{
  switch ($type) {
    case 'name':
      return !preg_match('/[^A-Za-z0-9\-\ ]/', $buffer);
    case 'date':
      return !preg_match('/[^A-Za-z0-9\-\/\ ]/', $buffer);
    default:
      return 0;
  }
}
