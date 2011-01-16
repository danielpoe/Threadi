<?php
require_once(dirname(__FILE__).'/../Loader.php');

/**
 * Example 2 shows how results from Threaded callbacks can be read
 *
 */

class Worker {
	public function fetchAWebsite($url) {
		$content = file_get_contents($url);
		return "fetched website $url - lenght ".strlen($content).PHP_EOL;
	}
}

$worker = new Worker();


echo "Doing serial execution:".PHP_EOL;
echo "-------------------------".PHP_EOL;
$startTime = microtime(TRUE);
echo $worker->fetchAWebsite('http://www.google.de');
echo $worker->fetchAWebsite('http://www.aoemedia.de');
echo $worker->fetchAWebsite('http://www.heise.de');
echo "Time needed in seconds: ". ( microtime(TRUE)-$startTime).PHP_EOL.PHP_EOL;

echo "Doing parallel execution:".PHP_EOL;
echo "-------------------------".PHP_EOL;
$startTime = microtime(TRUE);
$thread1 = Threadi_ThreadFactory::getReturnableThread(array($worker,'fetchAWebsite'));
$thread1->start('http://www.google.de'); 
$thread2 = Threadi_ThreadFactory::getReturnableThread(array($worker,'fetchAWebsite'));
$thread2->start('http://www.aoemedia.de');
$thread3 = Threadi_ThreadFactory::getReturnableThread(array($worker,'fetchAWebsite'));
$thread3->start('http://www.heise.de');


$joinPoint = new Threadi_JoinPoint($thread1, $thread2, $thread3);
$joinPoint->waitTillReady();

echo $thread1->getResult();
echo $thread2->getResult();
echo $thread3->getResult();

echo "Time needed in seconds: ". ( microtime(TRUE)-$startTime).PHP_EOL;