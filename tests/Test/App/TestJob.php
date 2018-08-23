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
use Xin\Swoole\Queue\JobInterface;

class TestJob implements JobInterface
{
    public $data;

    public $file = TESTS_PATH . '/test.cache';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        File::getInstance()->put($this->file, $this->data);
    }
}
