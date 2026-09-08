<?php

use PHPActiveRecord\ActiveRecord;

require_once __DIR__."/../vendor/autoload.php";
$dbFile = __DIR__."/db.sqlite";

if (file_exists($dbFile))
    unlink($dbFile);

ActiveRecord::init("sqlite:$dbFile");
$sql = (string)file_get_contents(__DIR__."/sql/seed.sql");

ActiveRecord::run($sql);