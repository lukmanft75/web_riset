<?php include_once "head.php"; ?>
<?php
	if($_GET["deleting"] && $__username == "superuser"){
		$db->addtable("users");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
	}
	$_SESSION["job_title"] = "";
?>

<h4><b>USER LIST</b></h4>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$txt_name		= $f->input("txt_name",@$_GET["txt_name"]);
				$txt_email		= $f->input("txt_email",@$_GET["txt_email"]);
				$txt_job_title	= $f->input("txt_job_title",@$_GET["txt_job_title"]);
				$group			= $f->select("group",$db->fetch_select_data("groups","id","name",["id" => "1,2,3:IN"],array(),"",true),@$_GET["group"],"style='height:25px; width:100%'");
			?>
			<?=$t->row(array("Name",$txt_name));?>
			<?=$t->row(array("Email",$txt_email));?>
			<?=$t->row(array("Position",$txt_job_title));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'", "btn btn-primary");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"", "btn btn-warning");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	$whereclause = "forbidden_dashboards = '1' AND ";
	if($_SESSION["group_id"] > 0)	$whereclause .= "hidden = '0' AND ";
	if(@$_GET["group"]!="")			$whereclause .= "group_id = '".$_GET["group"]."' AND ";
	if(@$_GET["txt_email"]!="")		$whereclause .= "email LIKE '"."%".str_replace(" ","%",$_GET["txt_email"])."%"."' AND ";
	if(@$_GET["txt_name"]!="")		$whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["txt_name"])."%"."' AND ";
	if(@$_GET["txt_job_title"]!="")	$whereclause .= "job_title LIKE '"."%".str_replace(" ","%",$_GET["txt_job_title"])."%"."' AND ";
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$users = $db->fetch_data(true);
?>

<?php
	$txt_name 			= $f->input("name",@$_POST["name"],"required style='width:100%'");
	$txt_email 			= $f->input("email",@$_POST["email"],"required style='width:100%'");
	$txt_password 		= $f->input("password","","required type='password' autocomplete='new-password' style='width:100%'");
	$txt_job_title 		= $f->input("job_title",@$_POST["job_title"],"required style='width:100%'");
	$sel_group 			= $f->select("group_id",$db->fetch_select_data("groups","id","name",["id" => "1,2,3:IN"],array("name"),"",true),@$_POST["group_id"],"required style='height:25px;width:100%'");
	$join_date 			= $f->input("join_date",@$_POST["join_date"],"required type='date' style='width:100%'");
?>
<?=$f->input("add","Add","type='button' onclick=\"window.location='user_admin_add.php';\"", "btn btn-primary");?><br>
<?=$paging;?>
<?=$t->start("","data_content");?>
	<?=$t->header(["No",
					"<div onclick=\"sorting('name');\">Name</div>",
					"<div onclick=\"sorting('email');\">Email</div>",
					"<div onclick=\"sorting('join_date');\">Join Date</div>",
					"<div onclick=\"sorting('job_title');\">Position</div>",
					"<div onclick=\"sorting('hidden');\">Status</div>",
					"Actions"]);?>
	<?php
		$no = 1;
		foreach($users as $user){
			$actions		= "<a href=\"user_admin_edit.php?id=".$user["id"]."\">Edit</a> | <a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$user["id"]."';}\">Delete</a>";
			$status			= "";
			$status			= ["Active","Not Active","Waiting Confirm"];
			$showPassword	= "";
			if($_SESSION["group_id"] == 0) $showPassword = base64_decode($user["password"]);
			$_jt_name		= "";
			if($user["job_title_ids"] != ""){
				foreach(pipetoarray($user["job_title_ids"]) as $__jt_Id){
					$_jt_name	.="- ".$db->fetch_single_data("job_title","name",["id" => $__jt_Id])."<br>";
				}
			}
			?>
			<?=$t->row([$no++,
						$user["name"]." [".$showPassword."]",
						$user["email"],
						format_tanggal($user["join_date"],"d-M-Y"),
						$_jt_name,
						$status[$user["hidden"]],
						$actions
						],["width=2%; align=right valign=top", "", "", "", "", "align=left valign=top", "width=7% valign=top"]);?>
			<?php
		}
	?>
<?=$t->end();?>
<?=$paging;?>
<br>

<?php include_once "footer.php"; ?>