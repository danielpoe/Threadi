<?php


/**
 * Simple Join Point 
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_JoinPoint implements Threadi_ReadyAskableInterface {
	
	/**
	 * @var array
	 */
	private $threadList = array();
	
	public function __construct() {
	 	$arguments = func_get_args();
         if ( !empty( $arguments ) ) {
	         foreach ($arguments as $thread) {
	         	$this->add($thread);
	         }
         }
	}
	
	/**
	 * @param Threadi_PHPThread $thread
	 */
	public function add(Threadi_ReadyAskableInterface $thread) {
		$this->threadList[] = $thread;
	}
	
	/**
	 * Waits till all threads have finished
	 */
	public function waitTillReady() {
		foreach ($this->threadList as $thread) {
			$thread->waitTillReady();
		}
	}
	
	/**
	 * all ready?
	 */
	public function isReady() {
		foreach ($this->threadList as $thread) {
			if (!$thread->isReady()) {
				return false;
			}
		}
		return true;
	}
}



