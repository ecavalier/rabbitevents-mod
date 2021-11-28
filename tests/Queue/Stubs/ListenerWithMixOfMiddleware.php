<?php

namespace Ecavalier\Events\Tests\Queue\Stubs;

class ListenerWithMixOfMiddleware extends ListenerWithMethodMiddleware
{
    public $middleware = [
        'Ecavalier\Events\Tests\Queue\Stubs\ListenerMiddleware@action',
        ListenerMiddleware::class
    ];

    public function __construct()
    {
        ListenerMiddleware::$calledTimes = 0;
    }

    public function handle($payload)
    {
        $this->handleCalls++;

        return $this->middlewareCalls | $this->handleCalls | ListenerMiddleware::$calledTimes;
    }
}
