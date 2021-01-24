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


    $pr_id = 0;

    if (isset($_GET['action']) and $_GET['action'] == 'update') {
        // UPDATE
        $pr_id = $_GET['id'];
        $sql_projects = "SELECT p_id, p_name FROM projects";
        $res_pr = mysqli_query($conn, $sql_projects);
        while ($row = mysqli_fetch_assoc($res_pr)) {
            // print(" tikrinam id=" . $row["p_id"]);
            if ($row["p_id"] == $pr_id) {
                $pr_title = $row["p_name"];
                break;
            }
        }
        // print(" title=" . $pr_title);
        print('
<div class="container">
<div class="container-fluid bg-dark">
<span class="text-secondary">Update project</span>
<form method="post" class="d-flex align-items-center">
    <input name="id" class="form-control me-2" type="number" value="' . $pr_id . '">
    <input name="name" class="form-control me-2" type="text" value="' . $pr_title . '">
    <button name="add" class="btn btn-outline-secondary" type="submit">Update</button>
</form></div></div>');

        // require_once('update_project.php');
    } else {
        // ADD NEW
        print('
        <div class="container">
        <div class="container-fluid bg-dark">
            <span class="text-secondary">Add new project</span>
            <form method="post" class="d-flex align-items-center">
                <input name="id" class="form-control me-2" type="number" placeholder="Type project ID">
                <input name="name" class="form-control me-2" type="text" placeholder="Type project title">
                <button name="add" class="btn btn-outline-secondary" type="submit">Add</button>
            </form></div></div>');
    }

    $sql_empl = "SELECT e_id, e_name, e_surname, e_project_id FROM employees";
    $res_empl = mysqli_query($conn, $sql_empl);
    $sql_projects = "SELECT p_id, p_name FROM projects";
    $res_pr = mysqli_query($conn, $sql_projects);


    if (isset($_POST['add'])) {
        $id = $pr_id;
        $title = "";
        $id = $_POST['id'];
        $title = $_POST['name'];
        $poz = 1;

        if ($id < 0 or $title == "") { //tikriname ar ne tuscias
            $poz = 0;
            echo "<script>alert('Wrong or missing data (ID, Title)!');</script>";
        } else
            while ($row = mysqli_fetch_assoc($res_pr)) { //tikriname id ar unikalus
                if ($id == $row["p_id"] and $id != $pr_id) {
                    echo "<script>alert('ID is not unic. Try again.');</script>";
                    $poz = 0;
                    break;
                }
            }
        if ($poz == 1) {
            if ($pr_id != 0) mysqli_query($conn, "UPDATE projects SET p_id = '$id', p_name = '$title' WHERE p_id = '$pr_id'");
            else mysqli_query($conn, "INSERT INTO projects VALUES ('$id', '$title')");
            header('location: projects.php');
        }
    }

    mysqli_close($conn);

    ?>

</footer>