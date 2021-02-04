<?php
function makecomma($input)
{
    // This function is written by some anonymous person - I got it from Google
    if(strlen($input)<=2)
    { return $input; }
    $length=substr($input,0,strlen($input)-2);
    $formatted_input = makecomma($length).",".substr($input,-2);
    return $formatted_input;
}
function formatInBDTStyle($num){
    // This is my function
    $pos = strpos((string)$num, ".");
    if ($pos === false) { $decimalpart="00";}
    else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }
    if(strlen($num)>3 & strlen($num) <= 12){
        $last3digits = substr($num, -3 );
        $numexceptlastdigits = substr($num, 0, -3 );
        $formatted = makecomma($numexceptlastdigits);
        $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
    }elseif(strlen($num)<=3){
        $stringtoreturn = $num.".".$decimalpart ;
    }elseif(strlen($num)>12){
        $stringtoreturn = number_format($num, 2);
    }
    if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
    return $stringtoreturn;
}
