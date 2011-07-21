<?php
/**
 * Pool
 *
 * @author Fabrizio Branca
 */
class Threadi_Pool implements Threadi_ReadyAskableInterface {

	/**
	 * @var array
	 */
	private $threads = array();

	/**
	 * @var int capacity
	 */
	protected $capacity;

	/**
	 * @var int sleep time (in seconds) between two checks
	 */
	protected $sleepBetweenChecks;

	/**
	 * Constructor
	 */
	public function __construct($capacity=5, $sleepBetweenChecks=1) {
		$this->capacity = $capacity;
		$this->sleepBetweenChecks = $sleepBetweenChecks;
	}

	/**
	 * Add thread
	 *
	 * @param Threadi_PHPThread $thread
	 */
	public function add(Threadi_Thread_ThreadInterface $thread) {
		if (!$this->isReady()) {
			throw new Exception('This pool is out of capacity. You cannot add a new thread until an old one has finished its work.');
		}
		$this->threads[] = $thread;
	}

	/**
	 * Count all threads
	 *
	 * @return int number of threads
	 */
	public function countThreads() {
		return count($this->threads);
	}

	/**
	 * Check if all tasks are still alive
	 *
	 * @return int number of alive tasks
	 */
	public function checkAlive() {
		$count = 0;
		foreach ($this->threads as $key => $thread) { /* @var $thread Threadi_Thread_ThreadInterface */
			if (!$thread->isAlive()) {
				unset($this->threads[$key]);
			}
		}
		return $count;
	}

	/**
	 * Waits until there is some capacity left
	 *
	 * @return void
	 */
	public function waitTillReady() {
		while(!$this->isReady()) {
			sleep($this->sleepBetweenChecks);
		}
	}

	/**
	 * Check if this pool has some capacity left
	 *
	 * @return bool
	 */
	public function isReady() {
		$this->checkAlive();
		return ($this->countThreads() < $this->capacity);
	}
}