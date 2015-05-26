<?php

class	SQL
{
  protected	$connect;
  protected	$host;
  protected	$user;
  protected	$pwd;
  protected	$db;

  public	function	__Construct()
  {
    $this->connect();
  }

  public	function	connect()
  {
    if ($this->connect = mysqli_connect("localhost", "root", "badr", "calendar"))
      echo "Connection SQL ok \n";
    else
	echo "Connection Sql Failled ! \n";
  }

  public	function	insert_event($start, $end, $summary, $description, $location)
  {
    //Query1 for insert data of event
    $sql1 = "INSERT INTO t_event (start, end, summary, description, location) VALUES ('".$start."','".$end."','".$summary."','".$description."','".$location."');";
    //use query1
    if ($query1 = mysqli_query($this->connect, $sql1))
      echo "Insert member OK\n";
    else
      echo "Failled Insert Event\n";
  }
  
  public	function	insert_member($member)
  {
    //Query2 for get last ID of Event
    $sql1 = "SELECT MAX(id) FROM t_event;";
    //get id of last event
    if ($id_event = mysqli_query($this->connect, $sql1))
      echo "Get last id of event OK\n";
    else
      echo "Failled last id of event\n";
    //get ressource sql
    $row = mysqli_fetch_array($id_event, MYSQLI_NUM);

    //Query3 for insert members by Event
    $sql2 = "INSERT INTO t_members (login, id_event) VALUES('".$member."','".$row[0]."');";
 
   //Insert Member by last Event
    if ($query2 = mysqli_query($this->connect, $sql2))
      echo "Insert members by last event OK\n";
    else
      echo "Failled insert members by last event\n";
  }

  public	function	delete_content()
  {
    //Prepare query for delete members
    $sql = "DELETE FROM `t_members` ;";
    //Execute query for delete members
    if (mysqli_query($this->connect, $sql))
      echo "<hr/>Members suppimer<hr/>";
    //Prepare query for delete events
    $sql2 = "DELETE FROM `t_event` ;";
    //Execute query for delete 
    if(mysqli_query($this->connect, $sql2))
      echo "<hr/>Events supprimer<hr/>";
  }

  public      function   insert_salle_ip($tab)
  {
    $i = 1;
    while (isset($tab['salle' . $i]) && isset($tab['ip' . $i]))
    {
      $salle = $tab['salle' . $i];
      $ip = $tab['ip' . $i];
      $query = "INSERT INTO t_salle_ip (salle, ip) VALUES ('".$salle."','".$ip."');";
      $result = mysqli_query($this->connect, $query);
      if (!$result)
      {
        header('Location: ip_manager.php?p=error');
        exit;
      }
      $i++;
    }
    header('Location: ip_manager.php?p=success');
    exit();
  }
  //function for get all salle
  public	function	get_salle_and_ip()
  {
    //array for return
    $tab = array();
    //prepare query for get salle
    $sql = "SELECT salle,ip FROM t_salle_ip ;";
    //execute query for get salle
    $src_salle = mysqli_query($this->connect, $sql);
    //count number salle

    while($salle = mysqli_fetch_assoc($src_salle))
      {
	$tab[] = $salle;
      }
    //return array with all name of salle
    return $tab;
  }
}
?>