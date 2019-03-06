<?php
	include_once "head.php";
	$message = "";
	if(isset($_GET["approve"])){
		$attendance_detail = $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["approve"]."'")[0];
		$attendance_status = $attendance_detail["attendance_status"];
		if($attendance_status == "1") $_id_status = "2";
		if($attendance_status == "4") $_id_status = "5";
		if($attendance_status == "7") $_id_status = "8";
		if($attendance_status == "10") $_id_status = "11";
		if($attendance_status == "12") $_id_status = "13";
		$db->addtable("attendance_activity"); 	$db->where("id",$_GET["approve"]);
		$db->addfield("attendance_status");		$db->addvalue($_id_status);
		$db->addfield("approved_at");			$db->addvalue($__now);
		$db->addfield("approved_by");			$db->addvalue($__username);
		$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
		$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				$db->addtable("attendance_notes");
				$db->addfield("user_id");			$db->addvalue($attendance_detail["user_id"]);
				if ($_id_status == "11" ){
					$db->addfield("tanggal");			$db->addvalue(format_tanggal($attendance_detail["created_at"],"Y-m-d"));
					$db->addfield("notes");				$db->addvalue("Sakit");
					$db->addfield("attended");			$db->addvalue("0");
					$db->addfield("surat_dokter");		$db->addvalue("1");
					$db->addfield("cuti");				$db->addvalue("0");
					$inserting = $db->insert();
				} else if ($_id_status == "13" ){
					$db->addfield("tanggal");			$db->addvalue(format_tanggal($attendance_detail["leave_start"],"Y-m-d"));
					$db->addfield("notes");				$db->addvalue("Cuti Khusus");
					$db->addfield("cuti_khusus");		$db->addvalue("1");
					$inserting = $db->insert();
					if($inserting["affected_rows"] >= 0){
						if(date("Y-m-d",strtotime($attendance_detail["leave_start"])) > date("Y-m-d",strtotime($attendance_detail["created_at"]))){
							$db->addtable("attendance_activity"); 	
							$db->addfield("user_id");				$db->addvalue($attendance_detail["user_id"]);
							$db->addfield("description");			$db->addvalue("Cuti khusus pengajuan tanggal ".date("d-M-Y",strtotime($attendance_detail["created_at"])));
							$db->addfield("leave_start");			$db->addvalue(date("Y-m-d",strtotime($attendance_detail["leave_start"])));
							$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i;s",strtotime($attendance_detail["leave_start"])));
							$db->addfield("attendance_status");		$db->addvalue("13");
							$db->addfield("approved_at");			$db->addvalue($__now);
							$db->addfield("approved_by");			$db->addvalue("System");
							$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
							$inserting = $db->insert();
						}
					}
				} else {
				}
				$message = "Activity Submission for Approval";
				javascript("window.location='?&cost_center_id=".$_GET["cost_center_id"]."&personil_id=".$_GET["personil_id"]."';");
			} else {
				echo $inserting["error"];
				javascript("alert('Approved data failed');");
				javascript("window.location='attendance_activity_list.php';");
			}
	}
	
	if(isset($_POST["save"])){
		if(!$_POST["pilih"]){
			$message = "<p style='color:red;'>Tidak ada aktifitas terpilih untuk di <i>Approve</i>!</p>";
		} else {
			foreach($_POST["pilih"] as $selected){
				$attendance_detail = $db->fetch_all_data("attendance_activity",[],"id ='".$selected."'")[0];
				$attendance_status = $attendance_detail["attendance_status"];
				if($attendance_status == "1") {$_id_status = "2";}
				if($attendance_status == "4") {$_id_status = "5";}
				if($attendance_status == "7") {$_id_status = "8";}
				if($attendance_status == "10") {$_id_status = "11";}
				if($attendance_status == "12") {$_id_status = "13";}
				$db->addtable("attendance_activity"); 	$db->where("id",$selected);
				$db->addfield("attendance_status");		$db->addvalue($_id_status);
				$db->addfield("approved_at");			$db->addvalue($__now);
				$db->addfield("approved_by");			$db->addvalue($__username);
				$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
				$inserting = $db->update();
					if($inserting["affected_rows"] >= 0){
						$_attd_activity = $db->fetch_all_data("attendance_activity",[],"id ='".$selected."'")[0];
						if($_attd_activity["attendance_status"] == "11"){
							$db->addtable("attendance_notes");
							$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
							$db->addfield("tanggal");				$db->addvalue(format_tanggal($_attd_activity["created_at"],"Y-m-d"));
							$db->addfield("notes");					$db->addvalue("Sakit");
							$db->addfield("surat_dokter");			$db->addvalue("1");
							$inserting = $db->insert();
						}
						if($_attd_activity["attendance_status"] == "13"){
							$db->addtable("attendance_notes");
							$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
							$db->addfield("tanggal");				$db->addvalue(format_tanggal($_attd_activity["leave_start"],"Y-m-d"));
							$db->addfield("notes");					$db->addvalue("Cuti Khusus");
							$db->addfield("cuti_khusus");			$db->addvalue("1");
							$_inserting = $db->insert();
							if($_inserting["affected_rows"] >= 0){
								if(date("Y-m-d",strtotime($_attd_activity["leave_start"])) > date("Y-m-d",strtotime($_attd_activity["created_at"]))){
									$db->addtable("attendance_activity"); 	
									$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
									$db->addfield("description");			$db->addvalue("Cuti khusus pengajuan tanggal ".date("d-M-Y",strtotime($_attd_activity["created_at"])));
									$db->addfield("leave_start");			$db->addvalue(date("Y-m-d",strtotime($_attd_activity["leave_start"])));
									$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i;s",strtotime($_attd_activity["leave_start"])));
									$db->addfield("attendance_status");		$db->addvalue("13");
									$db->addfield("approved_at");			$db->addvalue($__now);
									$db->addfield("approved_by");			$db->addvalue($__username);
									$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
									$inserting = $db->insert();
								}
							}
						}
						$message = "Aktifitas berhasil di Approve!";
						javascript("window.location='attendance_activity_list.php';");
					} else {
						echo $inserting["error"];
						javascript("alert('Approved data failed');");
						javascript("window.location='attendance_activity_list.php';");
					}
			}
		}
	}
