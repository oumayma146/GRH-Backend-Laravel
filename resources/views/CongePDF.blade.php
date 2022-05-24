<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des ressources humaines</title>
    <?php
   echo' <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">';
 ?>
</head>

<body>
<?php

   echo ' <div class="container mt-5">
        <h2 class="text-center mb-3">Demande de Congé</h2>
       
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Nom d\'employé</th>
                    <th scope="col">Date de debut</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">Nombre de Jour</th>
                    <th scope="col"> Type de Congé</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td scope="row">'.
                     $congee->user->name. $congee->user->prenom.' </td>
                    <td>'. $congee->debut.' </td>
                    <td>'. $congee->fin.' </td>
                    <td>'.$congee->nbJour.' </td>
                    <td>'.$congee->typeCongee.' </td>
                </tr>
            </tbody>
        </table>
        <h4>Signature RH</h4>
        
    </div>';
    //echo '<script src="{{ asset('js/app.js') }}" type="text/js"></script>';
?>
</body>
</html>