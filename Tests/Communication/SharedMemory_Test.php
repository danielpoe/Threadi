<?php
require_once dirname(__FILE__) . '/../../Loader.php';

/**
 * Threadi_Communication_SharedMemory test case.
 */
class Threadi_Communication_SharedMemory_Test extends PHPUnit_Framework_TestCase {

	/**
	 * @var Threadi_Communication_SharedMemory
	 */
	private $communication;

	public function setUp() {
		$this->communication = new Threadi_Communication_SharedMemory();
	}

	/**
	 * @test
	 */
	public function canGetAndSet() {
		$fixtureString = 'my string';
		$fixtureArray = array('1' => 'one');
		$this->communication->set('string', $fixtureString);
		$this->assertEquals($fixtureString, $this->communication->get('string'));
		$this->communication->set('array', $fixtureArray);
		$this->assertEquals($fixtureArray, $this->communication->get('array'));
		$this->assertEquals($fixtureString, $this->communication->get('string'));
	}
}