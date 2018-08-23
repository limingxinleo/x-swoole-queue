<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Tests\Test\App;

use Xin\Swoole\Queue\JobInterface;

class ExceptionJob implements JobInterface
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        sleep(1);
        throw new \Exception($this->data);
    }
}
