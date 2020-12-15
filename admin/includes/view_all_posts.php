<?php 
    if(isset($_POST['delete'])){
        $del_post_id = $_POST['post_id'];
        $sql = "DELETE FROM posts WHERE post_id = {$del_post_id}";
        $del_query = mysqli_query($conn, $sql);
        header("Location: posts.php");
    }

    if(isset($_GET['reset'])){
        $reset_post_id = $_GET['reset'];
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $reset_post_id";
        $reset_query = mysqli_query($conn, $sql);
    }

    if(isset($_POST['submit'])){
        if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])) {
            $bulk_option = $_POST['bulk_options'];
            foreach ($_POST['checkBoxArray'] as $id) {
                switch ($bulk_option) {
                    case 'published':
                        $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'draft':
                        $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'delete':
                        $query = "DELETE FROM posts WHERE post_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'clone':
                        $query = "SELECT * FROM posts WHERE post_id = {$id} ";
                        $result = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_assoc($result)) {
                            $post_title = $row['post_title'];
                            $post_category_id = $row['post_category_id'];
                            $post_date = $row['post_date']; 
                            $post_author = $row['post_author'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'] ; 
                            $post_tags = $row['post_tags']; 
                            $post_content = $row['post_content'];
                        }

                        $query = "INSERT INTO `posts` (`post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) ";
                        $query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
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
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div> 

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th scope="col">Id</th>
                <th scope="col">Category</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">User</th>
                <th scope="col">Date</th>
                <th scope="col">Image</th>
                <th scope="col">Tags</th>
                <th scope="col">Comments</th>
                <th scope="col">Status</th>
                <th scope="col">Edit Post</th>
                <th scope="col">Delete Post</th>
                <th scope="col">View Post</th>
                <th scope="col">Views Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM posts";
                $posts = mysqli_query($conn, $sql);
                if (mysqli_num_rows($posts) > 0) {
                    while($row = mysqli_fetch_assoc($posts)) {
                        echo "<tr>
                            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$row['post_id']}'></td>
                            <td>{$row['post_id']}</td>";

                        $query = "SELECT * FROM categories WHERE cat_id = {$row['post_category_id']}";
                        $post_category = mysqli_query($conn, $query);
                        $cat_td = "<td></td>";

                        if (mysqli_num_rows($post_category) > 0) {
                            while($cat_row = mysqli_fetch_assoc($post_category)) {
                                $cat_td = "<td>{$cat_row['cat_title']}</td>";
                            }
                        }
                            
                        echo "{$cat_td}
                            <td>{$row['post_title']}</td>
                            <td>{$row['post_author']}</td>
                            <td>{$row['post_user']}</td>
                            <td>{$row['post_date']}</td>
                            <td><img src='../images/{$row['post_image']}' alt='image' width='100'></td>
                            <td>{$row['post_tags']}</td>";

                        $query = "SELECT * FROM comments WHERE comment_post_id = {$row['post_id']}";
                        $send_comment_query = mysqli_query($conn, $query);
                        $count_comments = mysqli_num_rows($send_comment_query);

                        echo "<td><a href='post_comments.php?id={$row['post_id']}'>$count_comments</a></td>
                            <td>{$row['post_status']}</td>
                            <td><a class='btn btn-primary' href='../post.php?p_id={$row['post_id']}'>View Post</a></td>
                            <td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$row['post_id']}'>Edit</a></td>
                            <form action='' method='post'>
                                <input type='hidden' name='post_id' value={$row['post_id']}>
                                <td><input type='submit' name='delete' class='btn btn-danger' value='Delete'></td>
                            </form>
                            <td><a href='posts.php?reset={$row['post_id']}'>{$row['post_views_count']}</a></td>
                        </tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</form>