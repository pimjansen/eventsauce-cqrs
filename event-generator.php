<?php

require 'vendor/autoload.php';

use EventSauce\EventSourcing\CodeGeneration\CodeDumper;
use EventSauce\EventSourcing\CodeGeneration\YamlDefinitionLoader;

$loader = new YamlDefinitionLoader();
$dumper = new CodeDumper();
$phpCode = $dumper->dump($loader->load('./event-generator.yml'));
echo $phpCode;
//file_put_contents($destination, $phpCode);