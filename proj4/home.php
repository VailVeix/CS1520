<!DOCTYPE html>
<html>

<?php
	session_start();	

?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type = "text/javascript">

var username = '<?php echo $_SESSION['username']?>';
var gid;
var state;
var player_state;
var word;
var round = 1;
var length;
var curguess = "";
var wintotal;
var pastguess = "";
var incorrectguess = 7;
var inc = "";

$(document).ready(
    function() {
       $("div#response").hide();
       $("div#makerStuff").hide();
       $("div#guesserGame").hide();
       $("div#makerGame").hide();
       $("div#guesserWaiting").hide();
       $("div#startButton").show();
       $("div#logOut").show();
    }
);


// Connect to server and obtain a game id and which player we are.
// Are we waiting or can we start?
function connect(){
    //alert("Connecting");
    $("div#startButton").hide();
    var args = {"name":username};
	$.post("startgame.php", args, 
        function(data){
            var d = $(data).find("Data").text();
            //alert(d);

            state = $(data).find("Result").text();
            gid = $(data).find("Game_ID").text();
            player_state = $(data).find("P").text();

            //alert("First game id " + gid);

            if(state == "Waiting"){
                waiting();
            }
            else{
                ready();
            }

        }
    );
}

// Wait for a second player to join pls.
function waiting(){
    //alert("I'M WAITING");
    $("div#response").show();
    var args = {"gid":gid};
    $.post("waitingforplayer2.php", args, 
        function(data){
            var d = $(data).find("Data").text();
            //alert(d);

            state = $(data).find("Result").text();
            ready();
        }
    );
}

// Start game for each player
function ready(){
    $("#response").hide();
    //alert("I'm ready leggo");

    var change = document.getElementById("round");

    change.innerHTML = "Hangman - Round " + round;

    if(player_state == 1){
        alert("I'm Player 1");
        $("div#makerStuff").show();
    }
    else{
        alert("I'm Player 2");
        $("div#guesserWaiting").show();
        //alert("Game id " + gid);
        var args = {"gid":gid};
        $.post("guesserword.php", args, 
            function(data){
                var d = $(data).find("Data").text();
                //alert(d);

                var result = $(data).find("Result").text();
                //alert(result);

                length = $(data).find("Length").text();
                wintotal = length;
                //alert(length);

                $("div#guesserWaiting").hide();
                $("div#guesserGame").show();

                var line = "";

                var i;
                for(i = 0; i < length; i++){
                    //alert(line);
                    line = line.concat("_ ");
                    curguess = curguess.concat("_");
                }

                var w = document.getElementById("guesserword");
                w.innerHTML = line;

            }
        );
    }

}

// Show and process guessing section
function maker(){
    //alert("I'M THE MAKER HEAR ME ROAR");
    word = document.getElementById("word");
    word = word.value;
    word = word.toUpperCase();

    if(word.length < 3){
        alert("Enter a word with at least 3 letters.");
    }
    else{
        var args = {"word":word, "gid":gid};
        $.post("makerword.php", args, 
            function(data){
                var d = $(data).find("Data").text();
                //alert(d);

                var r = $(data).find("Result").text();
                //alert(r);

                $("div#makerStuff").hide();

                $("div#makerGame").show();

                length = word.length;
                //alert(length);

                var line = "";

                var i;
                for(i = 0; i < length; i++){
                    //alert(line);
                    line = line.concat("_ ");
                    curguess = curguess.concat("_");
                }

                var w = document.getElementById("makerword");
                w.innerHTML = line;

                makerUpdate();

            }
        );
    }
}

function makerUpdate(){
    //alert("UPDATE");

    var args = {"gid":gid};
    $.post("makerupdate.php", args, 
    	function(data){
    		var d = $(data).find("Data").text();
    		//alert(d);

    		var guess = $(data).find("Guess").text();
    		//alert(guess);
    		var inc = $(data).find("Inc").text();
    		//alert(inc);

    		var stat = $(data).find("Status").text();
    		alert(stat);

    		curguess = guess;
    		pastguess = inc;

    		var i;
    		var tempg = "";
    		for(i = 0; i < curguess.length; i++){
    			tempg = tempg.concat(curguess.charAt(i));
    			tempg = tempg.concat(" ");
    		}

    		var x = document.getElementById("makerword");
    		x.innerHTML = tempg;

    		//alert(tempg);

    		tempg = "";

    		//alert(inc);
    		//alert(inc.length);

    		for(i = 0; i < inc.length; i++){
    			tempg = tempg.concat(inc.charAt(i));
    			tempg = tempg.concat(". ");
    		}

    		var x = document.getElementById("makerincorrect");
    		x.innerHTML = tempg;

    		//alert(tempg);

    		if(stat == 2){
    			makerWinner();
    		}
    		else if(stat == 3){
    			makerLoser();
    		}
    		else{
    			makerUpdate();
    		}

    	}
    );

}


