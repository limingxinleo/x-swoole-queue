<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
require __DIR__ . '/bootstrap.php';

use Tests\Test\App\Queue;

$config = include TESTS_PATH . '/_ci/config.php';

$host = $config['redisHost'];
$auth = $config['redisAuth'];
$db = $config['redisDb'];
$port = $config['redisPort'];

$queue = new Queue();
$queue->run();
