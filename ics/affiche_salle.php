<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="ETNA's Calendar" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Refresh" content="20">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<link rel="stylesheet" media="screen" type="text/css" title="style2" href="css/style2.css">
    <script type="text/javascript" src="js/functions.js"></script>
	<?php
        if (isset($_GET['location']))
            echo "<title>ETNA's Calendar - Salle " . $_GET['location'] . "</title>";
        else
            echo "<title>ETNA's Calendar</title>";
    ?>
</head>
<body>
    <!-- Location display -->
    <?php
  //echo $_SERVER['SERVER_NAME'];

        if (isset($_GET['location']))
        {
            $salle = $_GET['location'];
            echo "<div class='up'><img src='img/Logo_ETNA_calendar.png' width='150px' height='75px'>Salle " . $salle . "</div>";
        }
    ?>
    <div class="heure">
        <img src="img/horloge.png" height="50" width="50">
        <span id="date_heure"></span>
            <script type="text/javascript">
                window.onload = date_heure('date_heure');
            </script>
    </div>
   <?php
        $connect = mysqli_connect("localhost", "root", "badr", "calendar");

$ip = $_SERVER["SERVER_NAME"];
$sql = "SELECT salle FROM t_salle_ip WHERE ip='".$ip."';";
$res = mysqli_query($connect, $sql);
$src = mysqli_fetch_array($res);
$salle = $src['salle'];



        if (isset($salle))
        {

            $query = "SELECT id FROM t_event WHERE location = '$salle' AND end > UNIX_TIMESTAMP() ORDER BY start";
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "ERROR";
            }
            $id = mysqli_fetch_row($result);

            /*Summary display*/

            $query = "SELECT start, end FROM t_event WHERE id = '$id[0]'";
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "ERROR";
            }
            $check = mysqli_fetch_array($result);            

            $query = "SELECT summary FROM t_event WHERE id = '$id[0]'";
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "ERROR";
            }
            $data = mysqli_fetch_row($result);

            if (time() > $check['start'] && time() < $check['end'])
                echo "<div class='summary'>En cours : " . $data[0] . "<br>";
            else
                echo "<div class='summary'>Prochain évenement : " . $data[0] . " (Le " . gmdate("d/m", $check['start']) . ")<br>";

            /*Current event duration display*/

            $query = "SELECT from_unixtime(start, '%H:%i') AS start FROM t_event WHERE id = '$id[0]'";
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "ERROR";
            }
            $data = mysqli_fetch_row($result);

            $query2 = "SELECT from_unixtime(end, '%H:%i') AS end FROM t_event WHERE id = '$id[0]'";
            $result2 = mysqli_query($connect, $query2);
            if (!$result2)
            {
                echo "ERROR";
            }
            $data2 = mysqli_fetch_row($result2);
            echo "<small>De " . $data[0] . " à " .$data2[0] . "</small></div>";

            /*Next events display*/

            $query = "SELECT summary, from_unixtime(start, '%H:%i') AS start, from_unixtime(end, '%H:%i') AS end FROM t_event WHERE id <> '$id[0]' AND start > UNIX_TIMESTAMP() AND location = '$salle' ORDER BY from_unixtime(start, '%Y %D %M %H:%i:%s') LIMIT 0, 5";
            $result = mysqli_query($connect, $query);
            echo "<div class='next'>";
            echo "<table>";
            while ($data = mysqli_fetch_array($result)) {
                echo "<tr>";
                if (strlen($data['summary']) >= 15)
                    echo "<td>" . substr($data['summary'], 0, 15) . "... : </td><td>" . $data['start'] . " à " . $data['end'] . "</td>";
                else
                    echo "<td>" . $data['summary'] . " : </td><td>" . $data['start'] . " à " . $data['end'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";

            /*Login display*/

            $query = "SELECT login FROM t_members M, t_event E WHERE E.id = '$id[0]' AND M.id_event = E.id";
            $result = mysqli_query($connect, $query);
                     
            echo "<div class='login'>";
            echo "<marquee scrollamount='30'>";
            while ($data = mysqli_fetch_array($result)) {   
                echo $data['login'] . "&nbsp;&nbsp;&nbsp;";
            }
            echo "</marquee>";
            echo "</div>";
        }
    ?>
</body>
<footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
</footer>
</html>