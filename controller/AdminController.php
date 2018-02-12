<?php
    include ('../model/Tasks.php');
    session_start();

    $task = new Tasks();
    $db = $task->connectToDb();

    $field = $_POST['field'];
    $value = $_POST['value'];
    $id = $_POST['id'];

    $sql_field = mysql_real_escape_string($field);
    $sql_value = mysql_real_escape_string($value);
    $sql_id = mysql_real_escape_string($id);

    // Изменяем текст задачи
    if ($field == 'message'){
        mysql_query("UPDATE Tasks SET text = '$sql_value' WHERE id ='$sql_id'", $db);
    }
    else{ // Изменяем статус задачи
        if ($sql_value == true){ //проверяем установлена галочка или снята
            $sql_value = 1;
        }
        else{
            $sql_value = 0;
        }
        mysql_query("UPDATE Tasks SET execute = '$sql_value' WHERE id ='$sql_id'", $db);
    }