<?php


/**
 * Cross Process Communication Object
 * 
 * @author Daniel Pötzinger
 *
 */
interface Threadi_Communication_CommunicationInterface {
	
	public function set($key,$value);
	public function get($key);
	public function close();
}



