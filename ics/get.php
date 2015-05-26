<?php

require_once("./class/sql.php");

class	Get
{
 
  public	$sql;

  public	function	__Construct()
  {
    
  }

  public	function	push_salle_in_ip()
  {
    $this->sql = new SQL;
    //Get Salle and IP
    $tab = $this->sql->get_salle_and_ip();
    //Count number of salle
    $nbr_salle = count($tab);

    echo  $nbr_salle;
    echo "<pre>";
    print_r($tab);
    echo "</pre>";

    $c = 0;
    while ($c < $nbr_salle)
      {
	//send number salle for each IP adresse
	$res = http_get("http://".$tab[$c]['ip']."/index.php?salle=".$tab[$c]['salle']);
	$c++;
      }
        echo "<pre>";
	print_r($res);
	echo "</pre>";
	
  }
}

$go = new GET();
$go->push_salle_in_ip();
?>