?>

<script>
function toggle(source) {
  checkboxes = document.getElementsByName('pilih[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>


<div class="bo_title">Bank Soal</div>
<?php echo $message; ?>
	<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
	<div id="bo_filter">
		<div id="bo_filter_container">
			<?=$f->start("filter","GET");?>
				<?=$t->start("","editor_content");?>
				<?php
					if(@$_GET["sel_date_1"] == "") $_GET["sel_date_1"] = date("Y-m-d",mktime(0,0,0,date("m")-1,19,date("Y")));
					if(@$_GET["sel_date_2"] == "") $_GET["sel_date_2"] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
					$sel_CC			= $f->select_window("cost_center_id","Project list",$_GET["cost_center_id"],"cost_centers","id","name","win_cost_centers.php");
					$sel_personil	= $f->input("personil_id",@$_GET["personil_id"],"style='width:100%'");
					$sel_sow 		= $f->select_window("sow_id","SOW List",$_GET["sow_id"],"indottech_sow","id","name","win_default_2.php");
					$sel_site 		= $f->select_window("site_id","Sites",$_GET["site_id"],"indottech_sites","id","name","win_sites.php");
					$sel_date_1		= $f->input("sel_date_1",@$_GET["sel_date_1"],"type='date'");
					$sel_date_2		= $f->input("sel_date_2",@$_GET["sel_date_2"],"type='date'");
					$txt_vehicle 	= $f->input("txt_vehicle",@$_GET["txt_vehicle"],"style='width:100%'");
					$pm_approved	= $f->select("pm_approved",["" => "", "1" => "Yes"],@$_GET["pm_approved"],"style='width:100%; height:25px;'");
				?>
				<?=$t->row(array("Project",$sel_CC));?>
				<?=$t->row(array("Team",$sel_personil));?>
				<?=$t->row(array("SOW",$sel_sow));?>
				<?=$t->row(array("Site",$sel_site));?>
				<?=$t->row(array("Date",$sel_date_1." - ".$sel_date_2));?>
				<?=$t->row(array("Vehicle",$txt_vehicle));?>
				<?=$t->row(array("PM Approve",$pm_approved));?>
				<?=$t->end();?>
				<?=$f->input("page","1","type='hidden'");?>
				<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
				<?=$f->input("do_filter","Load","type='submit'","btn btn-primary");?>
				<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?reset=1';\"","btn btn-warning");?>
			<?=$f->end();?>
		</div>
	</div>
	
<?php
	$whereclause = "";
	if($_SESSION["group_id"] == "0") {
		$indottech_plan_activities = $db->fetch_all_data("indottech_plan_activities",[],"id > 0");
	} else {
		$indottech_plan_activities = $db->fetch_all_data("indottech_plan_activities",[],"created_by LIKE '%".$_SESSION["username"]."%'");
	}
	
	if($indottech_plan_activities){
		$in_ids = "";
		foreach($indottech_plan_activities as $indottech_plan_activity){
			$in_ids .=$indottech_plan_activity["id"].",";
		}
		$in_ids = substr($in_ids,0,-1);
			
		$whereclause .= "(indottech_plan_id IN (".$in_ids.") OR approved_by LIKE '%".$_SESSION["username"]."%') AND attendance_status IN (1,4,7,10,12) AND ";
	} else {
		$whereclause .= "approved_by LIKE '%".$_SESSION["username"]."%' AND attendance_status IN (1,4,7,10,12) AND ";
	}
	if(@$_GET["cost_center_id"]!="")	$whereclause .= "cost_center_id = '".str_replace(" ","%",$_GET["cost_center_id"])."' AND ";
		
	if(@$_GET["sow_id"]!="")			$whereclause .= "sow_ids LIKE '"."%|".str_replace(" ","%",$_GET["sow_id"])."|%"."' AND ";
	if(@$_GET["site_id"]!="") 			$whereclause .= "site_id = '".str_replace(" ","%",$_GET["site_id"])."' AND ";
	if(@$_GET["txt_vehicle"]!="") 		$whereclause .= "nopol LIKE '"."%".str_replace(" ","%",$_GET["txt_vehicle"])."%"."' AND ";
	if(@$_GET["personil_id"]!="") 		{
		$user_ids = $db->fetch_all_data("users",["id"],"name LIKE '%".$_GET["personil_id"]."%'");
		$in_user_id = "";
		foreach($user_ids as $xx => $_user_id){
			$in_user_id .=$_user_id["id"].",";
		}
		$in_user_id = substr($in_user_id,0,-1);
		$whereclause .= "user_id IN (".$in_user_id.") AND ";
	}

	$whereclause .= "created_at BETWEEN '".$_GET["sel_date_1"]."' AND '".$_GET["sel_date_2"]."' AND ";

	$db->addtable("attendance_activity");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("attendance_activity");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);if(@$_GET["personil_id"]!="" && @$_GET["sort"]=="") {
		$db->order("user_id ASC"); $db->order("created_at ASC"); 
	} else if(@$_GET["sort"]!="") {
		$db->order($_GET["sort"]);
	} else {
		$db->order("created_at ASC");
	}
	$attendance_activities = $db->fetch_data(true);
?>

<?=$f->start();?>
<?=$f->input("add","Tambah","type='button' onclick=\"window.location='soal_add.php';\"","btn btn-primary");?> &ensp;
<?=$f->input("save","Buat","type='submit'","btn btn-info");?>
<?php $select_all = $f->input("select_all","Select All","type='checkbox' onClick='toggle(this)'"); ?>
<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						$select_all." Pilih",
                        "<div onclick=\"sorting('tingkat');\">Tingkat</div>",
                        "<div onclick=\"sorting('mapel');\">Mata Pelajaran</div>",
						"<div onclick=\"sorting('tema');\">Tema</div>",
						"Tipe Soal",
						"Soal",
						"Actions"
						));?>

