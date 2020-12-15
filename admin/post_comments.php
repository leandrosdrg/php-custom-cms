<?php  include "../includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php 
    if(isset($_GET['approve'])){
        $com_id = $_GET['approve'];
        $sql = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$com_id}";
        $query = mysqli_query($conn, $sql);
        header("Location: post_comments.php");
    }

    if(isset($_GET['unapprove'])){
        $com_id = $_GET['unapprove'];
        $sql = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$com_id}";
        $query = mysqli_query($conn, $sql);
        header("Location: post_comments.php");
    }

    if(isset($_GET['delete'])){
        $com_id = $_GET['delete'];
        $sql = "DELETE FROM comments WHERE comment_id = {$com_id}";
        $query = mysqli_query($conn, $sql);
        header("Location: post_comments.php");
    }

    if(isset($_POST['submit'])){
        if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])) {
            $bulk_option = $_POST['bulk_options'];
            foreach ($_POST['checkBoxArray'] as $id) {
                switch ($bulk_option) {
                    case 'approved':
                        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'unapproved':
                        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$id} ";
                        $result = mysqli_query($conn, $query);
                        if(!$result){                            
                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                    case 'delete':
                        $query = "DELETE FROM comments WHERE comment_id = {$id} ";
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

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to admin
                    <small>Author</small>
                </h1>

                <form action="" method='post'>
                    <table class="table table-bordered table-hover">
                        <div id="bulkOptionContainer" class="col-xs-4">
                            <select class="form-control" name="bulk_options" id="">
                                <option value="">Select Options</option>
                                <option value="approved">Approve</option>
                                <option value="unapproved">Unapprove</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div> 

                        <div class="col-xs-4">
                            <input type="submit" name="submit" class="btn btn-success" value="Apply">
                            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
                        </div>

                        <thead>
                            <tr>
                                <th><input id="selectAllBoxes" type="checkbox"></th>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM comments";
                                $comments = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($comments) > 0) {
                                    while($row = mysqli_fetch_assoc($comments)) {
                                        $comment_id = $row['comment_id'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_content = $row['comment_content'];
                                        $comment_email = $row['comment_email'];
                                        $comment_status = $row['comment_status'];
                                        $comment_date = $row['comment_date'];

                                        echo "<tr>";
                                        echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$comment_id'></td>";
                                        echo "<td>$comment_id </td>";
                                        echo "<td>$comment_author</td>";
                                        echo "<td>$comment_content</td>";
                                        echo "<td>$comment_email</td>";
                                        echo "<td>$comment_status</td>";

                                        $sql = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
                                        $posts = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($posts) > 0) {
                                            while($posts_row = mysqli_fetch_assoc($posts)) {
                                                echo "<td><a href='../post.php?p_id={$posts_row['post_id']}'>{$posts_row['post_title']}</a></td>";
                                            }
                                        }

                                        echo "<td>$comment_date</td>";
                                        echo "<td><a href='post_comments.php?approve=$comment_id'>Approve</a></td>";
                                        echo "<td><a href='post_comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                                        echo "<td><a href='post_comments.php?delete=$comment_id'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include "includes/footer.php";?>