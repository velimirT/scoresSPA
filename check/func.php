<?php
	$db = new PDO('mysql:host=localhost;dbname=mulliga_scores', "mulliga_scores", "2E$#f!2YV}KREF!`");	
    $db -> query('SET NAMES UTF8');

	if(isset($_POST['act']) && $_POST['act'] == "table"){
		$xml = simplexml_load_file("http://www.xmlsoccer.com/FootballDataDemo.asmx/GetLeagueStandingsBySeason?ApiKey=IEYLEZDFVSHLDPCDRHBVCIHPSSXAZOAHJPZLBAMLKTPRJINYZV&league=scotish&seasonDateString=1718");
		$node = $xml->AccountInformation;
		unset($node[0]);
		$json = json_encode($xml);
		$_SESSION['xmlSoccerResponse'] = $json;
		echo $json;
	}//table
	
	if($_POST['act'] == 'seeComments'){
		$stmnt = $db -> prepare("SELECT * FROM comments WHERE teamID = :teamID"); 
		$stmnt -> bindParam(':teamID', $_GET['teamID']);
		$stmnt -> execute();
		$comments = '';
			while ($row = $stmnt->fetch()) {
				$comments = $comments.
				'<div class = "comment">
					<h3>'. $row['user'] .'</h3>
					<p>'. $row['comment'] .'</p>
					<span>'. $row['timestamp'] .'</span>
				</div>
				';
			}
		echo $comments;
	}//seeComments
?>
