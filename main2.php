<?php

require_once './vendor/autoload.php';

use React\EventLoop\Loop;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use Rx\Scheduler\ImmediateScheduler;

/**
 * @Scheduler
 */
$loop = Loop::get();
Scheduler::setDefaultFactory(fn () => new ImmediateScheduler());
Scheduler::setAsyncFactory(fn () => new EventLoopScheduler($loop));

/**
 * @Observer Callback
 */
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

// class CurlPromise implements PromiseInterface {
//     public function then(): PromiseInterface
//     {

//     }
// }


// Observable::fromPromise()
//     ->interval(1000)
//     ->take(4)
//     ->flatMap(function ($i) {
//         return Observable::of('a: ' . $i);
//     })
//     ->subscribe($observer);


