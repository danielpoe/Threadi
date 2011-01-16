<?php


/**
 * 
 * @author Daniel Pötzinger
 *
 */
interface Threadi_Thread_ReturnableThreadInterface extends Threadi_Thread_ThreadInterface {
	
	/**
	 * Get the result of the thread - only callable if the thread is finished
	 * @return mixed
	 */
	public function getResult();
}







