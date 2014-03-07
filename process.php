<?php 
	session_start();

	// registration form script 

	if (isset($_POST['action']) && $_POST['action'] == 'user_registration' ) 
		{
			foreach ($_POST as $name => $value) 
			{
				if (empty($value)) 
				{
					$_SESSION['error'][$name] = "sorry " . $name . " can not be left blank";
				}
				else
					{
					switch ($name) 
					{
						case 'first_name':
						case 'last_name';
							if (is_numeric($value)) 
							{
								$_SESSION['error'][$name] = $name . ' can not have numbers';
							}
							break;

						case 'email':
							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
							{
								$_SESSION['error'][$name] = $name . ' is not a valid email';
							}
						break;
						case 'password':
							if (strlen($value) < 6) 
							{
								$_SESSION['error'][$name] = $name . ' must be greater than 6 characters.';
							}
							break;

						case 'confirm_password':
							if ($password != $value) 
							{
								$_SESSION['error'][$name] = 'Your password did not match';
							}
							break;

						case 'birthday':
						if (strlen($value) < 8)
						{
							$_SESSION['error'][$name] = "your birthday must be in the following format: MM/DD/YY";
						}
						else
						{
							$birthday = explode('/', $value); 
							if (!checkdate($birthday[0], $birthday[1], $birthday[2])  ) 
							{
								$_SESSION['error'][$name] = $name . ' is not a valid date.';
							}
						}
						break;
					}


				}
			}
		}	

// file upload script 

		if($_FILES['profile_picture']['error'] > 0 )
		{
			$_SESSION['error']['profile_picture'] = "error on file upload Return Code:" . $_FILES['profile_picture']['error'];
		}
		else
		{
			$directory = "upload/";
			$file_name = $_FILES['profile_picture']['name'];
			$file_path = $directory.$file_name;

			if (file_exists($file_path)) 
			{
				$_SESSION['error']['profile_picture'] = $file_name . "  already exists";
			}
			else
			{
				if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) 
				{
					$_SESSION['error']['profile_picture'] = $file_name . " Could not be saved "; 		
				}

			}
		}

// successful registration 

		if (!isset($_SESSION['error']))
		{
			$_SESSION['success_message'] = "Congrats! You're on your way!";
		}

		header('location: index.php');

 ?>