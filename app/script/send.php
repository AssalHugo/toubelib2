<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;



$exchange_name = 'testExanges';
$queue_name = 'testqueues';
$routing_key = 'routing';
$connection = new AMQPStreamConnection('rabbitmq',5672, 'admin', 'admin');
$channel = $connection->channel();
$channel->exchange_declare($exchange_name, 'direct', false, true, false);
$channel->queue_declare($queue_name, false, true, false, false);
$channel->queue_bind($queue_name, $exchange_name, $routing_key);

$msg_body=['testmessage'];

$msg = new AMQPMessage(json_encode($msg_body));

$channel->basic_publish($msg, 'testExanges', 'routing');

$channel->close();
$connection->close();