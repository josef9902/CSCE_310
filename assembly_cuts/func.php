<?php

function check_login($conn)
{

	if(isset($_SESSION['user_id']))
	{
		$id = $_SESSION['user_id'];
		$query = "select * from users where user_id = '$id' limit 1";

		$res = mysqli_query($conn,$query);
		if($res && mysqli_num_rows($res) > 0)
		{
			$user_data = mysqli_fetch_assoc($res);
			return $user_data;
		}
	}
	header("Location: login.php");
	die;
}

function random_num($length)
{

	$text = "";

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		$text .= rand(0,9);
	}

	return $text;
}