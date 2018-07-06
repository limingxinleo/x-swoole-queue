<?php
// +----------------------------------------------------------------------
// | TestJob.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
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