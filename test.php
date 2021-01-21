<footer>


    <?php

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "pm_db";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql_empl = "SELECT e_project_id FROM employees";
    $res_empl = mysqli_query($conn, $sql_empl);
    $id = 4;
    $ind = 0;
    while ($row = mysqli_fetch_assoc($res_empl)) {
        print("e_project_id= " . $row["e_project_id"]);
        if ($row["e_project_id"] == $id) {
            $row["e_project_id"] = $id;
        }
        $ind++;
    }

    ?>

</footer>