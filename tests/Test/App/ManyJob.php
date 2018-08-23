<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Tests\Test\App;

use Xin\Redis;
use Xin\Swoole\Queue\JobInterface;

class ManyJob implements JobInterface
{
    public $key = 'test:incr';

    public function handle()
    {
        $config = include TESTS_PATH . '/_ci/config.php';

        $host = $config['redisHost'];
        $auth = $config['redisAuth'];
        $db = $config['redisDb'];
        $port = $config['redisPort'];

        $redis = Redis::getInstance($host, $auth, $db, $port);
        $redis->incr($this->key);
    }
}
