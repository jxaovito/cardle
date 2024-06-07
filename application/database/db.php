<?php
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "cardle_cars";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://parseapi.back4app.com/classes/Carmodels_Car_Model_List_Audi?limit=500&order=Make');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'X-Parse-Application-Id: Kl5aF8nSOg7pxik07UDNqFUcCgfKiIyhB4RuqaEH', // This is your app's application id
        'X-Parse-REST-API-Key: hiSL5izojkeLd2Rto6CdnHKz6PzPyvM1ipQFewjx' // This is your app's REST API key
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // This line is important. It makes curl_exec return the response

    $response = curl_exec($curl); // Execute the request and store the response

    if($response === false) {
        // If curl_exec returns false, an error occurred
        echo 'Curl error: ' . curl_error($curl);
    } else {
        $data = json_decode($response); // Decode the JSON response into a PHP object
        $cars = [];
        foreach($data->results as $car){
            $cars[] = [
                'brand' => $car->Make,
                'model' => $car->Model,
                'year' => $car->Year,
                'category' => $car->Category
            ];
        }

        $models = [];
        foreach($cars as $car){
            // If the model is not already in the array, add it
            if(!array_key_exists($car['model'], $models)){
                $models[$car['model']] = $car['year'];
            }
        }

        foreach($models as $model => $year){
            echo "Model: {$model}, Year: {$year} <br>";
        }

        foreach($models as $model => $year){
            $sql = "INSERT INTO carros (id_marca, modelo, ano_lancamento, carroceria) VALUES (23, '{$model}', '{$year}', 'Sedan')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }   
    }
?>