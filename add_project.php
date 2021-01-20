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
        <span class="text-secondary">Add new project</span>
        <form method="post" class="d-flex align-items-center">
            <input name="id" class="form-control me-2" type="number" placeholder="Type project ID">
            <input name="name" class="form-control me-2" type="text" placeholder="Type project title">
            <button name="add" class="btn btn-outline-secondary" type="submit">Add</button>
        </form></div></div>');


    if (isset($_POST['add'])) {
        $id = 0;
        $title = "";
        $update = false;

        $id = $_POST['id'];
        $title = $_POST['name'];
        //tikriname ar unikalus
        $unic = true;
        if (mysqli_num_rows($res_pr) > 0) {
            while ($row = mysqli_fetch_assoc($res_pr)) {
                if ($id == $row["p_id"]) {
                    echo "<script>alert('ID is not unic. Try again.');</script>";
                    $unic = false;
                    break;
                }
            }
            if ($unic == true) {
                if ($id == 0 or $title == "") echo "<script>alert('Missing data (ID, Title)!');</script>";
                else {
                    mysqli_query($conn, "INSERT INTO projects VALUES ('$id', '$title')");
                    header('location: projects.php');
                }
            }
        }
    } // END of ADD

    ?>

</footer>