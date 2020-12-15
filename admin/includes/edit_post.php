<?php 
    if(isset($_GET['p_id'])){
        $the_post_id = mysqli_real_escape_string($conn, trim($_GET['p_id']));
    }

    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $post_title = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_user = $row['post_user'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];
            $post_date = $row['post_date'];
        }
    }

    if(isset($_POST['update_post'])) {
        $post_title = mysqli_real_escape_string($conn, trim($_POST['title']));
        $post_category = mysqli_real_escape_string($conn, trim($_POST['post_category']));
        $post_user = mysqli_real_escape_string($conn, trim($_POST['post_user']));
        $post_status = mysqli_real_escape_string($conn, trim($_POST['post_status']));        
        $post_image = mysqli_real_escape_string($conn, trim($_FILES['image']['name']));
        $post_image_temp = mysqli_real_escape_string($conn, trim($_FILES['image']['tmp_name']));
        $post_tags = mysqli_real_escape_string($conn, trim($_POST['post_tags']));
        $post_content = mysqli_real_escape_string($conn, trim($_POST['post_content']));
        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = {$post_category}, ";
        $query .= "post_date = now(), ";
        $query .= "post_user = '{$post_user}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}' ";
        $query .= "WHERE post_id = {$the_post_id} ";

        $update_post = mysqli_query($conn, $query);
        if(!$update_post){                            
            die("QUERY FAILED" . mysqli_error($conn));
        }

        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" value='<?php echo $post_title ?>' name="title">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category" id="">
            <?php 
                $sql = "SELECT cat_id, cat_title FROM categories";
                $categories = mysqli_query($conn, $sql);
                if (mysqli_num_rows($categories) > 0) {
                    while($row = mysqli_fetch_assoc($categories)) {
                        if($row['cat_id'] == $post_category_id){
                            echo "<option selected value='{$row['cat_id']}'>{$row['cat_title']}</option>";
                        } else {
                            echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
                        }
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" id="">
            <?php 
                $sql = "SELECT user_id, username FROM users";
                $users = mysqli_query($conn, $sql);
                if (mysqli_num_rows($users) > 0) {
                    while($row = mysqli_fetch_assoc($users)) {
                        if($row['user_id'] == $post_user){
                            echo "<option selected value='{$row['user_id']}'>{$row['username']}</option>";
                        } else {
                            echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                        }
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value='<?php echo $post_status ?>'><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'published' ) {
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Publish</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value='<?php echo $post_tags ?>' class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"><?php echo $post_content ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Publish Post">
    </div>
</form>