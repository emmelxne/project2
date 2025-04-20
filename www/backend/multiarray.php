<?php
//Multidimensional array containing user details
$user = [
    ["name" => "Alice","age" => 25,"email" => "alice@example.com"],
    ["name" => "Mark","age" => 30,"email" => "mark@example.com"],
    ["name" => "Jaemin","age" => 22,"email" => "jaemin@example.com"],
    
];

//Function to display user details in a table
function displayUsers($usersArray){
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>Name</th><th>Age</th><th>Email</th></tr>";
    foreach ($usersArray as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    echo "</table>";

}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Multidimensional Array Demo</title>
        <link rel="stylesheet" href="">
    </head>
    <body>
        <h2>List of user</h2>
    <?php displayUsers($user);?>
        
        <script src="" async defer></script>
    </body>
</html>