<?php
/**
 * Created by PhpStorm.
 * User: caojiabin
 * Date: 30/03/2018
 * Time: 3:29 PM
 */

namespace Universe\Swoole;

/**
 * 进程助手类
 */
class Process
{
    /**
     * 使当前进程蜕变为一个守护进程
     * @param bool $closeInputOutput
     */
    public static function daemon($closeInputOutput = false)
    {
        \Swoole\Process::daemon(true, !$closeInputOutput);
    }

    /**
     * 设置进程名称
     * @param $name
     */
    public static function setName($name)
    {
        if (stristr(PHP_OS, 'DAR')) {
            return;
        }
        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($name);
        } elseif (function_exists('swoole_set_process_name')) {
            swoole_set_process_name($name);
        }
    }

    /**
     * 检查 PID 是否运行
     * @param $pid
     * @return bool
     */
    public static function isRunning($pid)
    {
        return \Swoole\Process::kill($pid, 0);
    }

    /**
     * kill 进程
     * @param $pid
     * @param null $signal
     */
    public static function kill($pid, $signal = null)
    {
        if (is_null($signal)) {
            \Swoole\Process::kill($pid);
        } else {
            \Swoole\Process::kill($pid, $signal);
        }
    }

    /**
     * @param $pidFile 写入 PID 文件
     */
    public static function writePid($pidFile)
    {
        $pid  = Process::getPid();
        $file = fopen($pidFile, "w+");
        if (flock($file, LOCK_EX)) {
            fwrite($file, $pid);
            flock($file, LOCK_UN);
        } else {
            die("Error writing file '{$pidFile}'" . PHP_EOL);
        }
        fclose($file);
    }

    /**
     * @return int 返回当前进程 id
     */
    public static function getPid()
    {
        return getmypid();
    }

    /**
     * @param $pidFile
     * @return bool|string 返回主进程 id
     */
    public static function getMasterPid($pidFile)
    {
        if (!file_exists($pidFile)) {
            return false;
        }
        $pid = file_get_contents($pidFile);
        if (self::isRunning($pid)) {
            return $pid;
        }
        return false;
    }
}
