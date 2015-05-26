<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="ETNA's Calendar" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<link rel="stylesheet" media="screen" type="text/css" title="style1" href="css/style.css">
	<title>ETNA's Calendar - IP/Location Manager</title>
</head>
<body>
    <?php
        if (isset($_GET['p']) && $_GET['p'] == 'success')
            echo "<div class='row'>
                    <button class='btn btn-success btn-block'>Les informations ont été envoyées avec succés!</button>
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
                        <form action="data_ip.php" method="POST" accept-charset="UTF-8" role="form" class="form-signin">
                            <fieldset>
                                <label class="panel-login">
                                    <div class="login_result"></div>
                                </label>

                                    <div class="row clearfix">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                                <thead>
                                                    <tr >
                                                        <th class="text-center">
                                                            Salle
                                                        </th>
                                                        <th class="text-center">
                                                            IP
                                                        </th>
                                                        <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id='addr0' data-id="0" class="hidden">
                                                        <td data-name="salle">
                                                            <input type="text" name='salle0'  placeholder='Salle' class="form-control"/>
                                                        </td>
                                                        <td data-name="ip">
                                                            <input type="text" name='ip0' placeholder='IP' class="form-control"/>
                                                        </td>
                                                        <td data-name="del">
                                                            <button nam"del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <a id="add_row" class="btn btn-default pull-right">Ajouter une ligne</a>
                                     <a href="admin_page.php" class="btn btn-default pull-left" title="Retourner à la page précédente">Précédent</a>
                                <br></br>
                                <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Envoyer">
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
    <script type="text/javascript">
    $(document).ready(function() {
        $("#add_row").on("click", function() {
            // Dynamic Rows Code
            
            // Get max row id and set new id
            var newid = 0;
            $.each($("#tab_logic tr"), function() {
                if (parseInt($(this).data("id")) > newid) {
                    newid = parseInt($(this).data("id"));
                }
            });
            newid++;
            
            var tr = $("<tr></tr>", {
                id: "addr"+newid,
                "data-id": newid
            });
            
            // loop through each td and create new elements with name of newid
            $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                var cur_td = $(this);
                
                var children = cur_td.children();
                
                // add new td and element if it has a nane
                if ($(this).data("name") != undefined) {
                    var td = $("<td></td>", {
                        "data-name": $(cur_td).data("name")
                    });
                    
                    var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                    c.attr("name", $(cur_td).data("name") + newid);
                    c.appendTo($(td));
                    td.appendTo($(tr));
                } else {
                    var td = $("<td></td>", {
                        'text': $('#tab_logic tr').length
                    }).appendTo($(tr));
                }
            });
            
            // add delete button and td
            /*
            $("<td></td>").append(
                $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
                    .click(function() {
                        $(this).closest("tr").remove();
                    })
            ).appendTo($(tr));
            */
            
            // add the new row
            $(tr).appendTo($('#tab_logic'));
            
            $(tr).find("td button.row-remove").on("click", function() {
                 $(this).closest("tr").remove();
            });
    });




        // Sortable Code
        var fixHelperModified = function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
        
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width())
            });
            
            return $helper;
        };
      
        $(".table-sortable tbody").sortable({
            helper: fixHelperModified      
        }).disableSelection();

        $(".table-sortable thead").disableSelection();



        $("#add_row").trigger("click");
    });
    </script>
</footer>