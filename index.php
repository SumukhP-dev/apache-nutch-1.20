<?php

$memcache = new Memcache;
$memcache->addServer(11211,  $timeout = 1000);
$memcache->addServer(11211,  $timeout = 1000);
$memcache->addServer(11211,  $timeout = 1000);
$memcache->addServer(11211,  $timeout = 1000);
$memcache->addServer(11211,  $timeout = 1000);
$memcache->addServer(11211,  $timeout = 1000);

$memcache->pconnect('localhost', 11211) or die ("Could not connect");

$start = microtime();
$tmp_object = new stdClass;
$i = 0;
while ($i < 1) {
  $tmp_object-> $i = 'test';
  $i++;
  $memcache->set('key', $tmp_object, false, 10000) or die ("Failed to save data at the server");
  $addTime = microtime();
  echo "Time elapsed: " . ((float)$addTime - (float)$start) . " ms";
  echo "<br>";
}
$end = microtime();
echo "Time elapsed for 1 addition: " . ((float)$end - (float)$start) . " ms";
echo "<br><br><br>";

$memcache->set('key', $tmp_object, false, 10000) or die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 100 seconds)\n";

$get_result = $memcache->get('key');
echo "Data from the cache:\n";

var_dump($get_result);
echo "<br>";

$time = time()+1; //one second future

while(time() < $time) {

  //sleep

}



$start = microtime();
$tmp_object = new stdClass;
$i = 0;
while ($i < 10) {
  $tmp_object-> $i = 'test';
  $i++;
  $memcache->set('key', $tmp_object, false, 10000) or die ("Failed to save data at the server");
  $addTime = microtime();
  echo "Time elapsed: " . ((float)$addTime - (float)$start) . " ms";
  echo "<br>";
}
$end = microtime();
echo "Time elapsed for 10 additions: " . ((float)$end - (float)$start) . " ms";
echo "<br><br><br>";

$memcache->set('key', $tmp_object, false, 100) or die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 100 seconds)\n";

$get_result = $memcache->get('key');
echo "Data from the cache:<br>";
var_dump($get_result);
echo "<br>";

$time = time()+1; //one second future

while(time() < $time) {

  //sleep

}



$start = microtime();
$tmp_object = new stdClass;
$i = 0;
while ($i < 100) {
  $tmp_object-> $i = 'test';
  $i++;
  $memcache->set('key', $tmp_object, false, 10000) or die ("Failed to save data at the server");
  $addTime = microtime();
  echo "Time elapsed: " . ((float)$addTime - (float)$start) . " ms";
  echo "<br>";
}
$end = microtime();
echo "Time elapsed for 100 addition: " . ((float)$end - (float)$start) . " ms";
echo "<br><br><br>";

$memcache->set('key', $tmp_object, false, 100) or die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 100 seconds)\n";

$get_result = $memcache->get('key');
echo "Data from the cache:\n";

var_dump($get_result);
echo "<br>";

$time = time()+1; //one second future

while(time() < $time) {

  //sleep

}
?>