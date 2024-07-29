<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
        h1 {
            color: #333;
        }
        .campo{
            width: 30%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        img {
            max-height: 80vh;
            margin: 50px 0 0 0;
        }
        .image-preview-container {
            width: 500px;
            height: 200px;
            overflow: hidden;
        }
    </style>

    <div id="app">
    <!-- <div class="image-preview-container">
        @if(isset($car_of_the_day))
            <div><img src="{{ asset($car_of_the_day->foto) }}" alt=""></div>
        @else
            <div>No Car of the Day found.</div>
        @endif
    </div> -->
        <image-preview-container></image-preview-container>
       <autocomplete-input></autocomplete-input>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>