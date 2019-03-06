<?php include_once "head.php"; ?>
<?php
	$users = $db->fetch_all_data("users",[],"id = '".$_GET["id"]."'")[0];
?>

<?php
	if(isset($_POST["save"])){
		
		$errormessage = "";
		if($users["id"] > 0 && $users["id"] != $_GET["id"]) $errormessage = "Saving data failed, Email has registered!";
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  $errormessage = "Invalid email format"; 
		}
		if($errormessage == ""){
			$db->addtable("users");					$db->where("id",$_GET["id"]);
			$db->addfield("name");					$db->addvalue(@$_POST["name"]);
			$db->addfield("job_title_ids");			$db->addvalue(@$_POST["job_title_ids"]);
			$db->addfield("join_date");				$db->addvalue(@$_POST["join_date"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				$db->addtable("user_position_histories");
				$db->addfield("user_id");				$db->addvalue(@$_GET["id"]);
				$db->addfield("job_title_ids");			$db->addvalue(@$_POST["job_title_ids"]);
				$db->addfield("year_1");				$db->addvalue(@$_POST["year_1"]);
				$db->addfield("year_2");				$db->addvalue(@$_POST["year_2"]);
				$inserting = $db->insert();
				
				$_SESSION["job_title"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';");
			} else {
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

<h4><b>USER PROFILE</b></h4>
<?php
	$txt_name 			= $f->input("name",$users["name"],"required style='width:100%'");
	$txt_email 			= $f->input("email",$users["email"],"required style='width:100%'");
	$sel_job_title		= $f->select_window("job_title_ids","Job Title List",$users["job_title_ids"],"job_title","id","name","win_job_title.php");
	$year_1 			= $f->input("year_1",@$_POST["year_1"],"required type='number' step='1' min='".$min."' max='".$max."' value='".$value_1."' style='width:46%'");
	$year_2 			= $f->input("year_2",@$_POST["year_2"],"required type='number' step='1' min='".$min."' max='".$max."' value='".$value_2."' style='width:46%'");
	$join_date 			= $f->input("join_date",$users["join_date"],"required type='date' style='width:100%'");
	$_SESSION["job_title"] = pipetoarray($users["job_title_ids"]);
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
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
<?=$f->end();?>

<?php include_once "footer.php"; ?>