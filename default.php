<?php

use Rx\Observable;
use Rx\Scheduler;

require_once './vendor/autoload.php';

$loop = React\EventLoop\Loop::get();

//You only need to set the default scheduler once
Scheduler::setDefaultFactory(function() use($loop){
    return new Scheduler\EventLoopScheduler($loop);
});
$c = [10, 1,2,3,4,5,6,4,3,2,];
Observable::fromArray($c)
    ->take(3)
    ->flatMap(function ($i) {
        return Observable::of($i + 1);
    })
    ->subscribe(function ($e) {
        echo $e, PHP_EOL;
    });
d($c);
$loop->run();
d($c);