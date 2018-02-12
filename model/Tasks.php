<?php

class Tasks
{
    public function connectSelectDb(){
        $db = mysql_connect("localhost","root","");
        mysql_select_db("tasks" ,$db);
        $sql = mysql_query("SELECT * FROM Tasks" ,$db);
        return $sql;
    }

    public function connectToDb(){
        $db = mysql_connect("localhost","root","");
        mysql_select_db("tasks" ,$db);
        return $db;
    }
}