<?php
/**
 * This example shows the usage of the thread pool feature in combination with an iterator.
 *
 * If you have a large collection of something and you need to do something on every element
 * you can create a thread pool and use following sample code to have your collection being
 * processed by multiple worker threads at the same time.
 * As soon as one thread has finished his work the thread pool is ready to get a new thread.
 * So this loop manages itself and takes care that all collection items are being processed
 * as fast as possible
 *
 * @author Fabrizio Branca
 */

require_once (dirname(__FILE__) . '/../Loader.php');

/**
 * Simple worker, that only displays its parameters and wait for a second
 */
class Worker {
	public function process($key, $value) {
		echo "Processing $key: $value\n";
		sleep(1);
	}
}

/**
 * Simple collection that gets filled with 1000 random numbers
 */
class Collection implements Iterator {
	protected $position = 0;
	protected $array = array();
	public function __construct() { for ($i=0; $i<1000; $i++) { $this->array[] = rand(0,10000); }}
	public function rewind() { $this->position = 0; }
	public function current() { return $this->array[$this->position]; }
	public function key() { return $this->position; }
	public function next() { $this->position++; }
	public function valid() { return isset($this->array[$this->position]); }
}

$worker = new Worker();
$collection = new Collection();

// maximum amount of parallel threads
$capacity = 5;

$pool = new Threadi_Pool($capacity);

while ($collection->valid()) {

	// wait until there is a free slot ready
	$pool->waitTillReady();

	// create new thread
	$thread = new Threadi_Thread_PHPThread(array($worker, 'process'));
	$thread->start($collection->key(), $collection->current());

	// append it to the pool
	$pool->add($thread);

	$collection->next();
}

