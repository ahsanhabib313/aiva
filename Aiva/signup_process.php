<?php



session_start();

// create a pdo object
 require'config.php'; 


if(isset($_POST['submit'])) {

    //get the input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // user name validation
    $username = empty_check($username, 'username');
    $username = input_len_check($username, 'username');
    $username = test_input($username);
    
    // password validation
    $password = empty_check($password, 'password');
    $password = input_len_check($password, 'password');
    $password = test_input($password);

    $data = [
        'username' => $conn->quote($username),
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    //insert input into database
    $sql = "INSERT INTO users (Username,Password) VALUES (:username, :password)";

    $statement = $conn->prepare($sql);

    $result = $statement->execute($data);

    if($result){
        header("Location:signup.php?success=User signUp has been created successfully.");
        exit;
    }else{
        header("Location:signup.php?error=User signUp failed.");
        exit;
    }
   
    
}

   //input validation funciton
   function empty_check($data, $field_name){

        if(empty($data)){
            header("Location:signup.php?$field_name=$field_name is empty.");
            exit();
        }

        return $data;

   }

    //remove input back slashed, extra space 
    function test_input($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }
    
    //input length check
    function input_len_check($data, $field_name){

        $data_len = strlen($data);
        if($data_len < 8){
            header("Location:signup.php?$field_name=$field_name must be 8 characters.");
            exit();
        }
        return $data;
        
    }
  
?>