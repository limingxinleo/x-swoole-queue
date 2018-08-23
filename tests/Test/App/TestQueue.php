<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Tests\Test\App;

use Xin\Support\File;
use Xin\Swoole\Queue\Task;

class TestQueue extends Task
{
    // 消息队列Redis键值 list lpush添加队列
    protected $queueKey = 'test:queue:queue';

    // 延时消息队列的Redis键值 zset
    protected $delayKey = 'test:queue:delay';

    // pid地址
    protected $pidPath = TESTS_PATH . '/queue.pid';

    public $file = TESTS_PATH . '/test.cache';

    protected function handle($recv)
    {
        File::getInstance()->put($this->file, 'upgrade');
    }
}
