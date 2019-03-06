<?php
	include_once "win_head.php";
	$_title = "SOW List";
	$_tablename = "indottech_sow";
	$_id_field = "id";
	$_caption_field = "name";
	
	if(isset($_POST["saving_new"])){
		$db->addtable("indottech_sow"); $db->addfield("name"); $db->addvalue($_POST["name"]); $inserting = $db->insert();
		if($inserting["affected_rows"] >= 0) $_GET["add"] = $inserting["insert_id"];
	}
	
	if($_GET["remove"]){
		$_SESSION["plan_sow"] = array_diff($_SESSION["plan_sow"],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>SOW deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if($_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["plan_sow"])) {
			$_title = "<p style='color:red; font-size:15px'>Please select other SOW!</p>";
		} else {
			if(!$_SESSION["plan_sow"]) {
				$_SESSION["plan_sow"] = array($_GET["add"]);
			} else {
				$_SESSION["plan_sow"] = array_merge($_SESSION["plan_sow"],array($_GET["add"]));
			}
			$_title = "<p style='color:green; font-size:15px'>SOW added!</p>";
		}
		$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$sow_ids = "";
	$sow_values = "";
	foreach($_SESSION["plan_sow"] as $key_sow => $sow_id){
		$sows = $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
		$sow_ids .= "|".$sow_id."|";
		$sow_values .= "- ".$sows["name"]."<br>";
	}
?>
<h3><b><?=$_title;?></b></h3>
<center><?=$_message;?></center>
<h3><b>SOW Selected</b></h3>
	<table id="data_content">
		<tr>
			<th width="100">SOW ID</th>
			<th>SOW Name</th>
			<th width="50">Action</th>
		</tr>
		<?php
			foreach($_SESSION["plan_sow"] as $key_sow => $sow_id){
			$sow_id_detail = $db->fetch_all_data($_tablename,[],"id ='".$sow_id."'")[0];
				?>
				<tr>
					<td align="center"><?=$sow_id_detail[$_id_field];?></td>
					<td><?=$sow_id_detail[$_caption_field];?></td>
					<td><?="<a href=\"?".$_SERVER["QUERY_STRING"]."&remove=".$sow_id_detail["id"]."\">Remove</a>";?></td>
				</tr>
				<?php	
			}
		?>
	</table>

<?=$f->input("close","Commit","type='button' onclick=\"parent_load('".$_name."','".$sow_ids."','".$sow_values."');\"");?>

<br><br>
<?php
	$_title = "SOW List";
	$db->addtable($_tablename);
	$whereclause = "";
	if($_SESSION["plan_sow"]){
		$arr_add = "";
		foreach($_SESSION["plan_sow"] as $arr){
			$arr_add .="id != ".$arr." AND ";
		}
		$whereclause .= substr($arr_add,0,-4);
	}
	if($_POST["keyword"] != "")
		$whereclause .= " AND ".$_caption_field." LIKE '%".$_POST["keyword"]."%'";
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);	
?>

<?php
	if($_GET["addnew"]==1 || isset($_POST["saving_new"])){
		echo $f->start("","POST","?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]));
			echo "New SOW : ".$f->input("name",@$_POST["name"]);
			echo $f->input("saving_new","Save","type='submit'");
			echo $f->input("cancel","Cancel","type='button' onclick=\"window.location='?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"])."';\"");
		echo $f->end();
		echo "<br>";
	} else {
		echo $f->input("addnew","Add New SOW","type='button' onclick=\"window.location='?addnew=1&".$_SERVER["QUERY_STRING"]."';\"")."<br><br>";
	}
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="5%">SOW ID</th>
			<th>SOW Name</th>
			<th width="5%">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center" width="15%"><?=$data[$_id_field];?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
