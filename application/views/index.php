<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
    <template>
    <input type="search" placeholder="Search" v-model="state.search" class="campo">
    </template>

    <pre>results: {{ results }}</pre>

    <div id="app"></div>
    <script type="module" src="../js/main.js"></script>
</body>
</html>