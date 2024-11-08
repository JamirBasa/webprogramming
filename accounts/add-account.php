<?php

require_once('../tools/functions.php');
require_once('../classes/account.class.php');

$first_name = $last_name = $username = $role = $password  = '';
$first_nameErr = $last_nameErr = $usernameErr = $roleErr = $passwordErr  = '';

$accountObj = new Account();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $username = clean_input($_POST['username']);
    $role = clean_input($_POST['role']);
    $password = clean_input($_POST['password']);


    if(empty($first_name)){
        $first_nameErr = 'first name is required.';
    } 
    if(empty($last_name)){
        $last_nameErr = 'last name is required.';
    }

    if(empty($username)){
        $usernameErr = 'username is required.';
    }

    if(empty($role)){
        $roleErr = 'role is required.';
    }

    if(empty($password)){
        $passwordErr = 'password is required.';
    }
    // If there are validation errors, return them as JSON
    if(!empty($first_nameErr) || !empty($last_nameErr) || !empty($usernameErr) || !empty($roleErr) || !empty($passwordErr)){
        echo json_encode([
            'status' => 'error',
            'first_nameErr' => $first_nameErr,
            'last_nameErr' => $last_nameErr,
            'usernameErr' => $usernameErr,
            'roleErr' => $roleErr,
            'passwordErr' => $passwordErr
        ]);
        exit;
    }

    if(empty($first_nameErr) && empty($last_nameErr) && empty($usernameErr) && empty($roleErr) && empty($passwordErr)){
        $accountObj->first_name = $first_name;
        $accountObj->last_name = $last_name;
        $accountObj->username = $username;
        $accountObj->role = $role;
        $accountObj->password = $password;

        if($accountObj->add()){
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong when adding the new product.']);
        }
        exit;
    }
}
?>
