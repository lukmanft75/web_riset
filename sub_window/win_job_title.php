<?php
	include_once "win_head.php";
	// $_title = "Teams List";
	$_tablename = "job_title";
	// $_id_field = "id";
	// $_caption_field = "name";
	
	if($_GET["remove"]){
		$_SESSION["job_title"] = array_diff($_SESSION["job_title"],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>Data Deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if($_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["job_title"])) {
			$_title = "<p style='color:red; font-size:15px'>Please select other data!</p>";
		} else {
			if(!$_SESSION["job_title"]) {
				$_SESSION["job_title"] = array($_GET["add"]);
			} else {
				$_SESSION["job_title"] = array_merge($_SESSION["job_title"],array($_GET["add"]));
			}
			$_title = "<p style='color:green; font-size:15px'>Data added!</p>";
		}
		$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$data_ids = "";
	$data_values = "";
	foreach($_SESSION["job_title"] as $key => $data_id){
		$_job_title = $db->fetch_all_data("job_title",[],"id ='".$data_id."'")[0];
		$data_ids .= "|".$data_id."|";
		$data_values .= "- ".$_job_title["name"]."<br>";
	}
?>
<h3><b><?=$_title;?></b></h3>
<center><?=$_message;?></center>
<h3><b>Job Title Selected</b></h3>
	<table id="data_content">
		<tr>
			<th width="15%">No</th>
			<th width="70%">Job Title</th>
			<th width="15%">Action</th>
		</tr>
		<?php
			$_num = 1;
			foreach($_SESSION["job_title"] as $no => $_data_id){
			$__data_id = $db->fetch_all_data($_tablename,[],"id ='".$_data_id."'")[0];
			$action_remove = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&remove=".$__data_id["id"]."';\"";
				?>
				<tr <?=$action_remove;?>>
					<td align="center"><?=$_num++;?></td>
					<td><?=$__data_id["name"];?></td>
					<td><a>Remove</a></td>
				</tr>
				<?php	
			}
		?>
	</table>

<?=$f->input("close","Commit","type='button' onclick=\"parent_load('".$_name."','".$data_ids."','".$data_values."');\"");?>

<br><br>
<?php
	$db->addtable($_tablename);
	$whereclause = "";
	$whereclause .= "web_module = '1' AND ";

	if($_SESSION["job_title"]){
		$arr_add = "";
		foreach($_SESSION["job_title"] as $arr){
			$arr_add .="id != ".$arr." AND ";
		}
		$whereclause .= substr($arr_add,0,-4)." AND ";
	}
	if($_POST["keyword"] != "") $whereclause .= "(".$_caption_field." LIKE '%".$_POST["keyword"]."%') AND ";
	
	$db->awhere(substr($whereclause,0,-4));
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="15%">No</th>
			<th width="70%">Job Title</th>
			<th width="15%">Action</th>
		</tr>
		<?php
			$num = 1;
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$num++;?></td>
			<td><?=$data["name"];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
