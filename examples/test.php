<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Plivo\Plivo;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();
define("PLIVO_AUTH_ID", getenv('PLIVO_AUTH_ID'));
define("PLIVO_AUTH_TOKEN", getenv('PLIVO_AUTH_TOKEN'));
define("PLIVO_SRC_PHONE", getenv('PLIVO_SRC_PHONE'));

$plivo = new Plivo(PLIVO_AUTH_ID, PLIVO_AUTH_TOKEN, PLIVO_SRC_PHONE);
$phoneNumber = "1" . "destination-phone-number"
$plivo->sendMessage(array($phoneNumber), "Yo, what up?");

$messages = $plivo->getSentMessages();
var_dump($messages);

?>
