<?php

class Model_StatsTest extends ControllerTestCase
{
	protected $stats;
	public function setUp()
	{
		parent::setUp();
		$this->stats = new Model_Stats();
	}
	
	public function testCanDoUnitTest()
	{
		$this->assertTrue(true);
	}
	
	
}