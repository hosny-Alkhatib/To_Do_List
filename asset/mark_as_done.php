<?php
include_once 'db.php';
include_once 'functions.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    echo "ID is set and numeric. \n";
    
    $task_id = $_GET['id'];
    echo "Task ID: $task_id. \n";
    
    $data = ['id' => $task_id];
    check($data);
    header("Location: ../main.php");
    exit;
}
?>