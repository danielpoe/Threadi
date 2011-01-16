<?php


/**
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_Thread_AbstractThread  {
	
	/**
	 * @var mixed (string or array)
	 */
	protected $callback;
	
	/**
	 * @var integer
	 */
	protected $threadId;
	
	/**
	 * @var booleam
	 */
	protected $started = FALSE;
	
	/**
	 * @param mixed $callback
	 */
	public function __construct($callback = NULL) {		
		if (!$this->isValidCallback($callback)) {
			throw new Exception('No valid callback given');
		}
		$this->callback = $callback;
		$this->parentId = getmypid();
	}
	
 	/** 
     * @return int
     */
    public function getThreadId() {
    	$this->requireStart();
        return $this->threadId;
    }
 	
	/**
     * @return void
     */
    public function isReady() {
    	return $this->isAlive();   	 
    }
    
    /**
	 * 
	 * @param mixed $callback
	 * @return boolen
	 */
	protected function isValidCallback($callback) {
		return is_callable( $callback );
	}
	
	/**
	 * Checks if thread was started - if not throw exception
	 * (needs call from parent)
	 */
	protected function requireStart() {
		if (!$this->started) {
			throw new Exception('Thread was not started yet!');
		}
	}
	/**
	 * Calls the callable
	 * @param callable $callback
	 * @param array $arguments
	 * @return mixed the result
	 */
	protected function executeCallback($callback, $arguments = NULL) {
		if ( !empty( $arguments ) ) {
              return call_user_func_array( $callback, $arguments );
        }
        else {
              return call_user_func($callback );
        } 
	}
 
}



