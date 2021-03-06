<?php

require_once 'user.php';
$db = new update_user_info();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {

    // receiving the post params
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check if user is already existed with the same email
    if ($db->CheckExistingUser($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->StoreUserInfo($name, $email, $password);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["username"] = $user["username"];
            $response["user"]["email"] = $user["email"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (username, email, password) is missing!";
    echo json_encode($response);
}
?>