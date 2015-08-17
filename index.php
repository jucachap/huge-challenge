<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="assets/functions.js"></script>

		<title>The Huge Challenge</title>

		<link rel="stylesheet" href="http://www.jucachap.com/sites/default/files/css/css_06ucrmQH8xOSf5rxOqm-vN1ppC55o3tMjREava5fUpk.css?0" media="all" />
		<link rel="stylesheet" href="http://www.jucachap.com/sites/default/files/css/css_HG3zzCQWU_SgW-2fcU1aJNt2ZJ0xRhQWtQvjJfSZSNQ.css?0" media="all" />
		<link rel="stylesheet" href="http://www.jucachap.com/sites/default/files/css/css_sSnwnI3tugaLnfsOJ4_gVeKo8SCuCKqgNmFr6r7ONmQ.css?0" media="all" />
		<link rel="stylesheet" href="http://www.jucachap.com/sites/default/files/css/css_YiW-PmA33BohBVoHyX9Cz44pIfjHiMaNI08crl8mfbY.css?0" media="print" />

    
	</head>
	<body>
		<div id="main">
			<h1>Huge Challenge</h1>
			<div id="wrapper">
				<header></header>
				<main id="content">
					<section>
						<label>Results:</label>
						<pre>
Quick help:
C N N :		Command C creates a canvas of NxN
L N N M M :	Command L draws a line from point (N,N) until (M,M) inside of canvas
R N N M M :	Command R draws a rectangle from point (N,N) until (M,M) inside of canvas
B N N char:	Command B fills the space arround point (N,N) with character char</pre>
					</section>

					<section>
						<form id="command-console" method="GET" action="index.php">
							<label for="command">Write your command here:<label><br />
							<input id="command" type="text" name="command" size="50" value="" autocomplete="off" />

							<input id="canvas" type="hidden" name="canvas" value="" />
							<input id="bsend" type="submit" name="SEND" value="SEND" />
						</form>
					</section>

					<section>
						<div id="content-messages">
							<label>Result Messages:</label>
							<pre></pre>
						</div>
					</section>
				</main>
				<footer></footer>
			</div>
		</div>
	</body>
</html>
