<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- @if(isset($imageUrl))
        <img src="https://drive.google.com/uc?export=view&id=1_KtkuverVx9cP4tnv4vzls9gyV7LccFU">
    @endif -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #808080;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .campo{
            width: 30%;
            padding: 10px;
            margin-top: 350px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
    <div id="app">
       <autocomplete-input></autocomplete-input>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    <div id="app"></div>
    <!-- <script type="module" src="../js/main.js"></script> -->
</body>
</html>