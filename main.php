<?php

use React\EventLoop\Loop;
use Rx\Observable;
use Rx\Observable\NeverObservable;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use Rx\Scheduler\ImmediateScheduler;
use Rx\Testing\TestScheduler;

require_once './vendor/autoload.php';



$observer = new CallbackObserver (
    function ($v) {
        echo "Next: $v\n";
    },
    function (\Exception $e) {
        $msg = $e->getMessage();
        echo "err: $msg\n";
    },
    function () {
        echo 'complete !';
        return Observable::never();
    }
);

$loop = Loop::get();

Scheduler::setDefaultFactory(fn () => new ImmediateScheduler());
Scheduler::setDefaultFactory(fn () => new EventLoopScheduler($loop));

$c = collect([1,2,3,4,5,6,7,8,9,10]);

Observable::fromArray($c->toArray())
    ->interval(1000)
    ->flatMap(function ($i) {
        return Observable::of('a: ' . $i);
    })
    ->subscribe($observer);

Observable::fromArray($c->toArray())
    ->interval(500)
    ->flatMap(function ($i) {
        return Observable::of('b: ' . $i);
    })
    ->subscribe($observer);


