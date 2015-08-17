<?php

include_once( 'messages.class.php' );

/**
 * Class in charge to create the canvas and handle all actions over it.
 * @package default
 */

class canvas{

	//Class Attributes
	private $canvas       = array();
	private $canvas_ready = false;
	private $message      = null;

	/**
	 * Constructor of the class, this initialize the canvas structure with 2-dimensional array
	 * @param int $width 
	 * @param int $height 
	 * @param boolean $reset 
	 * @return void
	 */
	public function __construct( $width = 0, $height = 0, $reset = false ){
		$this->message = new messages();
		if( $reset ){
			$this->message->set_message( 'general-ok-0' );
		}
		elseif( $width > 1 && $width <= 100 && $height > 1 && $height <= 20 ){
			for( $f=0; $f < $height+2; $f++ ){
				$column = array();
				for( $c=0; $c < $width+2; $c++ ){
					$column[$c] = '';
				}
				$this->canvas[$f] = $column;
			}
			$this->fill_canvas();
			$this->message->set_message( 'general-ok-0' );
		}
		else{
			$this->message->set_message( 'canvas-error-0' );
		}
	}

	/**
	 * This function is in charge to fill the boundaries of the canvas and put blank spaces in
	 * the content. When it has finished the attribute $canvas_ready is set to true.
	 * @return boolean
	 */
	private function fill_canvas(){
		for( $i=0; $i<count($this->canvas); $i++ ){
			for( $j=0; $j<count($this->canvas[$i]); $j++ ){

				if( $i == 0 || $i == (count($this->canvas)-1) ){
					$this->canvas[$i][$j] = '-';
				}
				elseif( ( $i > 0 && $j==0 ) || ( $j == count($this->canvas[$i])-1 ) ){
					$this->canvas[$i][$j] = '|';	
				}
				else{
					$this->canvas[$i][$j] = ' ';
				}
			}
		}
		$this->canvas_ready = true;
		return true;
	}

	/**
	 * This function is in charge of convert 2-dimensional array to its string representation.
	 * @return string
	 */
	public function get_canvas_string( $init_message = false ){
		$canvas_printed = '';
		for( $i=0; $i<count($this->canvas); $i++ ){
			for( $j=0; $j<count($this->canvas[$i]); $j++ ){

				if ( $j == ( count($this->canvas[$i])-1 ) ) {
					$canvas_printed .=  $this->canvas[$i][$j] . '<br />';
				}
				else{
					$canvas_printed .= $this->canvas[$i][$j];
				}
			}
		}

		$canvas_printed = substr($canvas_printed, 0, -6);

		return !$init_message?$canvas_printed.'<br/>'.$this->message->get_current_message():$this->message->get_init_message().'<br/>Command OK';
	}

	/**
	 * From an string canvas representation, it is converted to a 2-dimensional array ( get_canvas_string inverse method )
	 * @param string $canvas_string 
	 * @return boolean
	 */
	public function parse_canvas_string_to_array( $canvas_string = '' ){

		if( $canvas_string ){
			$files_canvas = explode('<br />', $canvas_string);
			for($i=0;$i<count($files_canvas); $i++){
				$this->canvas[$i] = str_split( $files_canvas[$i] );
			}
			$this->canvas_ready = true;
		}
		
		return true;
	}

	/**
	 * Returns the value saved in the position given for the point $p given as argument of the method.
	 * @param Array $p 
	 * @return string
	 */
	private function get_point( $p = array() ){
		return $this->canvas[$p[1]][$p[0]];
	}

	/**
	 * This method is in charge of assign a value inside of a position of the data structure representation 
	 * of canvas.
	 * @param Array $p 
	 * @param string $char 
	 * @return boolean
	 */
	private function draw_point( $p = array(), $char = 'x' ){

		if( isset( $this->canvas[$p[1]][$p[0]] ) && !in_array( $this->canvas[$p[1]][$p[0]], array( '|', '-' ) ) ){
			$this->canvas[$p[1]][$p[0]] = $char[0];
			return true;
		}
		else
			return true;
	}

