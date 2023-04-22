<?php
function check_if_user_login($conn)
{
	if(isset($_SESSION['user_id']))
	{
		$id = $_SESSION['user_id'];
		$q = "select * from users where user_id = '$id' limit 1";
		$res = mysqli_query($conn,$q);
		if($res && mysqli_num_rows($res) > 0)
		{
			$user_data = mysqli_fetch_assoc($res);
			return $user_data;
		}
	}


	header("Location: login.php");
	die;
}

function random_number_generator($len)
{
	$to_return = "";
	$length = rand(4,$len);

	for ($i=0; $i < $length; $i++) { $text .= rand(0,9);}

	return $to_return;
}