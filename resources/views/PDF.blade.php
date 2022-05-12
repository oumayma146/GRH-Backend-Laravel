<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des ressources humaines</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Demande de Congé</h2>
       
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Nom d'employé</th>
                    <th scope="col">Date de debut</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">Nombre de Jour</th>
                    <th scope="col"> Type de Congé</th>
                </tr>
            </thead>
            <tbody>
                @foreach($congee ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->user_id }}</th>
                    <td>{{ $data->debut }}</td>
                    <td>{{ $data->fin }}</td>
                    <td>{{ $data->nbJour }}</td>
                    <td>{{ $data->typeCongee }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Signature RH</h4>
        
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>