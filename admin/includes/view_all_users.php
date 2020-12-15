<?php
    if(isset($_GET['change_to_admin'])){
        $change_user_id = $_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $change_user_id";
        $change_user_query = mysqli_query($conn, $query);
        header("Location: users.php");
    }

    if(isset($_GET['change_to_sub'])){
        $change_user_id = $_GET['change_to_sub'];
        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $change_user_id";
        $change_user_query = mysqli_query($conn, $query);
        header("Location: users.php");
    }

    if(isset($_GET['delete'])){
        $del_user_id = $_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$del_user_id}";
        $del_query = mysqli_query($conn, $query);
        header("Location: users.php");
    }

    if(isset($_POST['submit'])){
        if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])) {
            $bulk_option = $_POST['bulk_options'];
            foreach ($_POST['checkBoxArray'] as $id) {
                switch ($bulk_option) {
                    case 'admin':
                        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'subscriber':
                        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            // die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'delete':
                        $query = "DELETE FROM users WHERE user_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
?>

<form action="" method='post'>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="admin">Admin</option>
                <option value="subscriber">Subscriber</option>
                <option value="delete">Delete</option>
            </select>
        </div> 

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="users.php?source=add_user">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM users";
                $users = mysqli_query($conn, $sql);
                if (mysqli_num_rows($users) > 0) {
                    while($row = mysqli_fetch_assoc($users)) {
                        echo "<tr>";
                        echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$row['user_id']}'></td>";
                        echo "<td>{$row['user_id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['user_firstname']}</td>";
                        echo "<td>{$row['user_lastname']}</td>";
                        echo "<td>{$row['user_email']}</td>";
                        echo "<td>{$row['user_role']}</td>";
                        echo "<td><a href='users.php?change_to_admin={$row['user_id']}'>Admin</a></td>";
                        echo "<td><a href='users.php?change_to_sub={$row['user_id']}'>Subscriber</a></td>";
                        echo "<td><a href='users.php?source=edit_user&edit_user={$row['user_id']}'>Edit</a></td>";
                        echo "<td><a href='users.php?delete={$row['user_id']}'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</form>