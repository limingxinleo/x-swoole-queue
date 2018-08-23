<?php
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
