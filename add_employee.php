<footer>


    <?php
    // ADD NEW
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
    print('
    <div class="container">
    <div class="container-fluid bg-dark">
        <span class="text-secondary">Add new employee</span>
        <form method="post" class="d-flex align-items-center">
            <input name="id" class="form-control me-2" type="number" placeholder="Type id">
            <input name="name" class="form-control me-2" type="text" placeholder="Type name">
            <input name="surname" class="form-control me-2" type="text" placeholder="Type surname">
            <select name="project" class="custom-select mr-sm-2">
                <option value="0" selected>Choose project: none</option>');

    if (mysqli_num_rows($res_pr) > 0) {
        while ($row = mysqli_fetch_assoc($res_pr)) {
            print('<option value="' . $row["p_id"] . '">' . $row["p_name"] . '</option>');
        }
    }
    print('</select>
        <button name="add" class="btn btn-outline-secondary" type="submit">Add</button>
        </form></div></div>');


    if (isset($_POST['add'])) {
        $id = 0;
        $name = "";
        $surname = "";
        $project_id = 0;
        $project_name = "";
        $update = false;

        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $project_id = $_POST['project'];
        //tikriname ar unikalus
        $unic = true;
        if (mysqli_num_rows($res_empl) > 0) {
            while ($row = mysqli_fetch_assoc($res_empl)) {
                if ($id == $row["e_id"]) {
                    echo "<script>alert('ID is not unic. Try again.');</script>";
                    $unic = false;
                    break;
                }
            }
            if ($unic == true) {
                if ($id == 0 or $name == "" or $surname == "") echo "<script>alert('Missing data (ID, name, surname)!');</script>";
                else {
                    print($id . " " . $name . " " . $surname . " " . $project_id);
                    mysqli_query($conn, "INSERT INTO employees VALUES ('$id', '$name', '$surname', '$project_id')");
                    header('location: employees.php');
                }
            }
        }
    } // END of ADD

    ?>

</footer>