<?php
	echo $paging;
	$no=1;
	foreach($attendance_activities as $no => $attendance_activity){
		if($_SESSION["group_id"] == "0" || ($attendance_activity["attendance_status"] == "1" || $attendance_activity["attendance_status"] == "4" || $attendance_activity["attendance_status"] == "7" || $attendance_activity["attendance_status"] == "10" || $attendance_activity["attendance_status"] == "12")) {
			$i=1;
			$j=1;
			$team_name	= $db->fetch_single_data("users","name",["id" => $attendance_activity["user_id"]]);
			$attendance_longitude = $db->fetch_single_data("attendance","longitude",["id" => $attendance_activity["attendance_id"]]);
			$attendance_latitude = $db->fetch_single_data("attendance","latitude",["id" => $attendance_activity["attendance_id"]]);
			if($attendance_activity["longitude"] != "") $attendance_longitude = $attendance_activity["longitude"];
			if($attendance_activity["latitude"] != "") $attendance_latitude = $attendance_activity["latitude"];
			//start set access
			$module = "Activities";
			$mode = "approve";
			$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$_SESSION["user_id"]."|%:LIKE"]);
			if($_SESSION["group_id"] == 0 || $access || strtolower($_SESSION["username"]) == strtolower($_attendance_activity["approved_by"])){
				$actions = "<a href='#' onclick=\"window.location='?approve=".$attendance_activity["id"]."&cost_center_id=".$_GET["cost_center_id"]."&personil_id=".$_GET["personil_id"]."'\">Approve</a> |
							<a href='#' onclick='$.fancybox.open({ href: \"sub_window/win_reason_reject.php?reject=".$attendance_activity["id"]."\", height: \"100%\", width: \"35%\", type: \"iframe\" });'>Reject</a>";
			} else {
				$_actions = "";
			}
			//end set access
			$indottech_plan_activities = $db->fetch_all_data("indottech_plan_activities",[],"id = '".$attendance_activity["indottech_plan_id"]."'")[0];
			$cost_center_name 	= $db->fetch_single_data("cost_centers","name",["id" => $attendance_activity["cost_center_id"]]);
			$status 			= $db->fetch_single_data("attendance_activity_status","name",["id" => $attendance_activity["attendance_status"]]);
			
			//start tgl merah
			$day	= date("N",strtotime($attendance_activity["created_at"]));
			$red_1	= "";
			$red_2	= hari($day);
			if(date("N",strtotime($attendance_activity["created_at"])) == 7){
				$red_1 = "style='font-weight:bold; color:red;'";
			}
			$currentDate = date("Y-m-d",strtotime($attendance_activity["created_at"]));
			$day_off = $db->fetch_single_data("day_off","id",["tanggal" => "%".$currentDate."%:LIKE"]);
			if($day_off > 0){
				$red_1 = "style='font-weight:bold; color:red;'";
				$red_2 = "<br>Public Holiday";
			}
			//end tgl merah
			?>
				<tr>
					<td align="center"><?=$no+$start+1;?></td>
					<td align="center"><?=$f->input("pilih[]",$attendance_activity["id"],"style='height:20px;' type='checkbox' ");?></td>
					<td nowrap <?=$red_1;?>><?=$red_2;?><br><?=date("d-M-Y",strtotime($attendance_activity["created_at"]));?></td>
					<td><?=$cost_center_name;?></td>
					<td nowrap><?=$team_name;?></td>
					<td nowrap>
						<?php
							foreach(pipetoarray($indottech_plan_activities["sow_ids"]) as $_sow_id){
								echo $i++.". ".$db->fetch_single_data("indottech_sow","name",["id" => $_sow_id])."<br>";
							}
						?>
					</td>
					<td nowrap>
						<?php
							foreach(pipetoarray($attendance_activity["sow_ids"]) as $sow_id){
								echo $j++.". ".$db->fetch_single_data("indottech_sow","name",["id" => $sow_id])."<br>";
							}
						?>
					</td>
					<td><?=$indottech_plan_activities["site_name"];?></td>
					<td><?=$attendance_activity["site_name"];?></td>
					<td><?=$attendance_activity["nopol"];?></td>
					<td><a target="blank" href="http://maps.google.com/maps?q=<?=$attendance_latitude;?>,<?=$attendance_longitude;?>"><?=$attendance_latitude."  ".$attendance_longitude;?></a></td>
					<td><?=date("H:i:s",strtotime($attendance_activity["created_at"]));?></td>
					<td><?=$attendance_activity["description"];?></td>
					<td>
						<?php 
							$filename = "activityphoto_".$attendance_activity["user_id"]."_".$attendance_activity["indottech_plan_id"]."_".$attendance_activity["plan_site_id"].".jpg";
							if($attendance_activity["plan_site_id"] == 0) $filename = "activityphoto_".$attendance_activity["user_id"]."_".$attendance_activity["id"]."_.jpg"; 
							if(file_exists("geophoto/".$filename)){
								echo "<img src='geophoto/".$filename."' width='150' height='150' onclick='window.open(\"geophoto/".$filename."\");'>";
							}
						?>
					</td>
					<td><?=$status;?></td>
					<td><?=$actions;?></td>
				</tr>
		<?php
		}	
	}	
