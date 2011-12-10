<?php

function smarty_modifier_urlrepair($string)
{
$arr = explode ('/', $string);
$counter = 0;
$return = '';
foreach ($arr as $explodeArr) {
$counter++;
if ($counter == 1) {
$return = rawurlencode($explodeArr);
}else {
    $return .= "/".rawurlencode($explodeArr);}
}
return $return;
}
?>
