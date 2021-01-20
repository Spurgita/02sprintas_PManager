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
    $sql_empl = "SELECT e_id, e_name, e_surname, e_project_id FROM employees";
    $res_empl = mysqli_query($conn, $sql_empl);
    $sql_projects = "SELECT p_id, p_name FROM projects";
    $res_pr = mysqli_query($conn, $sql_projects);

    while ($row = mysqli_fetch_assoc($res_pr)) {
        print($row["p_id"] . " ->" . $row["p_name"] . " -> ");
        //projekto vykdytojai
        $empl = "Nobody";
        $res_empl = mysqli_query($conn, $sql_empl);
        while ($emrow = mysqli_fetch_assoc($res_empl)) {
            // print("Lyginam: " . $emrow["e_project_id"] . " ir " . $row["p_id"] . "||");
            if ($emrow["e_project_id"] == $row["p_id"]) {
                // print("RADO!" . $emrow["e_name"] . " " . $emrow["e_surname"]);
                if ($empl == "Nobody") $empl = $emrow["e_name"] . " " . $emrow["e_surname"];
                else  $empl .= ", " . $emrow["e_name"] . " " . $emrow["e_surname"];
            }
        }

        print($empl);
        // end preparing
    }

    ?>

</footer>