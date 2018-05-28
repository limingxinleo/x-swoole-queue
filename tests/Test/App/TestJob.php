<?php
// +----------------------------------------------------------------------
// | TestJob.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
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