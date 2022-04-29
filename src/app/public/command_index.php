<?php
include_once '../vendor/autoload.php';

use App\Domain\Package\CapitalGains\SingletonStater;
use App\Infrastructure\Command\LineInputController;

SingletonStater::load();
SingletonStater::reset();

$data  = readline("Enter your data: ");
$input = new LineInputController();
$input->handle($data);
?>

