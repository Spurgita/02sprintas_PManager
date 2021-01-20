<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "pm_db";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql_empl = "SELECT e_id, e_name, e_surname FROM employees";
$res_empl = mysqli_query($conn, $sql_empl);
$sql_projects = "SELECT p_id, p_name FROM projects";
$res_pr = mysqli_query($conn, $sql_projects);
$name = "Hansas";
$surname = "Hansinas";
$project_id = 2;
$id = 7;
mysqli_query($conn, "INSERT INTO employees VALUES ('$id', $name', '$surname', '$project_id')");
