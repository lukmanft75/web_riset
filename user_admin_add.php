<?php include_once "head.php"; ?>

<?php
	if(isset($_POST["save"])){
		$errormessage = "";
		if($users["id"] > 0) $errormessage = "Saving data failed, Email has registered!";
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  $errormessage = "Invalid email format"; 
		}
		if($errormessage == ""){
			include_once "func.sendingmail.php";
			$new_pass = "";
			for($i=1; $i<=6; $i++){
				$new_pass .=rand(0,9);
			}
			$token = session_id().$new_pass;
			$db->addtable("users");
			$db->addfield("hidden");				$db->addvalue("2");
			$db->addfield("forbidden_dashboards");	$db->addvalue("1");
			$db->addfield("name");					$db->addvalue(@$_POST["name"]);
			$db->addfield("email");					$db->addvalue(strtolower(@$_POST["email"]));
			$db->addfield("password");				$db->addvalue(base64_encode(@$new_pass));
			$db->addfield("job_title_ids");			$db->addvalue(@$_POST["job_title_id"]);
			$db->addfield("join_date");				$db->addvalue(@$_POST["join_date"]);
			$db->addfield("token");					$db->addvalue(@$token);
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$message_2 = "Dear <b><i>".ucwords($_POST["name"])."</i></b>, <br><br><br>
							Password login Anda <b>".$new_pass."</b><br>
							Silahkan klik link verifikasi berikut untuk melanjutkan tahap pendaftaran Anda
							<br><br>
							<a target='blank' href=\"http://192.168.5.77/web_riset/index.php?token=".$token."\">Verifikasi Sekarang</a> <br>
							<br>
							<p style='font-family: Courier 10 Pitch; font-weight:bolder'>
							Tim IT<br>
							</p>";
				sendingmail("Email Verification",$_POST["email"],$message_2);
				
				$db->addtable("user_position_histories");
				$db->addfield("user_id");				$db->addvalue(@$inserting["insert_id"]);
				$db->addfield("job_title_ids");			$db->addvalue(@$_POST["job_title_id"]);
				$db->addfield("year_1");				$db->addvalue(@$_POST["year_1"]);
				$db->addfield("year_2");				$db->addvalue(@$_POST["year_2"]);
				$inserting = $db->insert();
				
				$_SESSION["job_title"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
			} else {
				echo "<p style='color:red'>".$inserting["error"]." !!!</p>";
				javascript("alert('Saving data failed');");
			}
		} else {
				javascript("alert('".$errormessage."');");
		}
		
	}
	$min=date("Y")-10; $max=date("Y")+1;
	if(date("m") <= 6){
		$value_1 = date("Y")-1;
		$value_2 = date("Y");
	} else {
		$value_1 = date("Y");
		$value_2 = date("Y")+1;
	}
?>

<h4><b>ADD USER</b></h4>
<?php
	$txt_name 			= $f->input("name",@$_POST["name"],"required style='width:100%'");
	$txt_email 			= $f->input("email",@$_POST["email"],"required style='width:100%'");
	$sel_job_title		= $f->select_window("job_title_id","Job Title List",$_POST["job_title_id"],"job_title","id","name","win_job_title.php");
	$year_1 			= $f->input("year_1",@$_POST["year_1"],"required type='number' step='1' min='".$min."' max='".$max."' value='".$value_1."' style='width:46%'");
	$year_2 			= $f->input("year_2",@$_POST["year_2"],"required type='number' step='1' min='".$min."' max='".$max."' value='".$value_2."' style='width:46%'");
	$join_date 			= $f->input("join_date",@$_POST["join_date"],"required type='date' style='width:100%'");
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["Name",$txt_name]);?>
		<?=$t->row(["Email",$txt_email]);?>
		<?=$t->row(["Job Position",$sel_job_title]);?>
		<?=$t->row(["Working Year",$year_1." - ".$year_2]);?>
        <?=$t->row(["Join Date",$join_date]);?>
	<?=$t->end();?>
	<br>
	<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
<?=$f->end();?>

<?php include_once "footer.php"; ?>