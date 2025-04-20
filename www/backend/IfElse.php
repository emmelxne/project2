<?php

function getGreeting($hourOfDay) {
    if ($hourOfDay >= 0 && $hourOfDay < 12) {
        return "Good Morning";
    } elseif ($hourOfDay >= 12 && $hourOfDay < 18) {
        return "Good Afternoon";
    } elseif ($hourOfDay >= 18 && $hourOfDay < 24) {
        return "Good Evening";
    } else {
        return "Invalid Hour";
    }
}
$hourOfDay = $_POST['hour'] ?? date('G');
$greeting = getGreeting($hourOfDay);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['hour'])) {
        $hourOfDay = $_POST['hour'];
        $greeting = getGreeting($hourOfDay);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Greeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #f4f4f4;
        }
        #container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input, button {
            margin-top: 10px;
            padding: 8px;
            font-size: 16px;
        }
    
    </style>
</head>
<body>

    <div id="container">
        <h1></h1>
        <p>The current server time is: </p>
        
        <form method="POST">
            <label for="hour">Enter Hour (0-23):</label>
            <input type="number" id="hour" name="hour" min="0" max="23" required>
            <button type="submit">Check Greeting</button>
        </form>
    </div>
</body>
</html>
