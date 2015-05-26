<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="ETNA's Calendar" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<link rel="stylesheet" media="screen" type="text/css" title="style1" href="css/style.css">
	<title>ETNA's Calendar - Dépôt .ICS</title>
</head>
<body>
    <?php
        if (isset($_GET['p']) && $_GET['p'] == 'success')
            echo "<div class='row'>
                    <button class='btn btn-success btn-block'>Le calendrier a correctement été traité!</button>
                </div>";
        else if (isset($_GET['p']) && $_GET['p'] == 'error')
            echo "<div class='row'>
                    <button class='btn btn-danger btn-block'>Une erreur est survenue lors du traitement.</button>
                </div>";
    ?>
    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <div class="row-fluid user-row">
                            <a href="admin_page.php" title="Retour à la page principale"><img src="./img/Logo_ETNA_calendar.png" class="img-responsive" alt="Conxole Admin"/></a>    
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="data.php" method="POST" accept-charset="UTF-8" role="form" class="form-signin">
                            <fieldset>
                                <label class="panel-login">
                                    <div class="login_result"></div>
                                </label>
                                Entrez le lien du .ICS
                                <input class="form-control" placeholder="Votre lien" name="lien" type="text">
                                <br>
                                <a href="ip_manager.php" title="Gérez les IP en fonction des salles">location/IP manager</a>
                                <br></br>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Envoyer">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).mousemove(function(event) {
                TweenLite.to($("body"), 
                .5, {
                    css: {
                        backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
                        "background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
                    }
                })
            })
        })
    </script>
</footer>