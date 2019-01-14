<?php include_once "head.php"; ?>

<?php
	if(isset($_POST["save"])){
		$errormessage = "";
		if($users["id"] > 0) $errormessage = "Saving data failed, Email has registered!";
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  $errormessage = "Invalid email format"; 
		}
		if($errormessage == ""){
			$db->addtable("users");
			$db->addfield("forbidden_dashboards");	$db->addvalue("1");
			$db->addfield("name");					$db->addvalue(@$_POST["name"]);
			$db->addfield("email");					$db->addvalue(strtolower($_POST["email"]));
			$db->addfield("password");				$db->addvalue(base64_encode(@$_POST["password"]));
			$db->addfield("job_title_ids");			$db->addvalue($_POST["job_title_id"]);
			$db->addfield("group_id");				$db->addvalue(@$_POST["group_id"]);
			$db->addfield("join_date");				$db->addvalue(@$_POST["join_date"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["job_title"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
			} else {
				echo $inserting["error"];
				javascript("alert('Saving data failed');");
			}
		} else {
				javascript("alert('".$errormessage."');");
		}
		
	}
?>

<h4><b>USER PENGELOLA - ADD</b></h4>
<?php
	$txt_name 			= $f->input("name",@$_POST["name"],"required style='width:100%'");
	$txt_email 			= $f->input("email",@$_POST["email"],"required style='width:100%'");
	$txt_password 		= $f->input("password","","required type='password' autocomplete='new-password' style='width:100%'");
	$sel_job_title		= $f->select_window("job_title_id","Job Title List",$_POST["job_title_id"],"job_title","id","name","win_job_title.php");
	$sel_group 			= $f->select("group_id",$db->fetch_select_data("groups","id","name",["id" => "1,2,3:IN"],array("name"),"",true),@$_POST["group_id"],"required style='height:25px;width:100%'");
	$join_date 			= $f->input("join_date",@$_POST["join_date"],"required type='date' style='width:100%'");
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["Name",$txt_name]);?>
		<?=$t->row(["Email",$txt_email]);?>
		<?=$t->row(["Password",$txt_password]);?>
		<?=$t->row(["Job Title",$sel_job_title]);?>
        <?=$t->row(["Group",$sel_group]);?>
        <?=$t->row(["Join Date",$join_date]);?>
	<?=$t->end();?>
	<br>
	<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
<?=$f->end();?>

<?php include_once "footer.php"; ?>