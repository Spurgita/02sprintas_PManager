<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "pm_db";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// DELETE
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $sql = 'DELETE FROM projects WHERE p_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();
    $stmt->close();

    mysqli_close($conn);

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
} // END of DELETE

// UPDATE
// if (isset($_GET['action']) and $_GET['action'] == 'update') {
//     echo "<script>alert('Paspaustas UPDATE');</script>";
// $sql = 'DELETE FROM projects WHERE p_id = ?';
// $stmt = $conn->prepare($sql);
// $stmt->bind_param('i', $_GET['id']);
// $res = $stmt->execute();

// $stmt->close();
// mysqli_close($conn);

// header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
// die();
// } // END of UPDATE



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Project Manager</title>
    <link rel="stylesheet" href="styles/reset.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles/pm_style.css" />
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand nav-link" href="index.php">Project Manager</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="employees.php">Employees</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="projects.php">Projects</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

    </header>
    <main class="overflow-auto">
        <div class="container">
            <?php

            $sql_empl = "SELECT e_id, e_name, e_surname, e_project_id FROM employees";
            $res_empl = mysqli_query($conn, $sql_empl);
            $sql_projects = "SELECT p_id, p_name FROM projects";
            $res_pr = mysqli_query($conn, $sql_projects);
            if (mysqli_num_rows($res_pr) > 0) {
                print('<table class="table table-bordered">');
                print('<thead class="thead-dark">');
                print('<tr><th>No.</th><th>Id</th><th>Project title</th><th>Emploees</th><th>Action</th></tr>');
                print('</thead>');
                print('<tbody>');

                $idx = 1;
                while ($row = mysqli_fetch_assoc($res_pr)) {

                    //projekto vykdytojai
                    $empl = "Nobody";
                    $res_empl = mysqli_query($conn, $sql_empl);
                    while ($emrow = mysqli_fetch_assoc($res_empl)) {
                        if ($emrow["e_project_id"] == $row["p_id"]) {
                            if ($empl == "Nobody") $empl = $emrow["e_name"] . " " . $emrow["e_surname"];
                            else  $empl .= ", " . $emrow["e_name"] . " " . $emrow["e_surname"];
                        }
                    }
                    // end preparing

                    print('<tr>'
                        . '<td>' . $idx++ . '</td>'
                        . '<td>' . $row["p_id"] . '</td>'
                        . '<td>' . $row["p_name"] . '</td>'
                        . '<td>' . $empl . '</td>'
                        . '<td>' . '<a href="?action=delete&id=' . $row["p_id"]
                        . '"><button class="btn btn-outline-secondary btn-sm">DELETE</button></a>'
                        . '<a href="?action=update&id=' . $row["p_id"]
                        . '">&nbsp<button class="btn btn-outline-secondary btn-sm">UPDATE</button></a>' . '</td>'
                        . '</tr>');
                }
                print('</tbody>');
                print('</table>');
            } else {
                echo "<script>alert('0 results!');</script>";
            }

            //

            print('</div></main>');


            if (isset($_GET['action']) and $_GET['action'] == 'update') {

                $id = $_GET['id'];
                require_once('update_project.php');
            } else {

                require_once('add_project.php');
            }
            ?>

</body>

</html>