<?php

require '../vendor/autoload.php';

use app\library\Cache;

$cache = new Cache('cache');
$data = $cache->create(['name' => 'Avraham', 'address' => 'My addrres caralho', 'age' => '10000000000'], 1);