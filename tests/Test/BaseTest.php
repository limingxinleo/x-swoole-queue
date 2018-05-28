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
use Tests\TestCase;
use swoole_process;

class BaseTest extends TestCase
{
    public function testSwooleCase()
    {
        $this->assertTrue(extension_loaded('swoole'));
    }
}
