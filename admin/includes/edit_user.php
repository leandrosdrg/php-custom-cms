<?php 
    if(isset($_GET['edit_user'])){
        $the_user_id = mysqli_real_escape_string($conn, trim($_GET['edit_user']));
    }

    $query = "SELECT * FROM users WHERE user_id = {$the_user_id}";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['user_id'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role = $row['user_role'];
            $username = $row['username'];
            $user_email = $row['user_email'];
            $db_user_password = $row['user_password'];
        }
    }

    if(isset($_POST['update_user'])) {
        $user_firstname = mysqli_real_escape_string($conn, trim($_POST['user_firstname']));
        $user_lastname = mysqli_real_escape_string($conn, trim($_POST['user_lastname']));
        $user_role = mysqli_real_escape_string($conn, trim($_POST['user_role']));
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $user_email = mysqli_real_escape_string($conn, trim($_POST['user_email']));
        $user_password = mysqli_real_escape_string($conn, trim($_POST['user_password']));
        
        if(!empty($user_password)) {
            if($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }
        }

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = {$the_user_id} ";

        $update_user = mysqli_query($conn, $query);
        if(!$update_user){                            
            die("QUERY FAILED" . mysqli_error($conn));
        }

        echo "User Updated" . " <a href='users.php'>View Users</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">    
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" value='<?php echo $user_firstname ?>' name="user_firstname">
    </div>
     
    <div class="form-group">
        <label for="post_status">Lastname</label>
        <input type="text" class="form-control" value='<?php echo $user_lastname ?>' name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php 
                if($user_role == 'subscriber') {
                    echo "<option value='admin'>Admin</option>";
                } else {
                    echo "<option value='subscriber'>Subscriber</option>";
                }
            ?>
      </select>  
    </div>
     
    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div> -->

    <div class="form-group">
        <label for="post_tags">Username</label>
        <input type="text" class="form-control" value='<?php echo $username ?>' name="username">
    </div>
    
    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" class="form-control" value='<?php echo $user_email ?>' name="user_email">
    </div>
    
    <div class="form-group">
        <label for="post_content">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Add User">
    </div>
</form>