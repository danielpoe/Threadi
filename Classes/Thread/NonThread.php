<?php


/**
 * A Implementation of a Thread that can be used if PCNTL is not available, 
 * it does no forking at all - but executes the callback
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_Thread_NonThread extends Threadi_Thread_AbstractThread implements Threadi_Thread_ReturnableThreadInterface {
	
	/**
	 * @var mixed
	 */
	private $result;
	
    /**
     * checks if the child thread is alive
     *
     * @return boolean
     */
    public function isAlive() {
    	return false;
    }
 
    /**
     * starts the thread, all the parameters are 
     * passed to the callback function
     * 
     * @return void
     */
    public function start() {
    	 $arguments = func_get_args();
         $this->result = $this->executeCallback($this->callback, func_get_args());
    }
 
    /**
     * attempts to stop the thread
     * returns true on success and false otherwise
     *
     * @param integer $signal - SIGKILL/SIGTERM
     * @param boolean $wait
     */
    public function stop( $signal = SIGKILL, $wait = false ) {
    	return;
    }
    
    /**
     * @return void
     */
    public function waitTillFinished() {
    	return;
    }
 	
    /**
	 * Get the result of the thread - only callable if the thread is finished
	 * @return mixed
	 */
	public function getResult() {
		return $result;
	}
}



