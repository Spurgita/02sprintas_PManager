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
        <div class="container bg-dark">
            <nav class="navbar navbar-expand-lg navbar-dark ">
                <a class="navbar-brand active" href="index.php">Project Manager</a>
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" aria-current="page" href="employees.php">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projects.php">Projects</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <span class="text-secondary">Your database contains:</span>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "mysql";
            $dbname = "pm_db";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql_empl = "SELECT e_id FROM employees";
            $res_empl = mysqli_query($conn, $sql_empl);
            $sql_projects = "SELECT p_id FROM projects";
            $res_pr = mysqli_query($conn, $sql_projects);
            print('<table class="table table-bordered">');
            print('<thead class="thead-dark">');
            print("<tr><th>Employees</th><th>Projects</th></tr>");
            print("</thead>");
            print("<tbody>");
            print("<tr><td>" . mysqli_num_rows($res_empl) . "</td><td>" . mysqli_num_rows($res_pr) .  "</td></tr>");

            print("</tbody>");
            print("</table>");

            // testas
            $sql_empl = "SELECT e_id, e_name, e_surname, e_project_id FROM employees";
            $res_empl = mysqli_query($conn, $sql_empl);
            $sql_projects = "SELECT p_id, p_name FROM projects";


            while ($row = mysqli_fetch_assoc($res_empl)) {
                $prname = "None";
                $match = false;
                $res_pr = mysqli_query($conn, $sql_projects);
                while ($prrow = mysqli_fetch_assoc($res_pr) and $match == false and $row["e_project_id"] > 0) {

                    print('Lyginam: ' . $prrow["p_id"] . ' ir ' . $row["e_project_id"]);
                    if ($prrow["p_id"] == $row["e_project_id"]) {
                        $prname = $prrow["p_name"];
                        print('--> atitinka ');
                        $match = true;
                    }
                }
            }
            // testas pab 
            ?>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>