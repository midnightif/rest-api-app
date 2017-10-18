<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = require_once dirname(__DIR__) . "/src/Api/Api.php";

require __DIR__.'/../config/constants.php';

require __DIR__.'/../src/Api/controllers.php';


$app->run();
