<?php

require_once './vendor/autoload.php';

use React\EventLoop\Loop;
use Rx\Observable;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use Rx\Scheduler\ImmediateScheduler;

class Yeeeeeee implements Iterator {    
    public function __construct(
        protected array $tasks = []
    ) {}
    
    public function current(): mixed{
        return current($this->tasks);
    }
    public function key (): mixed {
        return key($this->tasks);
    }
    public function next () : void{
        next($this->tasks);
    }
    public function rewind () : void{
        prev($this->tasks);
    }
    public function valid (): bool{
        return true;
    }
}

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
    }
);

$loop = Loop::get();

Scheduler::setDefaultFactory(fn () => new ImmediateScheduler());
Scheduler::setAsyncFactory(fn () => new EventLoopScheduler($loop));

Observable::fromIterator(new Yeeeeeee(tasks: [1,2,3,4,5,6,7,8,9,10]))
    ->interval(1000)
    // ->take(4)
    ->flatMap(function ($i) {
        return Observable::of('a: ' . $i);
    })
    ->subscribe($observer);


