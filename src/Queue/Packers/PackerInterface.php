<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */
namespace Xin\Swoole\Queue\Packers;

interface PackerInterface
{
    /**
     * Pack data
     *
     * @param mixed $data
     * @return mixed
     */
    public function pack($data);

    /**
     * Unpack data
     *
     * @param mixed $data
     * @return mixed
     */
    public function unpack($data);
}
