<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function unik_str($minVal, $maxVal) {
    $range = $maxVal - $minVal;
    if ($range < 0) return $minVal; // not so random...

    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1

    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $minVal + $rnd;
}

function gen_uuid($data = null)
{
   // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
   $data = $data ?? random_bytes(16);
   assert(strlen($data) == 16);

   // Set version to 0100
   $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
   // Set bits 6-7 to 10
   $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

   // Output the 36 character UUID.
   return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

?>
