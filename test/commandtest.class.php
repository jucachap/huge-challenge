<?php

/**
 * Class to test the methods of the class command
 * @package default
 */
class commandtest extends PHPUnit_Framework_TestCase{

	public function test_instance_of_commands(){
		//No params
		$co = new command();
		$this->assertInstanceOf(command::class, $co);

		//With params
		$co2 = new command( array( 'C', '20', '4' ) );
		$this->assertInstanceOf(command::class, $co2);
	}

	public function test_process_command(){
		$co = new command( array( 'C', '20', '4' ) );

		//create a canvas
		$result = $co->process_command();
		$this->assertSame( $result, $co->process_command() );

		//draw a line
		$result = $co->process_command(array('L', '1', '2', '6', '2'));
		$this->assertSame( $result, $co->process_command(array('L', '1', '2', '6', '2')) );

		//draw a rectangle
		$result = $co->process_command(array('R', '1', '1', '6', '4'));
		$this->assertSame( $result, $co->process_command(array('L', '1', '2', '6', '2')) );
	}
}