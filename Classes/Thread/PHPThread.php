<?php


/**
 * Thread Class based on the implementation http://blog.motane.lu/2009/01/02/multithreading-in-php/
 * from Tudor Barbu 
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_Thread_PHPThread extends Threadi_Thread_AbstractThread implements Threadi_Thread_ThreadInterface {
	
	
	
	/**
	 * @var integer
	 */
	protected $parentId;

	/**
	 * @param mixed $callback
	 */
	public function __construct($callback = NULL) {
		if (! function_exists('pcntl_fork')) throw new Exception('PCNTL functions not available on this PHP installation');		
		
		if (!$this->isValidCallback($callback)) {
			throw new Exception('No valid callback given');
		}
		$this->callback = $callback;
		$this->parentId = getmypid();
	}
	
 	
 
    /**
     * checks if the child thread is alive
     *
     * @return boolean
     */
    public function isAlive() {
    	$this->requireStart();
        $pid = pcntl_waitpid( $this->threadId, $status, WNOHANG );
        return ( $pid === 0 );
 
    }
 
    /**
     * starts the thread, all the parameters are 
     * passed to the callback function
     * 
     * @return void
     */
    public function start() {    	
        $id = pcntl_fork();
        if( $id == -1 ) {
            throw new Exception( 'Forke was not possible' );
        }
        if( $id ) {
            // parent thread gets child id
            $this->threadId = $id;
            $this->started = TRUE;
            return $this->threadId;
        }
        else {
            // child process
            // 1 register callback for kill
            pcntl_signal( SIGTERM, array( $this, 'signalHandler' ) );
            $this->executeCallback($this->callback, func_get_args());
            exit( 0 );
        }
    }
 
    /**
     * attempts to stop the thread
     * returns true on success and false otherwise
     *
     * @param integer $signal - SIGKILL/SIGTERM
     * @param boolean $wait
     */
    public function stop( $signal = SIGKILL, $wait = false ) {
    	$this->requireStart();
        if( $this->isAlive() ) {
            posix_kill( $this->threadId, $signal );
            if( $wait ) {
                $this->waitTillReady();
            }
        }
    }
    
    
    /**
     * @return void
     */
    public function waitTillReady() {
    	$this->requireStart();
    	$status = 0;
    	pcntl_waitpid( $this->threadId, $status );   	 
    }
 
    /**
     * signal handler
     *
     * @param integer $_signal
     */
    protected function signalHandler( $signal ) {
        switch( $signal ) {
            case SIGTERM:
                exit( 0 );
            break;
        }
    }
    
    private function cleanup() {
    	shmop_delete ($this->memoryId);
    	shmop_close ($this->memoryId);
    }
	
	
	
}