function guess(){
    //alert("Guessed!");
    //alert("Win total - " + wintotal);

    var g = document.getElementById("guess");

    g = g.value;
    g = g.toUpperCase();

    if(g.length > 1){
        alert("Enter one letter guesses only.");
    }
    else{
    	var i; 
    	var found = 0;
    	for(i = 0; i < pastguess.length; i++){
    		if(pastguess.charAt(i) == g){
    			alert("Already used that letter mate.");
    			found = 1;
    			break;
    		}
    	}

    	pastguess = pastguess.concat(g);

    	if(found == 0){
    		processGuess(g);
    	}

    }

}

function processGuess(var1){

	var g = var1;
	//alert(g);

	var args = {"guess":g, "gid":gid};
    $.post("processguess.php", args,
        function(data){
            var d = $(data).find("Data").text();
            //alert(d);

            var r = $(data).find("Locations").text();
            //alert("Locations - " + r);

            if(r == "NONE"){
                var l = document.getElementById("guesserincorrect");
                var line = l.innerHTML;
                line = line.concat(g);
                line = line.concat(". ");
                l.innerHTML = line;

                incorrectguess--;

                var temp = "You have " + incorrectguess + " incorrect guesses left"

                var x = document.getElementById("numguess");
                x.innerHTML = temp;

                inc = inc.concat(g);
                //alert(inc);


            }
            else{
                var w = document.getElementById("guesserword");
                
                var temp = "";

                var i;
                var j = 0;
                for(i = 0; i < length; i++){
                    if(r.charAt(j) == i){
                        temp = temp.concat(g);
                        wintotal--;
                        j++;
                    }
                    else if(curguess.charAt(i) != "_"){
                        temp = temp.concat(curguess.charAt(i));
                    }
                    else{
                        temp = temp.concat("_");
                    }
                }

                curguess = temp;
                temp = ""

                for(i = 0; i < length; i++){
                    temp = temp.concat(curguess.charAt(i));
                    temp = temp.concat(" ");
                }

                w.innerHTML = temp;

            }


            var hi = 1;

            update(hi);

		    if(wintotal == 0){
		        winner();
		    }

		    if(incorrectguess == -1){
		    	loser();
		    }
		    //alert("Win total- " + wintotal);
        }
    );
}

function update(var2){
	//alert("updating");
	var i = var2;
	var args = {"gid":gid, "status":i, "guess":curguess, "inc":inc};
	$.post("update.php", args, 
        function(data){
            var d = $(data).find("Data").text();
            //alert(d)
        }
    );
}

function endUpdate(var3){

	var h = var3;

	$.post("end.php",
		function(data){
			var d = $(data).find("Data").text();
			var r = $(data).find("Result").text();

			if(r == "Yes"){
				update(h);
				ready();
			}
		}
	);

}

function winner(){
	var temp = curguess;
	temp = temp.toLowerCase();
    alert("You won!\nThe word was " + temp + "!");

    var hi = 2;

    $("div#guesserGame").hide();

    player_state = 1;
    round++;

    endUpdate(hi);

}

function loser(){
	$("div#numguess").hide();
	//alert("LOSER!");

	var args = {"gid":gid};
	$.post("loser.php", args,
        function(data){
            var d = $(data).find("Data").text();

            rightword = $(data).find("Word").text();

            rightword = rightword.toLowerCase();

			alert("You lost!\nThe word was " + rightword);

			var hi = 3;

			$("div#guesserGame").hide();

			player_state = 1;
			round++;

			endUpdate(hi);

        }
    );
}

function makerWinner(){
	player_state = 2;
	round++;

	alert("They guessed your word!!");

	$("div#makerGame").hide();

	ready();

}

function makerLoser(){
	player_state = 2;
	round++;

	alert("They did not guess your word! Good job!");

	$("div#makerGame").hide();

	ready();

}

</script>

<body>

<title> Home </title>
<center>

	<h1><div id = "round">Hangman</div></h1>

	<div id = "response"><h3>Waiting for Game</h3></div>
    <div id = "guesserWaiting"><h3>Waiting for a Word</h3></div>

	<div id = "startButton"><button type = 'button' onclick = 'connect()'>Start Game</button></div>

    <div id = "makerStuff">

        <h3>Please Enter Your Word</h3>
        <input type = 'text' id = 'word' value = "">
        <button type = 'button' onclick = 'maker()'>Enter Word</button>

    </div>

    <div id = "makerGame">

        <h3>Watch them try to guess your word!!</h3>
        </br></br>       

        <b><div id = "makerword">WORD HERE</div></b>

        </br></br>

        <b>Incorrect Guesses:</b>
        <div id = "makerincorrect"></div>

    </div>

    <div id = "guesserGame">

        <h3>Start Guessing</h3>
        </br>

        <b><div id = "guesserword">_ _ _ _ _</div></b>

        </br></br>

        <b>Incorrect Guesses:</b>
        <div id = "guesserincorrect"></div>

        </br></br>

        <input type = 'text' id = 'guess' value = "">
        <button type = 'button' onclick = 'guess()'>Enter Guess</button>

        </br>

        <div id = "numguess">You have 7 incorrect guesses left.</div>
    </div>

	</br></br></br></br></br>

	<div id = "logOut" align='right'><a href='http://cs1520.cs.pitt.edu/~acs119/php/assign4/logout.php'>Log Out</a>


</body>
</html>
