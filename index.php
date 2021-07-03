<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = 'localhost';
$dbuser = 'anirudh';
$dbpass = 'root';
$dbname = 'webapp';

try {
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($conn, $dbname);
}
catch (exception $e){
	die("cant connect to database\n" . $e);
}

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	return $result;
}

//$sqlinsert = "INSERT INTO users (`username`, `password`) VALUES ('${username}', '${password}')";
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";


if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST["user"];
	$password = $_POST["password"];
	//mysqli_query($conn, $sqlinsert) or die(mysqli_error($conn));
	$stmt=$conn->prepare($sql);
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	print("Data inserted: $username, $password\n");

	print("Here is the full table now:\n");
	$result = query("select * from users");
	$counter = 1;
	while ($row = mysqli_fetch_assoc($result)) {
		$user = htmlspecialchars($row['username']);
		$pass = htmlspecialchars($row['password']);
		print("\n$counter: $username, $password");
		$counter++;
	}
}


?>


<form action=index.php method="post">
	<h1> FORM </h1>
	<input class="box" type="text" name="user" id="user" placeholder="Username" required /><br>
	<input class="box" type="text" name="password" id="password" placeholder="password" required /><br>
	<input type="submit" value="submit"/><br>
</form>
