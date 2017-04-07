<?php
	include_once ('../db.php');
	
	$error=false;
	
	if(isset($_POST['login']))
	{
		if($_POST['username'] != '' && $_POST['password'] != '')
			{
				$name = mysqli_real_escape_string($connection, $_POST['username']);
				$pass = mysqli_real_escape_string($connection, $_POST['password']);
				$query = "SELECT * FROM `admin_table` WHERE `username` = '$name' AND `password` = '$pass'";
				$result = mysqli_query($connection, $query);
					if($row=mysqli_fetch_array($result))
					{
						session_start();
						$_SESSION['admin_id'] = $row['admin_id'];
						header("Location:../mobile/form.php");
					}
					else {
						echo "Invalid Login Credentials.";
					}
					
			}
	}
	 else{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Q2Wander</title>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, description" content="">
		<meta name="author" content="">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../assets/css/login.css" type="text/css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
		<script src="../js/smoothscroll.js"></script>
		<script src="../js/webscript.js"></script>
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<style>
		@import url('https://fonts.googleapis.com/css?family=Comfortaa|Lobster+Two|Pacifico');
		</style>
	</head>
	
	<body>
	  <div class="body"></div>
			<div class="grad"></div>
			<div class="header">
				<div><strong>Q<text style="font-family: 'Lobster Two', cursive;font-color:#fff;font-size:45px;">2</text><span>wander</span></strong></div>
			</div>
			<br>
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<div class="login">
							<input type="text" name="username" id="username" placeholder="Username" required /><br>
							<input type="password" name="password" id="password" placeholder="Password" required /><br><br>
							<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span><br>
							<input type="submit" name="login" value="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp L o g i n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" class="btn btn-default"/>
					</div>
				</fieldset>
			</form>
		<?php } ?>
	</body>
</html>