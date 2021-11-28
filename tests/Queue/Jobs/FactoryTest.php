<?php

namespace Ecavalier\Events\Tests\Queue\Jobs;

use Illuminate\Container\Container;
use Interop\Amqp\Impl\AmqpMessage;
use Mockery as m;
use Ecavalier\Events\Facades\RabbitEvents;
use Ecavalier\Events\Queue\Jobs\Factory;
use Ecavalier\Events\Queue\Jobs\Job;
use Ecavalier\Events\Queue\Manager;
use Ecavalier\Events\Tests\TestCase;

class FactoryTest extends TestCase
{
    public function testMakeJob()
    {
        $dispatcher = RabbitEvents::partialMock();
        $dispatcher->shouldReceive()
            ->getListeners('item.created')
            ->andReturn($this->listeners());

        $message = new AmqpMessage();
        $message->setRoutingKey('item.created');

        $factory = new Factory(m::mock(Container::class), m::spy(Manager::class));
        $jobs = $factory->makeJobs($message);

        self::assertInstanceOf(\Generator::class, $jobs);
        $count = 0;
        foreach ($jobs as $job) {
            self::assertInstanceOf(Job::class, $job);
            ++$count;
        }
        self::assertEquals(2, $count);
    }

    protected function listeners()
    {
        return [
            'FirstListener' => [
                function() { return 'first listener';},
            ],
            'SecondListener' => [
                function() { return 'second listener';},
            ]
        ];
    }
}