?>
<?=$f->end();?>

	</table>
	<?=$paging;?>
	
  <div class='thetop'></div>
<div class='testheight'>Some exciting content... Scroll down for the button to appear.<br><br>
<i class="fa fa-4x fa-thumbs-up fa-spin"></i>
</div>
  <?php
	for($i=1; $i<=100; $i++){
		echo "<br>";
	}
  ?>
  

<div class='scrolltop'>
    <div class='scroll icon'><i class="fa fa-4x fa-angle-up"></i></div>
</div>

 <!-- scroll to top -->
<button onclick="topFunction()" id="myBtn" class="myBtn" title="Go to top">Top</button>
<script>
	// // When the user scrolls down 20px from the top of the document, show the button
	// window.onscroll = function() {scrollFunction()};

	// function scrollFunction() {
	  // if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		// document.getElementById("myBtn").style.display = "block";
	  // } else {
		// document.getElementById("myBtn").style.display = "none";
	  // }
	// }

	// // When the user clicks on the button, scroll to the top of the document
	// function topFunction() {
	  // document.body.scrollTop = 0;
	  // document.documentElement.scrollTop = 0;
	// }
	
	
	
	$(window).scroll(function() {
		if ($(this).scrollTop() > 50 ) {
			$('.scrolltop:hidden').stop(true, true).fadeIn();
		} else {
			$('.scrolltop').stop(true, true).fadeOut();
		}
	});
	$(function(){$(".scroll").click(function(){$("html,body").animate({scrollTop:$(".thetop").offset().top},"1000");return false})})
</script>
 <!-- scroll to top -->
<?php include_once "footer.php";?>
