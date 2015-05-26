<?php
require_once('./class/SG-iCalendar/SG_iCal.php');
require_once('./class/sql.php');

if (isset($_POST))
{
	$sql = new SQL;
	$sql->insert_salle_ip($_POST);
}

?>