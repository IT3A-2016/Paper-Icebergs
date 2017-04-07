<?php
	session_start();
	include_once ('../db.php');
	
	$error=false;
	function generatePIN($digits = 4){
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while($i < $digits){
			//generate a random number between 0 and 9.
			$pin .= mt_rand(0, 9);
			$i++;
		}
		return $pin;
	}
	
	if(isset($_POST['login'])){
		$phone=mysqli_real_escape_string($connection, $_POST['cp_number']);
		$not=mysqli_real_escape_string($connection, $_POST['notify_turn']);
		/*$notif = time();
		$notify = 60;
		$notif = $notif + ($notify * $not);*/
		
		$phone=stripslashes($phone);
		$not=stripslashes($not);
		
		$trn_date=date("Y-m-d H:i:s");
		
		if(strlen($phone)<11){
				$error=true;
				$phone_error="Phone number must be minimum of 11 integers.";
			}
		
		if(!$error){
			$sql ="INSERT INTO mobile_table (phone, turn, trn_date) VALUES ('".$phone."', '".$not."', '".$trn_date."')";
			if(mysqli_query($connection, $sql)){
				
				$sql2="SELECT c_id AS cus_id FROM mobile_table WHERE trn_date='".$trn_date."' ";
				$resul=mysqli_query($connection, $sql2);
				if($resul){
					$res= ($resul->fetch_assoc())["cus_id"];
					
					$pin=generatePIN();
					$code=$pin;
					$code=stripslashes($code);
					$defstatus="PENDING";
					
					$sql3="INSERT INTO pending (c_id, code, status) VALUES ('".$res."', '".$code."', '".$defstatus."')";
					if(mysqli_query($connection, $sql3)){
						header('location: alert.php');
					}
				}
				
			}
			else{
				$note="Phone number already exists.";
			}
		}
	}
	$sql1 ="SELECT COUNT( * ) AS count FROM mobile_table";
		$result=mysqli_query($connection, $sql1);
		if($result){
			$custom=($result->fetch_assoc())["count"];
			$count=$custom + 1;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Q2Wander</title>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, description" content="">
		<meta name="author" content="">
		
		<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../home-page/css/custom.css" type="text/css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
		<script src="../js/smoothscroll.js"></script>
		<script src="../js/webscript.js"></script>
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	</head>
	<script>
		setTimeout(function(){
			window.location.href = 'logout.php';
		},25200000);
	</script>
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
							<input type="text" name="customer" id="customer" value="<?php echo $count; ?>" class="form-control borderless" style="margin-bottom:2px;" readonly /><br>
							<input type="text" name="cp_number" id="cp_number" placeholder="+639XXXXXXXXX" class="form-control borderless" style="margin-bottom:2px;" required />
										<span style="font-size:8px;">*must only be 13 digits and should start in +63</span><br>
										<span class="text-danger"><?php if (isset($phone_error)) echo $phone_error; ?></span><br>
							<input type="number" name="notify_turn" id="notify_turn" min="2" max="10" style="margin-bottom:2px;" required />
										<span style="font-size:8px;">*default atleast 2 persons before your turn</span><br><br>
							<input type="submit" name="login" value="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp S u b m i t &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" class="btn btn-default"/>
					</div>
				</fieldset>
			</form>
	</body>
</html>