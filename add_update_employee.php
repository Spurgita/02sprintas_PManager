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

    $empl_id = 0;
    $action = "Add new";
    $action_button = "Add";
    $empl_name = "Enter new name";
    $empl_surname = "Enter new surname";
    $empl_project_name = "None";
    $empl_project_id = 0;


    if (isset($_GET['action']) and $_GET['action'] == 'update') {
        // UPDATE nustatymai
        $empl_id = $_GET['id'];
        $action = "Update";
        $action_button = "Update";

        $res_empl = mysqli_query($conn, $sql_empl);
        while ($row = mysqli_fetch_assoc($res_empl)) {
            if ($row["e_id"] == $empl_id) {
                $empl_name = $row["e_name"];
                $empl_surname = $row["e_surname"];
                $empl_project_id = $row["e_project_id"];
                break;
            }
        }
    } // END UPDATE nustatymai

    if ($action == "Update") {
        $empl_id_txt = 'value="' . $empl_id . '"';
        $sql_projects = "SELECT p_id, p_name FROM projects";
        $res_pr = mysqli_query($conn, $sql_projects);
        while ($row = mysqli_fetch_assoc($res_pr)) {
            if ($row["p_id"] == $empl_project_id) {
                $empl_project_name = $row["p_name"];
            }
        }
    } else {
        $empl_id_txt = 'placeholder="Enter new ID"';
        $empl_project_name = "Choose project";
        $empl_project_id = 0;
    }

    // ADD NEW

    print('
    <div class="container">
    <div class="container-fluid bg-dark">
        <span class="text-secondary">' . $action . ' employee</span>
        <form method="post" class="d-flex align-items-center">
            <input name="id" class="form-control me-2" type="number" ' . $empl_id_txt . '">
            <input name="name" class="form-control me-2" type="text" value="' . $empl_name . '">
            <input name="surname" class="form-control me-2" type="text" value="' . $empl_surname . '">
            <select name="project" class="custom-select mr-sm-2">
                <option value="' . $empl_project_id . '" selected>' . $empl_project_name . '</option>');

    $res_pr = mysqli_query($conn, $sql_projects);
    if (mysqli_num_rows($res_pr) > 0) {
        while ($row = mysqli_fetch_assoc($res_pr)) {
            print('<option value="' . $row["p_id"] . '">' . $row["p_name"] . '</option>');
        }
    }
    print('</select>
        <button name="add" class="btn btn-outline-secondary" type="submit">' . $action_button . '</button>
        </form></div></div>');


    if (isset($_POST['add'])) {
        $id = 0;
        $name = "";
        $surname = "";
        $project_id = $empl_id;
        $project_name = "";

        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $project_id = $_POST['project'];
        $poz = 1;

        if ($id <= 0 or $name == "" or $surname == "") { //tikriname ar ne tuscias
            $poz = 0;
            echo "<script>alert('Missing data (ID, name, surname)!');</script>";
        } else
            while ($row = mysqli_fetch_assoc($res_empl)) { //tikriname id ar unikalus
                if ($id == $row["e_id"] and $id != $empl_id) {
                    echo "<script>alert('ID is not unic. Try again.');</script>";
                    $poz = 0;
                    break;
                }
            }
        if ($project_id == 0) $project_id = 0;
        if ($poz == 1) {
            if ($empl_id != 0) {
                // echo "<script>alert('$empl_id -> $id $name $surname $project_id');</script>";
                mysqli_query($conn, "UPDATE employees SET e_id = '$id', e_name = '$name', e_surname = '$surname', e_project_id = '$project_id' WHERE e_id = '$empl_id'");
            } else {
                // echo "<script>alert('$id $name $surname $project_id');</script>";
                mysqli_query($conn, "INSERT INTO employees VALUES ('$id', '$name', '$surname', '$project_id')");
            }
            echo '<script> location.replace("employees.php"); </script>';
            // header('location: employees.php'); // meta warning
        }
    }

    mysqli_close($conn);

    ?>

</footer>