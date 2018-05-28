<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test;

use Tests\Rpc\App\Test2Client;
use Tests\Rpc\App\TestClient;
use Tests\Test\App\TestJob;
use Tests\TestCase;
use swoole_process;
use Xin\Support\File;

class BaseTest extends TestCase
{
    public function testSwooleCase()
    {
        $this->assertTrue(extension_loaded('swoole'));
    }

    public function testSwooleQueueTask()
    {
        $data = file_get_contents($this->file);
        $this->assertEquals('init', $data);
        $this->redis->lPush('test:queue:queue', 'xxxx');
        sleep(2);
        $data = file_get_contents($this->file);
        $this->assertEquals('upgrade', $data);
    }

    public function testSwooleQueueJob()
    {
        $data = file_get_contents($this->file);
        $this->assertEquals('init', $data);
        $job = new TestJob('upgrade by test job!');
        $this->redis->lPush('swoole:queue:queue', serialize($job));
        sleep(2);
        $data = file_get_contents($this->file);
        $this->assertEquals('upgrade by test job!', $data);
    }
}
