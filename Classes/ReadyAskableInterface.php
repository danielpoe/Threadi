<?php


/**
 * Interface that defines classes that can be ask for readyness
 * 
 * @author Daniel Pötzinger
 *
 */
interface Threadi_ReadyAskableInterface {
	/**
	 * @return boolean
	 */
	public function isReady();
	/**
	 * @return void;
	 */
	public function waitTillReady();
}



