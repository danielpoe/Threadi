<?php


/**
 * Simple Service
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_ThreadService {
	private $factory;
	
	public function __construct(Threadi_ThreadFactory $factory) {
		$this->factory = $factory;
	}
	
	/**
	 * @param callback $callback
	 * @return Threadi_Thread_ThreadInterface
	 */
	public static function callAndForget($callback) {
		Threadi_ThreadFactory::getThread($callback)->start();
	}
	
}



