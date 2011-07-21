<?php
require_once (dirname(__FILE__) . '/../Loader.php');

/**
 * Example class
 */
class Worker {

	/**
	 * Doe something
	 *
	 * @return void
	 */
	public function doSomething() {
		sleep(2);
		echo "worker output at " . @date('i:s') . PHP_EOL;
	}
}

$worker1 = new Worker();
$worker2 = new Worker();

echo "Doing serial execution" . PHP_EOL;
echo "-------------------------" . PHP_EOL;
$startTime = microtime(TRUE);
$worker1->doSomething();
$worker2->doSomething();

echo "Time needed in seconds: " . (microtime(TRUE) - $startTime) . PHP_EOL . PHP_EOL;
echo "Doing parallel execution" . PHP_EOL;
echo "-------------------------" . PHP_EOL;
$startTime = microtime(TRUE);
$thread1 = new Threadi_Thread_PHPThread(array($worker1, 'doSomething'));
$thread2 = new Threadi_Thread_PHPThread(array($worker2, 'doSomething'));
$thread1->start();
$thread2->start();
$joinPoint = new Threadi_JoinPoint($thread1, $thread2);
$joinPoint->waitTillReady();
echo "Time needed in seconds: " . (microtime(TRUE) - $startTime) . PHP_EOL;