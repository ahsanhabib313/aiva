<?php

header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents('php://input'), true);

$user_name = trim($data['uname']);

include 'config.php';

$query = "select * from users where Username = '{$user_name}'";
$result = mysqli_query($conn, $query) or die('query failed');

if(mysqli_num_rows($result) > 0){
    echo json_encode([
        'message' => 'Username exists in Avia datatable',
        'status' => 'Success'
    ]);
}else{
    echo json_encode([
        'message' => 'username does not exist.',
        'status' => 'Fail'
    ]);
}

?>
