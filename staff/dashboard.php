<?php
	session_start();
	include_once ('../db.php');

	$staf="SELECT staff_id AS staff FROM staff_table";
	$result=mysqli_query($connection, $staf);
	if($result){
		$staff= ($result->fetch_assoc())["staff"];
	}
	if(!isset($_POST['next'])){
		$current='0000';
		$curr_code='0000';
	}
	if(isset($_POST['next'])){
		$sql5="UPDATE pending SET status='SERVED' WHERE status='SERVICING' LIMIT 1";
		$result5=mysqli_query($connection, $sql5);
		if($result5){
			$sql6="INSERT INTO closed (c_id,code,status,staff_id) SELECT c_id,code,status,staff_id FROM pending WHERE status='SERVED' ORDER BY c_id DESC LIMIT 1";
			$result6=mysqli_query($connection, $sql6);
			if($result6){
				$trn_date=date("Y-m-d H:i:s");
				$sql7="UPDATE closed SET trn_date='$trn_date' ORDER BY c_id DESC LIMIT 1";
				$result7=mysqli_query($connection, $sql7);
				if($result7){
					$sql8="DELETE FROM pending WHERE status='SERVED'";
					$result8=mysqli_query($connection, $sql8);
				}
			}
		}
		$sql1 ="UPDATE pending SET status='SERVICING' WHERE status='PENDING'  LIMIT 1";
		$result1=mysqli_query($connection, $sql1);
			if($result1){
				$sql2="SELECT c_id AS curr FROM pending WHERE status='SERVICING' ORDER BY c_id DESC LIMIT 1"; 
				$result2=mysqli_query($connection,$sql2);
				if($result2){
					$current=($result2->fetch_assoc())["curr"];
					$sql3 ="SELECT code AS curr_code FROM pending WHERE status='SERVICING' AND c_id='$current' LIMIT 1 ";
					$result3=mysqli_query($connection, $sql3);
					if($result3){
						$curr_code=($result3->fetch_assoc())["curr_code"];
						$sql4 ="UPDATE pending SET staff_id='".$_SESSION['staff_id']."' WHERE status='SERVICING' ORDER BY c_id DESC LIMIT 1";
						$result4=mysqli_query($connection, $sql4);
						if($result4){
							
						}
					}
					
				}
				
			}
		
	} 
	
	if(isset($_POST['no_show'])){
		$sql4 ="UPDATE pending SET status='NO SHOW' WHERE status='SERVICING' LIMIT 1";
		$result4=mysqli_query($connection, $sql4);
		if($result4){
			$sql6="INSERT INTO closed (c_id,code,status,staff_id) SELECT c_id,code,status,staff_id FROM pending WHERE status='NO SHOW' ORDER BY c_id DESC LIMIT 1";
			$result6=mysqli_query($connection, $sql6);
			if($result6){
				$trn_date=date("Y-m-d H:i:s");
				$sql7="UPDATE closed SET trn_date='$trn_date' ORDER BY c_id DESC LIMIT 1";
				$result7=mysqli_query($connection, $sql7);
				if($result7){
					$sql8="DELETE FROM pending WHERE status='NO SHOW'";
					$result8=mysqli_query($connection, $sql8);
				}
			}
		}
		$sql1 ="UPDATE pending SET status='SERVICING' WHERE status='PENDING'  LIMIT 1";
		$result1=mysqli_query($connection, $sql1);
			if($result1){
				$sql2="SELECT c_id AS curr FROM pending WHERE status='SERVICING' ORDER BY c_id DESC LIMIT 1"; 
				$result2=mysqli_query($connection,$sql2);
				if($result2){
					$current=($result2->fetch_assoc())["curr"];
					$sql3 ="SELECT code AS curr_code FROM pending WHERE status='SERVICING' AND c_id='$current' LIMIT 1 ";
					$result3=mysqli_query($connection, $sql3);
					if($result3){
						$curr_code=($result3->fetch_assoc())["curr_code"];
						$sql4 ="UPDATE pending SET staff_id='".$_SESSION['staff_id']."' WHERE status='SERVICING' ORDER BY c_id DESC LIMIT 1";
						$result4=mysqli_query($connection, $sql4);
						if($result4){
							
						}
					}
					
				}
				
			}
	}
	
	if(isset($_POST['reset'])){
		$sql="DELETE FROM pending";
		$result=mysqli_query($connection, $sql);
	}
	
	$error=false;
	
	
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Q2Wander</title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, description" content="">
	<meta name="author" content="">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../home-page/css/timer.css" type="text/css">
	<link rel="stylesheet" href="../home-page/css/font-awesome.min.css">
    <link href="../home-page/css/bootstrap.min.css" rel="stylesheet">
	<link href="../home-page/css/bootstrap.min.css" rel="stylesheet">
	<link href="../home-page/css/animate.min.css" rel="stylesheet"> 
	<link href="../home-page/css/animate.css" rel="stylesheet" />
	<link href="../home-page/css/style.css" rel="stylesheet">
    <link href="../Flat-UI-master/dist/css/flat-ui.css" rel="stylesheet">
    <link href="../Flat-UI-master/docs/assets/css/demo.css" rel="stylesheet">
	
	<style>
	@import url('https://fonts.googleapis.com/css?family=Comfortaa|Lobster+Two|Pacifico|Space+Mono|Arvo');
	</style>
	
</head>

