<?php
/**
 * Simple Factory Class
 *
 * @author Daniel Pötzinger
 */
class Threadi_ThreadFactory {

	/**
	 * Get thread
	 *
	 * @param callback $callback
	 * @return Threadi_Thread_ThreadInterface
	 */
	public static function getThread($callback) {
		if (! function_exists('pcntl_fork')) {
			return new Threadi_Thread_NonThread($callback);
		}
		return new Threadi_Thread_PHPThread($callback);
	}

	/**
	 * Get returnable thread
	 *
	 * @param callback $callback
	 * @return Threadi_Thread_ReturnableThreadInterface
	 */
	public static function getReturnableThread($callback) {
		if (function_exists('pcntl_fork') && function_exists('shmop_open')) {
			$thread = new Threadi_Thread_PHPReturnableThread($callback);
			$thread->setCommunication(new Threadi_Communication_SharedMemory());
			return $thread;
		}
		return new Threadi_Thread_NonThread($callback);
	}
}
