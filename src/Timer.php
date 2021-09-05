<?php

namespace Pressmind\Travelshop;

/**
 * https://www.smashingmagazine.com/2018/10/performance-server-timing/
 * <code>
 * Timer::startTimer('routing');
 * require_once 'config-routing.php';
 * Timer::endTimer('routing');
 * 
 * see http_header.php, here is the Server-Timing header set.
 * using chrome developer console to run performance metrics
 * </code>
 * 
 */
class Timer
{
    private static $timers = [];

    public static function startTimer($name, $description = null)
    {
        self::$timers[$name] = [
            'start' => microtime(true),
            'desc' => $description,
        ];
    }

    public static function endTimer($name)
    {
        self::$timers[$name]['end'] = microtime(true);
    }

    public static function getTimers()
    {
        $metrics = [];

        if (count(self::$timers)) {
            foreach(self::$timers as $name => $timer) {
                $timeTaken = ($timer['end'] - $timer['start']) * 1000;
                $output = sprintf('%s;dur=%f', $name, $timeTaken);

                if ($timer['desc'] != null) {
                    $output .= sprintf(';desc="%s"', addslashes($timer['desc']));
                }
                $metrics[] = $output;
            }
        }

        return implode(', ', $metrics);
    }
}