<body>
<div id="non-scrollable">
	<nav class="navbar-fixed-top">
		<div class="container">
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="menu">
				<ul class="nav navbar-nav navbar-right">
					  <li><a href="../staff/logout.php">Sign out</a></li>
				</ul>
			</div>
		</div>		
	</nav>
	
	
		<div class="row">
			<div class="col-sm-12"><br><br></div>
			
		</div>
		<div class="container-fluid" style="overflow:auto;">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="col-lg-10 col-lg-offset-1">
					<div class="col-md-6">
						<div class="col-sm-6"><br>
							<div style="text-align:center;padding:10px 0 10px 0;background-color:#AED6F1;">
								<span style="font-size:50px;color:#191970;" id="current"><strong><?php 
										if($current==0){
											echo "0000";
										}
										else if($current<10){
											echo "000";
											echo $current; 
										}
										else if($current<100){
											echo "00";
											echo $current; 
										}
										else if($current<1000){
											echo "0";
											echo $current; 
										}
										else
											echo $current;
									?></strong></span><br><span style="color:#191970;">Current Serving<br></span>
							</div>
						</div>	
						
						<div class="col-sm-6"><br>
							<div style="text-align:center;padding:10px 0 10px 0;background-color:#AED6F1;">
								<span style="font-size:50px;color:#191970;" id="code"><strong>
								<?php 
								if ($curr_code==0){
									echo "0000";
								}
								else
									echo $curr_code;
								?>
								</strong></span><br><span style="color:#191970;">Code<br></span>
							</div>	
						</div>
							
						<div class="row"><br><br>
								<!-- <div class="col-sm-12">
									<div class="col-sm-12">
										<div class="container">
											<!-- time to add the controls
											<input id="start" name="controls" type="radio" />
											<input id="stop" name="controls" type="radio" />
											<input id="reset" name="controls" type="radio" />
											<div class="timer">
												<!--minutes
												<div class="cell">
													<div class="numbers tenminute movesix">0 1 2 3 4 5 6</div>
												</div>
												<div class="cell">
													<div class="numbers minute moveten">0 1 2 3 4 5 6 7 8 9</div>
												</div>
												
												<div class="cell divider">
													<div class="numbers">:</div>
												</div>
												
												<!--seconds
												<div class="cell">
													<div class="numbers tensecond movesix">0 1 2 3 4 5 6</div>
												</div>
												<div class="cell">
													<div class="numbers second moveten">0 1 2 3 4 5 6 7 8 9</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="col-sm-12" style="text-align:center;">
										<div id="timer_controls">
											<label for="start">Start</label>
											<label for="stop">Stop</label>
											<label for="reset">Reset</label>
										</div>
									</div>
								</div> --->
								<div class="col-sm-12">
									<div class="col-sm-12" style="text-align:center;padding:20px 0 20px 0;">
										
									</div>
								</div>
								<div class="col-sm-12">
									<div class="col-sm-12" style="text-align:center;padding:5px 0 5px 0;">
										<input type="submit" name="next" class="btn btn-block btn-lg btn-success" value="Next">
										</input>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="col-sm-12" style="text-align:center;padding:5px 0 5px 0;">
										<input type="submit" name="no_show" class="btn btn-block btn-lg btn-danger" value="No Show"></input>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="col-sm-12" style="text-align:center;padding:5px 0 5px 0;">
										<input type="submit" name="reset" class="btn btn-block btn-lg btn-inverse" value="Reset Queue"></input>
									</div>
								</div>
						</div>
				</div>
					<div class="col-md-6">
						<div class="row"><br></div>
						<div class="row">
							<div class="col-sm-6">
								<div style="text-align:center;padding:10px 0 10px 0;background-color:#AED6F1;color:#191970;"><strong>Reserved Numbers</strong></div>
								<div class="table-responsive" style="text-align:center;padding:0 0 10px 0;background-color:#AED6F1;color:#191970;">
								   <?php 
									$quequery="SELECT * FROM pending WHERE status='PENDING'";
									$res=mysqli_query($connection,$quequery);
									//$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
									
									while($row = $res->fetch_assoc()){
										echo '<span style="font-size:20px;">';
										if($row["c_id"]<10){
											echo "0";
											echo $row["c_id"];
											echo '<br>';
										}
										else{
											echo $row["c_id"];
											echo '<br>';
										}
										echo '</span>';
									}
								   ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div div style="text-align:center;padding:10px 0 10px 0;background-color:#AED6F1;color:#191970;"><strong>Its Unique Code</strong></div>
								<div class="table-responsive" style="text-align:center;padding:0 0 10px 0;background-color:#AED6F1;color:#191970;">
								   <?php 
									$quequery="SELECT * FROM pending WHERE status='PENDING'";
									$res=mysqli_query($connection,$quequery);
									//$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
									
									while($row = $res->fetch_assoc()){
										echo '<span style="font-size:20px;">';
										echo $row["code"];
										echo '<br>';
										echo '</span>';
									}
								   ?>
								</div>

							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12"  style="padding:20px 0 20px 0;text-align:center;"><br><br></div>
					</div>
					
				</div>
			</form>
		</div>
	</div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://thecodeplayer.com/uploads/js/prefixfree.js" type="text/javascript"></script>
	<script src="../home-page/js/jquery.js"></script>
	<script src="../home-page/js/bootstrap.min.js"></script>
	<script src="../home-page/js/wow.min.js"></script>
    <script src="../home-page/contactform/contactform.js"></script>
	<script src="../Flat-UI-master/dist/js/vendor/jquery.min.js"></script>
    <script src="../Flat-UI-master/dist/js/flat-ui.min.js"></script>
    <script src="../Flat-UI-master/docs/assets/js/application.js"></script>
	<script src="../js/smoothscroll.js"></script>
	<script src="../js/webscript.js"></script>
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery-3.2.0.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/disable_scroll.js"></script>
	
</body>
</html>