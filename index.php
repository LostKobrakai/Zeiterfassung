<?php
	mail("trigger@ifttt.com", "#timer", $_POST["title"]." ||| ".$_POST["time"]." ||| ".date("d.m.Y") , "From: Benjamin Milde <benni@kobrakai.de>", "-f benni@kobrakai.de");
?>
<!doctype html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Zeitmessung</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="google.js"></script>
</head>
<body>
	<form id="timer" name="timer" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input name="title" id="title" type="text" value="" required><input name="send" id="send" type="button" value="+"><br>
		<input name="time" id="time" class="time" type="time" step="1" value="00:00:00" required readonly>
		<input name="startcounter" id="start" type="button" value="start">
		<input name="stopcounter" id="stop" type="button" value="stop">
		<input type="submit" name="submit" id="submit" value="send">
	</form>
	<script type="text/javascript">
		//Variables
		var start = document.timer.startcounter;
		var stop = document.timer.stopcounter;
		var send = document.timer.send;
		var time = document.timer.time;
		var counter = null;

		//Event Listener
		//Start Counter
		start.addEventListener("click", startcounter);
		function startcounter(e){
			if(counter !== null){
				return;
			}else{
				date = new Date();
				if(time.value != "00:00:00"){
					date.setTime(date.getTime() - time.value);
				}
				count(date);
				stop.value = "stop";
			}
		}

		//Stop Counter/Reset Counter
		stop.addEventListener("click", stopcounter);
		function stopcounter(e){
			if(counter === null){
				time.value = "00:00:00";
				stop.value = "stop";
			}else{
				clearTimeout(counter);
				counter = null;
				stop.value = "reset";
			}
		}

		//Submit Form
		send.addEventListener("click", senddata);
		function senddata(e){
			if(counter !== null){
				stopcounter(e);
			}
			document.forms.timer.submit.click();
		}

		//Zähler
		function count(date){
			var newDate = new Date();
			var dif = newDate.getTime() - date.getTime();
			dif = Math.floor(dif/1000);
			var h = Math.floor(dif/3600);
			var m = Math.floor(dif%3600/60);
			var s = (dif%3600)%60;
			time.value = zero(h) + ":" + zero(m) + ":" + zero(s);
			counter = window.setTimeout(function() {
			  count(date);
			}, 100);
		}

		function zero(number){
			if(number < 10) return "0" + number;
			else return number;
		}
	</script>
</body>
</html>