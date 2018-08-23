<?php
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