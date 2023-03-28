<?php
session_start();
$DATABASE_HOST = 'innodb.endora.cz:3306';
$DATABASE_USER = 'ooofus1679094915';
$DATABASE_PASS = 'l#&73n560%$CB^Xg';
$DATABASE_NAME = 'ooofus1679094915';




$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Please fill both the username and password fields!');
}
// SQL injection protection
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if ($_POST['password'] === $password) {
		// Verification success! User has logged-in!
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
		echo 'Welcome ' . $_SESSION['name'] . '!';
		header('Location: https://jirkuvweb.jecool.net/profile');
	} else {
		// Incorrect password
		header('Location: https://jirkuvweb.jecool.net/login');
	}
} else {
	// Incorrect username
	header('Location: https://jirkuvweb.jecool.net/login');
}

	$stmt->close();
}

?>