$(document).ready(function(){
	$('#command-console').submit(function(event){
		event.preventDefault();

		if( $('input#command').val() != '' ){
			//Ajax call
			$.ajax({
				method: "GET",
				url: "includes/command.class.php",
				data: { 
					command: $('input#command').val(),
					canvas: $('input#canvas').val()
				}
			}).done(function(msg){
				//process the result and assign values to the form
				var result = msg.split('<br/>');
				var canvas = result[0];
				var message = result[1];

				$('div#wrapper pre').html( canvas );
				$('input#canvas').attr('value', canvas);
				$('#content-messages pre').html(message);
				$('#command').val('');
			});
		}
		else{
			$('#content-messages pre').html('Please, write a command first');
		}

		return false;
	});
});