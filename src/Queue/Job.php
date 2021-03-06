<?php
/**
 * This file is part of Queue Component with Swoole.
 *
 * @link     https://github.com/limingxinleo/x-swoole-queue
 * @contact  limingxin@swoft.org
 * @license  https://github.com/limingxinleo/x-swoole-queue/blob/master/LICENSE
 */

namespace Xin\Swoole\Queue;

use Psr\Log\LoggerInterface;
use Xin\Cli\Color;
use Redis;
use Xin\Swoole\Queue\Packers\DefaultPacker;
use Xin\Swoole\Queue\Packers\PackerInterface;

class Job extends Task
{
    // 最大进程数
    protected $maxProcesses = 3;

    // 子进程最大循环处理次数
    protected $processHandleMaxNumber = 10000;

    // 失败的消息
    protected $errorKey = 'swoole:queue:error';

    // 消息队列Redis键值 list lpush添加队列
    protected $queueKey = 'swoole:queue:queue';

    // 延时消息队列的Redis键值 zset
    protected $delayKey = 'swoole:queue:delay';

    // 日志Handler
    protected $loggerHandler;

    // 当前redis 实例
    protected $redis;

    // 打包器
    protected $packer;

    public function setQueueKey($key)
    {
        $this->queueKey = $key;
        return $this;
    }

    public function setDelaykey($key)
    {
        $this->delayKey = $key;
        return $this;
    }

    public function setErrorKey($key)
    {
        $this->errorKey = $key;
        return $this;
    }

    public function setPidPath($path)
    {
        $this->pidPath = $path;
        return $this;
    }

    public function setLoggerHandler(LoggerInterface $logger)
    {
        $this->loggerHandler = $logger;
        return $this;
    }

    protected function handle($recv)
    {
        try {
            $packer = $this->getPacker();
            $obj = $packer->unpack($recv);
            if ($obj instanceof JobInterface) {
                $name = get_class($obj);
                $date = date('Y-m-d H:i:s');
                echo Color::colorize("[{$date}] Processing: {$name}", Color::FG_GREEN) . PHP_EOL;
                // 处理消息
                $obj->handle();
                $date = date('Y-m-d H:i:s');
                echo Color::colorize("[{$date}] Processed: {$name}", Color::FG_GREEN) . PHP_EOL;
            }
        } catch (\Throwable $ex) {
            $date = date('Y-m-d H:i:s');
            echo Color::colorize("[{$date}] Failed: {$name}", Color::FG_RED) . PHP_EOL;
            $this->logError($ex);

            // 推送失败的消息对失败队列
            $redis = $this->getRedisChildClient();
            $redis->lpush($this->errorKey, $recv);
        }
    }

    /**
     * @desc   记录错误日志
     * @author limx
     * @param $message
     * @return \Phalcon\Logger\AdapterInterface
     */
    protected function logError(\Throwable $ex)
    {
        if ($this->loggerHandler instanceof LoggerInterface) {
            $msg = $ex->getMessage() . ' code:' . $ex->getCode() . ' in ' . $ex->getFile() . ' line ' . $ex->getLine() . PHP_EOL . $ex->getTraceAsString();
            $this->loggerHandler->error($msg);
        }
    }

    /**
     * 重载失败的Job
     * @author limx
     */
    public function reloadErrorJobs()
    {
        $redis = $this->getRedisChildClient();
        $count = 0;
        while ($data = $redis->rpoplpush($this->errorKey, $this->queueKey)) {
            $count++;
        }

        return $count;
    }

    /**
     * 删除所有失败的Job
     * @author limx
     */
    public function flushErrorJobs()
    {
        $redis = $this->getRedisChildClient();
        return $redis->del($this->errorKey);
    }

    /**
     * 查询失败的消息数
     * @author limx
     */
    public function countErrorJobs()
    {
        $redis = $this->getRedisChildClient();
        return $redis->lLen($this->errorKey);
    }

    public function getRedisChildClient()
    {
        if (isset($this->redis) && $this->redis instanceof Redis) {
            return $this->redis;
        }

        return $this->redis = $this->redisChildClient('job');
    }

    public function getPacker()
    {
        if (isset($this->packer) && $this->packer instanceof PackerInterface) {
            return $this->packer;
        }
        return $this->packer = new DefaultPacker();
    }

    public function push(JobInterface $job)
    {
        $redis = $this->getRedisChildClient();
        $packer = $this->getPacker();
        return $redis->lpush($this->queueKey, $packer->pack($job));
    }

    public function delay(JobInterface $job, $time = 0)
    {
        if (empty($time)) {
            return $this->push($job);
        }

        $redis = $this->getRedisChildClient();
        $packer = $this->getPacker();
        return $redis->zAdd($this->delayKey, time() + $time, $packer->pack($job));
    }
}