	/**
	 * This method is in charge to draw a arrangement of points that represents a line inside of the canvas.
	 * @param Array $pinit 
	 * @param Array $pend 
	 * @return boolean
	 */
	public function draw_line( $pinit = array(), $pend = array() ){
		$this->message = new messages();
		if( !$this->canvas_ready ){
			$this->message->set_message( 'line-error-1' );
			return false;
		}
		//horizontal line
		elseif( $pinit[0] != $pend[0] && $pinit[1] == $pend[1] ){
			for( $i = ($pinit[0]); $i <= $pend[0]; $i++ ){

				$this->draw_point( array( $i, $pinit[1] ) );
			}
			$this->message->set_message( 'general-ok-0' );
			return true;
		}
		//vertical line
		elseif ( $pinit[0] == $pend[0] && $pinit[1] != $pend[1] ) {
			for( $i = ($pinit[1]); $i <= $pend[1]; $i++ ){

				$this->draw_point( array( $pinit[0], $i ) );
			}
			$this->message->set_message( 'general-ok-0' );
			return true;
		}
		else{
			$this->message->set_message( 'line-error-0' );
			return false;
		}
		
	}

	/**
	 * This method is in charge of draw four lines that represents the sides of a rectangle.
	 * This is done from the 2 points given as arguments of the method.
	 * @param Array $pinit 
	 * @param Array $pend 
	 * @return boolean
	 */
	public function draw_rectangle( $pinit = array(), $pend = array() ){
		$this->message = new messages();
		//the points given are the same point
		if( $pinit == $pend ){
			$this->draw_point( $pinit );
			$this->message->set_message('general-ok-0');
			return true;
		}
		//the points given are a line, they are not a rectangle
		elseif( $pinit[0] == $pend[0] || $pinit[1] == $pend[1] ){
			$this->draw_line( $pinit, $pend );
			$this->message->set_message('general-ok-0');
			return true;
		}
		//rectangle
		else{
			$this->draw_line( $pinit, array( $pend[0], $pinit[1] ) );
			$this->draw_line( array( $pend[0], $pinit[1] ), $pend );
			$this->draw_line( array( $pinit[0], $pend[1] ), $pend );
			$this->draw_line( $pinit, array( $pinit[0], $pend[1] ) );
			$this->message->set_message('general-ok-0');
			return true;
		}
	}

	/**
	 * This set of methods is in charge of fill the area around the point represented by the argument $init.
	 * The area will be filled with the argument $char. 
	 * All the recursive process is resolved with the next functions fill_r (fill the point to the right), 
	 * fill_l (fill the point left), fill_u (fill the point up) and fill_d (fill the point down), 
	 * all those functions are necessary to finish the process.
	 * @param Array $init 
	 * @param string $char 
	 * @return boolean
	 */
	public function bucket_fill( $init = array(), $char = '' ){
		$this->message = new messages();
		if( !in_array( $this->get_point( $init ), array( '|', '-', 'x', $char[0] ) ) ){
			$this->draw_point( $init, $char );	
			$this->fill_r( array( $init[0]+1, $init[1] ), $char );
			$this->fill_l( array( $init[0]-1, $init[1] ), $char );
			$this->fill_u( array( $init[0], $init[1]-1 ), $char );
			$this->fill_d( array( $init[0], $init[1]+1 ), $char );
		}
		$this->message->set_message('general-ok-0');
		return true;	
	}

	private function fill_r( $init = array(), $char = '' ){
		return $this->bucket_fill( $init, $char );
	}

	private function fill_l( $init = array(), $char = '' ){
		return $this->bucket_fill( $init, $char );
	}

	private function fill_u( $init = array(), $char = '' ){
		return $this->bucket_fill( $init, $char );
	}

	private function fill_d( $init = array(), $char = '' ){
		return $this->bucket_fill( $init, $char );
	}

	/** End recursiveness **/
}

