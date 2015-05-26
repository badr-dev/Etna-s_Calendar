<?php
ob_start();
require_once('./class/SG-iCalendar/SG_iCal.php');
require_once('./class/sql.php');

class	Data
{
  public	$link;

  public	function	__Construct($link)
  {
    $this->link = $link;
    $this->Insert_Data($this->link);
  }

  public	function	Insert_Data($link)
  {
    
    //Use SG_iCladReader for parse data from google-calendar
    $ical = new SG_iCalReader($link);
    //get content in file ics
    $src = file_get_contents($link);
    $events = array();
    $members = array();
    $member_by_events = array();
    //separete events in content
    $events = explode("BEGIN:VEVENT", $src);
    //Count number event
    $nbr_event = count($events);
    $i = 0;
    $c = 1;
    //extract login in events
    while ($c < $nbr_event)
      {
	preg_match_all('/(?<=mailto:).+(?=@etna)/', $events[$c], $members[$i]);
	$i++;
	$c++;
      }
    //insert member by events
    $c = 0;
    foreach($members as $val)
      {
	foreach($val as $v)
	  {
	    $member_by_event[$c] = $v;
	    $c++;
	  }
      }
    //extract same value in members array 
    for($i= 0; $i < count($member_by_event);$i++)
      {
	$member_by_event[$i] = array_unique($member_by_event[$i]);
      }
    //Insert data in BDD
    $sql = new	SQL();
    $sql->delete_content();
    $c = 0;
    $count = count($member_by_event);
        
    foreach( $ical->getEvents() as $event )
      {
	$sql->insert_event($event->start, $event->end, $this->check_apo($event->summary), $this->check_apo($event->description), $this->check_apo($event->location));
	foreach($member_by_event[$c] as $value)
	  {
	    $sql->insert_member($value);
	  }
	$c++;
      }
  } 

  //replace ' with ''  
  public	function	check_apo($str)
  {
    return $str = str_replace("'", "''", $str);
  }
  //end Class
}

$url = $_POST['lien'];
if (empty($_POST['lien']))
{
  header('Location: admin_page.php?p=error');
  exit();
}
$start = new Data($url);
header("Location: admin_page.php?p=success");
ob_end_flush();
exit();

?>
