<?php
include_once __DIR__ . '/asset/functions.php';
include './asset/mark_as_done.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['title'])) {
        $errors['title'] = "Please enter your task's Title";
    }
    if (empty($_POST['description'])) {
        $errors['description'] = "Please enter your task's description";
    }
    if (empty($_POST['due_date'])) {
        $errors['due_date'] = "Please enter when your task's due date";
    }
    if (!$errors) {
        add_item($_POST);
        header("Location: main.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>To Do List</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            .add{
                margin-bottom: 80px;
            }
            .center{
                text-align: center;
            }
            .task-card {
            border: 1px solid #ccc;
            border-radius: 10px; 
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.15); 
            padding: 15px;
            margin: 10px;
            height: 250px;
            position: relative;
            margin-left: auto;
            margin-right: auto;
            }
            .task-card h4 {
                margin-bottom: 10px;
            }
            .text-end{
                color:gray;
            }
            .description{
                color: #9a9a9a;
            }
            .icons {
                position: absolute;
                top: 10px;
                right: 10px;
                display: flex;
                gap: 5px;
            }
            .icons a {
                margin-right: 5px; 
                font-size: 20px; 
            }
            .col-md-3 {
                margin-left: 80px; 
            }
            /* .bgcg{
                background-color:'#90EE90';
            }
            .bgcw{
                background-color: white;
    
    
            } */
        
        </style>
    

    </head>


    <body style="background: #d9d9d9;">
        <div class="container">
            <h1 class="center" style="margin-bottom:30px;">To Do List</h1>
            <div class="add">
                <h3 class="cetner">Add a task To Do</h3>
                <form action="main.php" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title of the Task</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <div class="text-danger"><?= $errors['title'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                        <div class="text-danger"><?= $errors['due_date'] ?? '' ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <div class="text-danger"><?= $errors['description'] ?? '' ?></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr style="border-top: 5px solid #000000;"/>
            <div class="display">
                <h3 class="cetner">
                    Tasks to be Done:
                </h3>
                <div class="row">
                    <?php 
                    $data = get_data();
                    if(!empty($data)){
                        foreach ($data as $item) {
                            $html = <<<EOD
                                        <div class="icons">
                                        <a href='asset/mark_as_done.php?id={$item["id"]}' class='text-success'><i class='fas fa-check'></i></a>
                                        <a href='asset/del.php?id={$item["id"]}' class="text-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <h4>{$item['title']}</h4>
                                        <p class="text-end">{$item['date']}</p>
                                        <p class="description">{$item['description']}</p>
                                    </div>
                                </div>
                            EOD;
                            echo "<div class='col-md-3'> <div class='task-card' style='background-color: " . ($item['isdone'] == 1 ? '#E5FEE5' : 'white') . ";'>";
                            echo $html;
                        }
                    }   
                    else{
                        echo("<h5>No data available.</h5>");
                    }
                    ?>



                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>