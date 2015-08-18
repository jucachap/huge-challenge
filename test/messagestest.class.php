<?php

/**
 * Test class for the messages interactions
 * @package default
 */

class messagestest extends PHPUnit_Framework_TestCase{


	public function test_set_message(){
		$m = new messages();

		//message is required as argument
		$this->assertFalse( $m->set_message() );
		//message is required as argument
		$this->assertTrue( $m->set_message('general-ok-0') );
		$this->assertFalse( $m->set_message('a') );
	}

	public function test_get_init_message(){
		$m = new messages();
		//returns init message
		$this->assertSame( $m->get_init_message(), $m->get_init_message() );		
	}

	public function test_get_current_message(){
		$m = new messages();
		//No message has been set
		$this->assertEquals( '', $m->get_current_message() );
		//Set a message and check if it's ok
		$m->set_message('general-ok-0');
		$this->assertEquals( 'Command OK', $m->get_current_message() );
	}


}