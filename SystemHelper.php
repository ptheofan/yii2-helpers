<?php
/**
 * User: Paris Theofanidis
 * Date: 05/06/16
 * Time: 02:57
 */
namespace ptheofan\helpers;

/**
 * Class SystemHelper
 *
 * @package common\helpers
 */
class SystemHelper
{
    /**
     * Run a system process assign content in it's STDIN and collect the return result and exit code
     * SystemHelper::call('/usr/bin/which', ['php']);
     * @param string $binary
     * @param array $args
     * @param $stdIn
     * @param $exitCode
     * @return string
     */
    public static function call($binary, $args = [], $stdIn, &$exitCode)
    {
        $descriptorSpec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w")   // stdout is a pipe that the child will write to
        );

        $process = proc_open(rtrim($binary . ' ' . implode(' ', $args)), $descriptorSpec, $pipes);
        fwrite($pipes[0],$stdIn);
        fclose($pipes[0]);

        $stdOut = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $exitCode = proc_close($process);
        return $stdOut;
    }
}