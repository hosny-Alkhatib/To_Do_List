<?php
    include __DIR__ . '/db.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    function add_item(array $data){
        global $db;
        $query = 'INSERT INTO Items(title, date, description, isdone) VALUES(?, ?, ?, false)';
        $stmt = mysqli_prepare($db, $query);

        mysqli_stmt_bind_param($stmt, 'sss', 
            $data['title'], $data['due_date'], $data['description']
        );

        mysqli_stmt_execute($stmt);
    }

    function check(array $data) {
        global $db;
    
        $query = "UPDATE Items 
                  SET isdone = true
                  WHERE id = ?";
        
        try {
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $data['id']);
            mysqli_stmt_execute($stmt);
            header("Location: ../main.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            echo "Error updating record: " . $e->getMessage();
        }
    }

    function get_data(){
        global $db;

        $query = 'SELECT * FROM Items';
        $result = mysqli_query($db, $query);
        
        if ($result === false) {
            echo "Error fetching data: " . mysqli_error($db);
            return null;
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    function deleteTask(array $data){
        global $db;
    
        $query = "DELETE FROM Items WHERE id = ?";
        
        try {
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $data['id']);
            mysqli_stmt_execute($stmt);
            header("Location: ../main.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            echo "Error deleting record: " . $e->getMessage();
        }
    }
?>
