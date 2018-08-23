<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Tests\Test\App;

use Xin\Swoole\Queue\Job;

class Queue extends Job
{
    protected $maxProcesses = 10;

    public function __construct()
    {
        $config = include TESTS_PATH . '/_ci/config.php';

        $host = $config['redisHost'];
        $auth = $config['redisAuth'];
        $db = $config['redisDb'];
        $port = $config['redisPort'];

        $this->setRedisConfig($host, $auth, $db, $port);
        $this->setPidPath(TESTS_PATH . '/queue2.pid');
    }
}
