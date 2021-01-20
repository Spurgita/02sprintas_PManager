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
    $sql = 'DELETE FROM employees WHERE e_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();

    $stmt->close();
    mysqli_close($conn);

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
} // END of DELETE

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
                <a class="navbar-brand nav-link" href="index.php">Project Manager</a>
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page" href="employees.php">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projects.php">Projects</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="overflow-auto">
        <div class="container">
            <?php

            $sql_empl = "SELECT e_id, e_name, e_surname, e_project_id FROM employees";
            $res_empl = mysqli_query($conn, $sql_empl);
            $sql_projects = "SELECT p_id, p_name FROM projects";
            // $res_pr = mysqli_query($conn, $sql_projects);

            if (mysqli_num_rows($res_empl) > 0) {
                print('<table class="table table-bordered">');
                print('<thead class="thead-dark">');
                print('<tr><th>No.</th><th>ID</th><th>Name</th><th>Surname</th><th>Project</th><th>Active</th></tr>');
                print('</thead>');
                print('<tbody>');
                $idx = 1;
                while ($row = mysqli_fetch_assoc($res_empl)) {

                    //preparing project name

                    $prname = "None";
                    $match = false;
                    $res_pr = mysqli_query($conn, $sql_projects);
                    while ($prrow = mysqli_fetch_assoc($res_pr) and $match == false and $row["e_project_id"] > 0) {
                        if ($prrow["p_id"] == $row["e_project_id"]) {
                            $prname = $prrow["p_name"];
                            $match = true;
                        }
                    }
                    // end preparing


                    print('<tr>'
                        . '<td>' . $idx++ . '</td>'
                        . '<td>' . $row["e_id"] . '</td>'
                        . '<td>' . $row["e_name"] . '</td>'
                        . '<td>' . $row["e_surname"] . '</td>'
                        . '<td>' . $prname . '</td>'
                        . '<td>' . '<a href="?action=delete&id=' . $row["e_id"]
                        . '"><button class="btn btn-outline-secondary btn-sm">DELETE</button></a>' . '</td>'
                        . '</tr>');
                }
                print('</tbody>');
                print('</table>');
            } else {
                echo "<script>alert('0 results!');</script>";
            }
            print('</div></main>');
            require_once('add_employee.php');
            ?>

</body>

</html>