<?php
$STORAGE_PREFIX = "gs://#default#/";
if( ! file_exists ( $STORAGE_PREFIX."saved" ))
	mkdir($STORAGE_PREFIX."saved");

	
$cmd = $_GET["cmd"];

switch($cmd)
{
	case "save_data":
		$name = $_POST["name"];
		$year = $_POST["year"];
		$month = $_POST["month"];
		$data = $_POST["data"];
		file_put_contents($STORAGE_PREFIX . "saved/$name|$year|$month", $data);
		break;
	case "get_data_list":
		$r = array();
		$d = dir($STORAGE_PREFIX . $STORAGE_PREFIX . "saved");
		while (false !== ($entry = $d->read()))
		{
			if($entry == "." || $entry == "..")
				continue;
			$full = $entry;
			$entry = explode("|",$entry);
			$r[] = array("full"=>$full, "name"=>$entry[0], "year"=>$entry[1], "month"=>$entry[2]);
		}
		$d->close();
		echo json_encode($r);
		break;
	case "get_data_content":
		$full = $_POST["full"];
		echo file_get_contents($STORAGE_PREFIX . "saved/$full");
		break;
	case "delete_data":
		$full = $_POST["full"];
		unlink($STORAGE_PREFIX . "saved/$full");
		break;
}
		
?>
