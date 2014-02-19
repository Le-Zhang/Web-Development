<?php

date_default_timezone_set('America/New_York');

$conn = new mysqli("classrome.cs.unc.edu", "lezha", "lezhang426db", "lezhadb");

$conn->query("create table Contact ( " .
			   "id int primary key not null auto_increment, " . 
			   "fname char(50), " .
			   "lname char(50), " . 
			   "address text, " .
			   "city char(50), " .
			   "state char(20), " .
			   "zcode char(20), " .
			   "pnumber char(20))");
?>
<html>
	<head>
		<title>Contact Setup</title>
	</head>
	<body>
		<h1>Database Setup Complete</h1>
	</body>
</html>
