<?php


/**
 * Thread Class based on the implementation http://blog.motane.lu/2009/01/02/multithreading-in-php/
 * from Tudor Barbu 
 * 
 * @author Daniel Pötzinger
 *
 */
class Threadi_Thread_PHPReturnableThread extends Threadi_Thread_PHPThread implements Threadi_Thread_ReturnableThreadInterface {
	
	/**
	 * @var Threadi_Communication_CommunicationInterface
	 */
	private $communication;
	
	/**
	 * @param Threadi_Communication_CommunicationInterface $communication
	 */
	public function setCommunication(Threadi_Communication_CommunicationInterface $communication) {
		$this->communication = $communication;
	}
	
	/**
     * starts the thread, all the parameters are 
     * passed to the callback function
     * 
     * @return void
     */
    public function start() { 
    	if (!isset($this->communication)) {
    		throw new Exception('There is no communication object set');
    	}   	
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
            $this->communication->set('result',$this->executeCallback($this->callback, func_get_args()));
            exit( 0 );
        }
    }
    
	/**
	 * Get the result of the thread - only callable if the thread is finished
	 * @return mixed
	 */
	public function getResult() {
		if ($this->isAlive()) {
			throw new Exception('Not ready yet');
		}
		return $this->communication->get('result');
	}
	
	public function __destruct() {
		if ($this->inParentThread()) {
			$this->communication->close();
		}
	}
	
	private function inParentThread() {
		return false;
	}
}



