<?php
//session_start();
$server = 'localhost';
$server_user = 'root';
$server_pass = '';
$database_name = 'company';

$db = new mysqli($server, $server_user, $server_pass, $database_name);

if($db->connect_errno > 0){
    die('Unable to connect to database ['. $db->connect_error.']');
}

session_start();
if(!$user_login = $_SESSION['login_user']){
    header("location: index.php");
}

$fetch_info = <<<SQL
    SELECT id, username, first_name, last_name, remaining_leaves FROM employees
    WHERE username='$user_login'
SQL;

if(!$result = $db->query($fetch_info)){
    die('Error retrieving user information ['. $db->error.']');
}

$row = $result->fetch_assoc();
$login_session = $row['username'];
$first_name = $row['first_name'];
$_SESSION['employee_id'] = $row['id'];
if(isset($login_session)){
    $db->close();
}

if(empty($_SESSION['time-status'])){
    $_SESSION['time-status'] = "Time In";
    
    //Query database if timed in, in case of session time out
}
?>
