<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100vw;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        p {
            margin: 10px 0;
            line-height: 1.5em
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        .container {
            max-width: 800px;
            padding: 20px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

</head>
<body>
<div class="container">
    <h1>Olá, {{ $username }}!</h1>
    <hr>
    <p>Para acessar o sistema, utilize a senha temporária: <strong>{{ $temp_password }}</strong></p>
    <p>Recomendamos que você altere sua senha assim que possível.</p>
</div>
</body>
</html>
