<?php

namespace Ecavalier\Events\Console\Log;

use Ecavalier\Events\Queue\Events\JobProcessing;
use Ecavalier\Events\Queue\Events\JobProcessed;
use Ecavalier\Events\Queue\Events\JobExceptionOccurred;
use Ecavalier\Events\Queue\Events\JobFailed;

abstract class Writer
{

    const STATUS_PROCESSING = 'Processing';
    const STATUS_PROCESSED = 'Processed';
    const STATUS_EXCEPTION = 'Exception Occurred';
    const STATUS_FAILED = 'Failed';

    /**
     * @param JobProcessing | JobProcessed | JobFailed $event
     */
    abstract public function log($event);

    /**
     * @param JobProcessing | JobProcessed | JobFailed $event
     * @return string
     */
    protected function getStatus($event)
    {
        switch (get_class($event)) {
            case JobProcessing::class:
                return self::STATUS_PROCESSING;
            case JobProcessed::class:
                return self::STATUS_PROCESSED;
            case JobExceptionOccurred::class:
                return self::STATUS_EXCEPTION;
            case JobFailed::class:
                return self::STATUS_FAILED;
        }
    }
}
