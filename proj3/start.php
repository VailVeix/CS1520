<!DOCTYPE html>
<html>

<?php
	session_start();	

?>

<script type = "text/javascript">

var word = "";
var guess = -1;
var next_word = "";
var username = '<?php echo $_SESSION['username']?>';

var timer;
var count = 0;

var roundstart = 0;

function createTable(){

	if(roundstart == 1){
		loser();
	}

	guess = 0;
	word = "";
	roundstart = 1;

	clearTable();

	if (window.XMLHttpRequest) { 
        httpRequest = new XMLHttpRequest();

        if (httpRequest.overrideMimeType) {
            httpRequest.overrideMimeType('text/xml');
        }
    }
    else if (window.ActiveXObject) { 
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }

        catch (e) {
            try {
                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {}
        }
    }

    if(!httpRequest){
    	alert("FAILED");
    	return false;
    }

    httpRequest.open('POST', 'lingogame.php', true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    httpRequest.onreadystatechange = function() {setWord(httpRequest);};
    httpRequest.send();

}

function clearTable(){
	var table = document.getElementById("gameTable");

	for(var i = 0; i < 5; i++){
		var row = table.rows[i];
		for(var j = 0; j < 5; j++){
			var cell = row.cells[j];

			cell.innerHTML = "&nbsp";
			cell.style.color = "black";
		}
	}

	var response = document.getElementById("response");

	response.innerHTML = "";
}


function setWord(httpRequest){

	if (httpRequest.readyState == 4){
        if (httpRequest.status == 200){

       		word = httpRequest.responseText;

       		var letter = word.charAt(0);
			letter = letter.toUpperCase();

			var table = document.getElementById("gameTable");
			var row = table.rows[0];
			var cell1 = row.cells[0];

			cell1.innerHTML = letter;
			cell1.style.color = "red";

			startTimer();
           
        }
        else{   
        	alert('Problem with request'); 

        }
   }

}

function startTimer(){
	timer = setInterval(function(){
		if(count == 15){
			stopTimer();
		}
		count++;
		var c = document.getElementById("timer");
		c.innerHTML = count;
	}, 1000);
}

function stopTimer(){

	clearInterval(timer);
	count = 0;
	var c = document.getElementById("timer");
	c.innerHTML = count;

	var table = document.getElementById("gameTable");
	var row = table.rows[guess];
	for(var i = 0; i < 5; i++){
		if(guess == 0 && i == 0){

		}
		else{
			var cell = row.cells[i];

			cell.innerHTML = "?";
			cell.style.color = "green";
		}
	}

	guess++;

	if(guess == 5){
		loser();
	}
	else{
		startTimer();
	}

}

function resetTimer(){
	clearInterval(timer);
	count = 0;
	var c = document.getElementById("timer");
	c.innerHTML = count;

	startTimer();
}

function endGame(){

	clearInterval(timer);
	count = 0;
	var c = document.getElementById("timer");
	c.innerHTML = count;

	if (window.XMLHttpRequest) { 
        httpRequest = new XMLHttpRequest();

        if (httpRequest.overrideMimeType) {
            httpRequest.overrideMimeType('text/xml');
        }
    }
    else if (window.ActiveXObject) { 
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }

        catch (e) {
            try {
                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {}
        }
    }

    if(!httpRequest){
    	alert("FAILED");
    	return false;
    }

    var ans = arguments[0];

    var data = 'type=' + ans + '&username=' + username;

    httpRequest.open('POST', 'finshgame.php', true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    httpRequest.onreadystatechange = function() {results(httpRequest);};
    httpRequest.send(data);

}

function results(httpRequest){


	if (httpRequest.readyState == 4){
        if (httpRequest.status == 200){

        	var ans = httpRequest.responseText;
        	var result = ans.split("|");

        	var rounds = result[0];
        	var wins = result[1];        	

        	var winpercent = wins/rounds;
        	winpercent *= 100;
        	winpercent = Math.round(winpercent);

        	var output = "You have won " + wins + " games out of " + rounds + " total rounds. Your win percentage is " + winpercent + "%.";
        	alert(output);
        }
        else{   
        	alert('Problem with request'); 

        }
   }

}

function winner(){

	roundstart = 0;

	var response = document.getElementById("response");

	response.innerHTML = "<br/><h3>Congratulations! You have won!</br> Click Get New Word to play again!</h3>";

	endGame(0);

}

function loser(){

	roundstart = 0;

	var response = document.getElementById("response");
	response.innerHTML = "<br/><h3>Awww You lost :(</br> The word was " + word + ". Click Get New Word to play again?</h3>";
	
	endGame(1);
}

function process(){

	if(roundstart == 0){
		return;
	}

	resetTimer();

	var gues = document.game.guess.value;

	if(guess < 5){

		gues = gues.toUpperCase();
		word = word.toUpperCase();

		var let;

		var table = document.getElementById("gameTable");
		var row; var cell1;

		var store_a = new Array();
		var store_b = new Array();

		for(var i = 0; i < 5; i++){
			store_a[i] = 1;
			store_b[i] = 1;
		}

		for(var i = 0; i < 5; i++){
			if(gues.charAt(i) == word.charAt(i)){
				let = word.charAt(i);
				let = let.toUpperCase();

				table.rows[guess].cells[i].innerHTML = let;
				table.rows[guess].cells[i].style.color = "red";

				store_a[i] = -1;
				store_b[i] = 0;
			}
		}

		found = true;
		for(var i = 0; i < 5; i++){
			if(store_a[i] != -1){
				found = false;
				i = 6;
			}
		}

		if(found){
			winner();
		}
		else{

			for(var i = 0; i < 5; i++){
				if(store_a[i] == 1){
					found = false;

					for(var j = 0; j < 5; j++){
						if(store_b[j] == 1){

							if(gues.charAt(i) == word.charAt(j)){
								let = gues.charAt(i);
								let = let.toUpperCase();

								table.rows[guess].cells[i].innerHTML = let;
								table.rows[guess].cells[i].style.color = "blue";

								store_b[j] = 0;
								j = 6;
								found = true;
							}
						}
					
					}

					if(!found){
						let = gues.charAt(i);
						let = let.toLowerCase();

						table.rows[guess].cells[i].innerHTML = let;
						table.rows[guess].cells[i].style.color = "black";
					}
				}

			}

			guess++;

			if(guess == 5){
				loser();
			}
		}
	}
	else{
		loser();
	}

	document.game.guess.value = "";

	return false;

}	

</script>

<body>

<title> Game Time </title>
<div align="center">
<h1>Lingo!</h1>

<form name = "game" onsubmit = "return process();">
	<table id = "gameTable" border = "1" cellpadding = "25">

		<button type='button' onclick='createTable()'>Get New Word</button>

	</br></br>
	Enter Guess Here: <input type = "text" name = "guess" value = "">
	<input type = "button" value = "Guess" onclick = 'process()'>
	</br>Time to guess: <div id = "timer">0</div>


	<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
	<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
	<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
	<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
	<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
	</table>

	<div id = "response"></div>

</br></br></br>
<?php
	echo "<div align = 'right'>";
	echo "<div id = 'username'>" . $_SESSION['username'];
	echo ", would you like to quit?</br>";
	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign3/logout.php'>Log Out?</a>";

?>

</form>

</body>
</html>
