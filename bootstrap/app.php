<?php

require __DIR__."/../vendor/autoload.php";

use App\Core\Environment;

Environment::load(__DIR__.'/..');

session_start();

define("BASE_URL", getenv('BASE_URL'));

define("ROOT", __DIR__.'/..');

require ROOT.'/app/Http/kernel.php';

require ROOT."/config/function-default.php";

require ROOT."/routes/router.php";