<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Xin\Swoole\Queue\Packers;

class DefaultPacker implements PackerInterface
{
    public function pack($data)
    {
        return serialize($data);
    }

    public function unpack($data)
    {
        return unserialize($data);
    }
}
