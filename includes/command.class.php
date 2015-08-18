<?php

include_once( 'messages.class.php' );
include_once( 'canvas.class.php' );


/**
 * Command is a class in charge to handle the commands given through the input form.
 * @package default
 */

class command{

	//Class Attributes
	private $values_ok = true;
	private $command_array = array();
	private $canvas = null;

	/**
	 * Constructor of the class is in charge of the initialize the attribute $values_ok if the command structure
	 * is fine.
	 * @param Array $command 
	 * @return void
	 */
	public function __construct( $command = array(), $canvas_string = '' ){
		if(!empty($command)){
			for( $i=1; $i<count($command); $i++ ){
				if( !$command[$i] || ( is_numeric( preg_replace('/\D/', '', $command[$i]) ) && $command[$i] < 0 ) ){
					$this->values_ok = false;
					break;
				}
			}
			$this->command_array = $command;
			//Obj to handle canvas data structure
			$this->canvas = new canvas();
			$this->canvas->parse_canvas_string_to_array( $canvas_string );
		}
	}	

	/**
	 * This method process the command given by the user and call the right action to be applied.
	 * @param Array $command 
	 * @param string $canvas_string 
	 * @return string
	 */
	public function process_command(){

		//Obj to handle messages
		$messages = new messages();

		if( $this->values_ok ){

			switch ( strtoupper($this->command_array[0]) ){
				//Create a Canvas
				case 'C':
					if( count($this->command_array) == 3 ){
						$command = $this->command_array;
						$this->canvas = new canvas($command[1], $command[2]);
						$messages->set_message( 'general-ok-0' );
					}
					else{
						$messages->set_message( 'general-error-0' );
						$messages->is_reload();
					}
					break;

				//Print a Line
				case 'L':
					if( !$this->canvas->get_canvas_state() ){
						$messages->set_message( 'line-error-1' );
					}
					elseif( count($this->command_array) == 5 ){
						$command = $this->command_array;
						$this->canvas->draw_line( array( $command[1], $command[2] ), array( $command[3], $command[4] ), $messages );
						$messages->set_message( 'general-ok-0' );
					}
					else{
						$messages->set_message( 'general-error-0' );
					}
					break;

				//Print a Rectangle
				case 'R':
					if( !$this->canvas->get_canvas_state() ){
						$messages->set_message( 'rec-error-0' );
					}
					elseif( count($this->command_array) == 5 ){
						$command = $this->command_array;
						$this->canvas->draw_rectangle( array( $command[1], $command[2] ), array( $command[3], $command[4] ) );
						$messages->set_message( 'general-ok-0' );
					}
					else{
						$messages->set_message( 'general-error-0' );
					}
					break;

				//Bucket fill action
				case 'B':
					if( !$this->canvas->get_canvas_state() ){
						$messages->set_message( 'line-error-1' );
					}
					elseif( count($this->command_array) == 4 ){
						$command = $this->command_array;
						$this->canvas->bucket_fill( array( $command[1], $command[2] ), $command[3] );
						$messages->set_message( 'general-ok-0' );
					}
					else
						$messages->set_message( 'general-error-0' );
					break;

				//Restart the app
				case 'Q':
					$messages->set_message( 'general-ok-0' );
					$messages->is_reload();
					break;
				
				default:
					;
					break;
			}
		}
		else
			return false;
		
		return $this->canvas->get_canvas_string($messages).'<br/>'.$messages->get_current_message();
	}
}

if( isset($_GET['command']) ){
	//Initialization of the object with the params given by the ajax call (GET).
	$obj_command = new command( explode(' ', trim(preg_replace('/\s+/',' ', $_GET['command']))), $_GET['canvas'] );
	echo $obj_command->process_command();
}