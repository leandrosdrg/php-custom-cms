<?php 
    if(isset($_POST['create_post'])){
        $post_title = mysqli_real_escape_string($conn, trim($_POST['title']));
        $post_category = mysqli_real_escape_string($conn, trim($_POST['post_category']));
        $post_user = mysqli_real_escape_string($conn, trim($_POST['post_user']));
        $post_status = mysqli_real_escape_string($conn, trim($_POST['post_status']));        
        $post_image = mysqli_real_escape_string($conn, trim($_FILES['image']['name']));
        $post_image_temp = mysqli_real_escape_string($conn, trim($_FILES['image']['tmp_name']));
        $post_tags = mysqli_real_escape_string($conn, trim($_POST['post_tags']));
        $post_content = mysqli_real_escape_string($conn, trim($_POST['post_content']));
        $post_date = mysqli_real_escape_string($conn, trim(date('d-m-y')));

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO `posts` (`post_category_id`, `post_user`, `post_title`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) ";
        $query .= "VALUES ('{$post_category}', '{$post_user}', '{$post_title}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
        $result = mysqli_query($conn, $query);

        if(!$result){                            
            die("QUERY FAILED" . mysqli_error($conn));
        }

        $the_post_id = mysqli_insert_id($conn);
        echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category" id="">
            <?php 
                $sql = "SELECT cat_id, cat_title FROM categories";
                $categories = mysqli_query($conn, $sql);
                if (mysqli_num_rows($categories) > 0) {
                    while($row = mysqli_fetch_assoc($categories)) {
                        echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
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
                        echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10">
        </textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>