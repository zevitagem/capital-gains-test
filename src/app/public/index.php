<?php
include_once '../vendor/autoload.php';

use App\Domain\Package\CapitalGains\SingletonStater;
use App\Infrastructure\Http\RestInputController;

SingletonStater::load();
SingletonStater::reset();

$input = new RestInputController();
$input->handle($_POST);