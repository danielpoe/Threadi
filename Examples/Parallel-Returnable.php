<?php
require_once(dirname(__FILE__).'/../Loader.php');

/**
 * Example 2 shows how results from Threaded callbacks can be read
 *
 */

class Worker {
	public function doSomething() {
		sleep(2);
		return "worker return at ".@date('i:s').PHP_EOL;
	}
}

$worker1 = new Worker();
$worker2 = new Worker();

echo "Doing serial execution".PHP_EOL;
echo "-------------------------".PHP_EOL;
$startTime = microtime(TRUE);
echo $worker1->doSomething();
echo $worker2->doSomething();
echo "Time needed in seconds: ". ( microtime(TRUE)-$startTime).PHP_EOL.PHP_EOL;

echo "Doing parallel execution".PHP_EOL;
echo "-------------------------".PHP_EOL;
$startTime = microtime(TRUE);
$thread1 = Threadi_ThreadFactory::getReturnableThread(array($worker1,'doSomething')); 
$thread2 = Threadi_ThreadFactory::getReturnableThread(array($worker2,'doSomething')); 
$thread1->start();
$thread2->start();
$joinPoint = new Threadi_JoinPoint($thread1, $thread2);
$joinPoint->waitTillReady();
echo $thread1->getResult();
echo $thread2->getResult();
echo "Time needed in seconds: ". ( microtime(TRUE)-$startTime).PHP_EOL;