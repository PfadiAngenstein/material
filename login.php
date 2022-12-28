<?php

if (session_status() === PHP_SESSION_NONE) session_start();
require("config.php");
require("functions.php");

// if(isset($_GET["logout"]) && !(isset($_POST['email']) && isset($_POST['password']))) { 
// 	session_unset();
// 	session_destroy();
// }


if($_POST)
{
	$_SESSION['email'] = $_POST['email'];

    if(!isset($result["error"]))
	{
        //init scoutDB
        $db = new scoutDB;
        $token = $db->login($_SESSION['email'], urlencode($_POST['password']));
        echo $token
        // header("Location: index.php");
    } 
}    

// //*********************************************************************//
// //Debug out

// //init scoutDB
// $db = new scoutDB;
// //JSON request on groupid
// $people = $db->getGroups($groups2get);
// echo "<html><body><table>";
// for ($i = 0; $i < count($people); $i++) {
//     echo "<tr>";
//     foreach ($people[$i] as $value) {
//         echo "<td>" . utf8_decode($value) . "</td>";
//     }
//     echo "</tr>";
// }
// echo "</table></body></html>";
// echo count($people);
// //var_dump($decoded["people"]);

?>


<!DOCTYPE html>
<html>
<head>
	<title>Materialbestellung Pfadi Angenstein</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="/templates/td-okini/css/template.css" type="text/css">
	<link rel="stylesheet" href="style.css" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700" rel="stylesheet">
	<script src="/templates/td-okini/js/jquery-3.1.1.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<header>
		Materialbestellung Pfadi Angenstein
	</header>
	<div class="login_box">
		<h3>MiData-Login</h3>
		<?php if(isset($_SESSION['msg'])) { ?>
			<span class="msg"><?php echo $_SESSION['msg']; ?></span><br><br>
		<?php } ?>
		<form action="#" method="POST">
			E-Mail: <input type="text" name="email" value="<?php echo ($_SESSION['email']) ? $_SESSION['email'] : ""; ?>"/><br><br>
			Passwort: <input type="password" name="password" />
			<input class="btn-submit" type="submit" value="Login" />
		</form>
	</div>
</body>