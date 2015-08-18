<?php

/**
 * Class test for the canvas data structure
 * @package default
 */

class canvastest extends PHPUnit_Framework_TestCase{


	public function test_instance_of_canvas(){

		//no params
		$c = new canvas();
		$this->assertInstanceOf(canvas::class, $c);

		//with params width, height
		$c2 = new canvas(10,10);
		$this->assertInstanceOf(canvas::class, $c2);

		//with params width, height and reset
		$c3 = new canvas(20,10,true);
		$this->assertInstanceOf(canvas::class, $c3);

		return true;
	}

	public function test_get_canvas_string(){
		//creates a canvas without params to initialize
		$c = new canvas();
		//$this->assertEquals('<br/>Command Error : Size of canvas cannot be less than 1 x 1 or greater than 100 x 20', $c->get_canvas_string());
		$this->assertFalse($c->get_canvas_string());

		$messageinit = $c->get_canvas_string(true);
		$this->assertSame( $messageinit, $c->get_canvas_string(true));

		//canvas with params
		$c2 = new canvas(10,10);
		$canvasstring = $c2->get_canvas_string();
		$this->assertSame($canvasstring, $c2->get_canvas_string());

		return true;
	}

	public function test_parse_canvas_string_to_array(){

		$c = new canvas();
		$this->assertFalse($c->parse_canvas_string_to_array());
		$this->assertFalse($c->parse_canvas_string_to_array('aaaa'));
		$this->assertTrue($c->parse_canvas_string_to_array('aaaa<br />aaaa'));

		$c2 = new canvas(4,4);
		$canvas_string = $c2->get_canvas_string();

		$c3 = new canvas(4,4);
		$this->assertTrue($c3->parse_canvas_string_to_array($canvas_string));
	}

	public function test_draw_line(){
		$c = new canvas();
		$this->assertFalse($c->draw_line());

		$c2 = new canvas(20,4);
		//draw a point (False)
		$this->assertFalse($c->draw_line( array(1,1), array(1,1) ));
		//horizontal line (True)
		$this->assertTrue($c2->draw_line( array(1,2), array(6,2) ));
		//vertical line (True)
		$this->assertTrue($c2->draw_line( array(6,3), array(6,4) ));
		//try to draw a rectangle (False)
		$this->assertFalse($c2->draw_line( array(1,2), array(6,4) ));
	}

	public function test_draw_rectangle(){
		$c = new canvas(20,4);
		//draw a point
		$this->assertTrue($c->draw_rectangle( array(1,1), array(1,1) ));
		//draw a line
		$this->assertTrue($c->draw_rectangle( array(1,2), array(6,2) ));
		//draw a rectangle
		$this->assertTrue($c->draw_rectangle( array(16,1), array(20,3) ));
	}

	public function test_bucket_fill(){
		$c = new canvas(4,4);
		//use the tool bucket-fill to fill all area arround the given point with the char passed as arg.
		$this->assertTrue($c->bucket_fill( array(1,1), 'c' ));
	}
}

