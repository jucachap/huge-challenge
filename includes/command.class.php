<?php

include_once( 'canvas.class.php' );

/**
 * Command is a class in charge to handle the commands given through the input form.
 * @package default
 */

class command{

	//Class Attributes
	private $values_ok = true;

	/**
	 * Constructor of the class is in charge of the initialize the attribute $values_ok if the command structure
	 * is fine.
	 * @param Array $command 
	 * @return void
	 */
	public function __construct( $command = array() ){

		for( $i=1; $i<count($command); $i++ ){
			if( !$command[$i] || ( is_numeric( $command[$i] ) && $command[$i] < 0 ) ){
				$this->values_ok = false;
				break;
			}
		}
	}	

	/**
	 * This method process the command given by the user and call the right action to be applied.
	 * @param Array $command 
	 * @param string $canvas_string 
	 * @return string
	 */
	public function process_command( $command = array(), $canvas_string = '' ){

		$restart = false;
		$canvas = new canvas();
		$canvas->parse_canvas_string_to_array( $canvas_string );

		if( $this->values_ok ){

			switch ( strtoupper($command[0]) ) {
				//Create a Canvas
				case 'C':
					if( count($command) == 3 )
						$canvas = new canvas($command[1], $command[2]);
					break;

				//Print a Line
				case 'L':
					if( count($command) == 5 ){
						$canvas->draw_line( array( $command[1], $command[2] ), array( $command[3], $command[4] ) );
					}
					break;

				//Print a Rectangle
				case 'R':
					if( count($command) == 5 ){
						$canvas->draw_rectangle( array( $command[1], $command[2] ), array( $command[3], $command[4] ) );
					}
					break;

				//Bucket fill action
				case 'B':
					if( count($command) == 4 ){
						$canvas->bucket_fill( array( $command[1], $command[2] ), $command[3] );
					}
					break;

				//Restart the app
				case 'Q':
					$restart = true;
					$canvas = new canvas(0,0,true);
					break;
				
				default:
					;
					break;
			}
		}

		return $canvas->get_canvas_string($restart);
	}
}
//Initialization of the object with the params given by the ajax call (GET).
$obj_command = new command( trim($_GET['command']) );
echo $obj_command->process_command( explode(' ', trim($_GET['command']) ), $_GET['canvas'] );

