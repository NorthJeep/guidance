<?php
	include ("config.php");
			
	
		$username = $_POST['USERNAME'];
		$userpassword = $_POST['USER_PASSWORD'];
		
		if(empty($username) === true || empty($userpassword) === true)
		{
			echo 'You need to enter a username and password<br/><br/>';
		}
		else
		{
				
			$query = "CALL `login_check`('$username', '$userpassword')";
			$result = mysqli_query($db,$query) or die(mysqli_error());
			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$userid = $row['Users_REFERENCED'];
					/*$userfname = $_POST['USER_FNAME'];
					$userlname = $_POST['USER_LNAME'];*/
					$userrole = $row['Users_ROLES'];
				}
				echo 'OK!';
				session_start();
				$_SESSION['Logged_In'] = $username;
				$_SESSION['User_ID'] = $userid;
				$user = $_SESSION['User_ID'];
				$loginname = $_SESSION['Logged_In'];
				// $_SESSION['USER_FNAME'] = $userfname;
				// $_SESSION['USER_LNAME'] = $userlname;
				$_SESSION['USER_ROLE'] = $userrole;
				$redirect = '';
				if ($userrole == 'System Administrator') {
					$redirect = 'TypeSManagement.php?user='.$loginname.'';
				} else if ($userrole == 'Student Assistant') {
					$redirect = 'TypeBIndex.php?user='.$loginname.'';
				} else if ($userrole == 'Guidance Counselor') {
					$redirect = 'index.php?user='.$loginname.'';
				}
				
				header('Location: ' . $redirect);
			}
			else
			{
				header('Location:login.php?trial=failed');
			}
		}
		// print_r($result);
?>