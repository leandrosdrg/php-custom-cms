<?php  include "../includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to admin
                    <small>Author</small>
                </h1>
                
                <div class="col-xs-6">

                    <?php
                        if (isset($_POST['submit'])) {
                            $cat_title = $_POST['cat_title'];
                            if ($cat_title == "" || empty($cat_title)) {
                                echo "The field should not be empty";
                            } else {
                                $query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}');";
                                $create_category = mysqli_query($conn, $query);
                                if (!$create_category) {
                                    die('QUERY FAILED' . mysqli_error($conn));
                                }
                            }
                        }
                    ?>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="cat-title">Add Category</label>
                            <input type="text" class="form-control" name="cat_title" id="cat-title">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </form> 

                    <?php   
                        if(isset($_GET['edit'])) {
                            $cat_id = mysqli_real_escape_string($conn, trim($_GET['edit']));
                            $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
                            $select_categories_id = mysqli_query($conn,$query); 
                            
                            while($row = mysqli_fetch_assoc($select_categories_id)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];?>
                            
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="cat-title">Edit Category</label>
                                        <input type="text" value="<?php echo $cat_title; ?>" class="form-control" name="cat_title" id="cat-title">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="update_category" value="Submit" class="btn btn-primary">
                                    </div>
                                </form>         
                    <?php

                            }
                        }
                        
                        if(isset($_POST['update_category'])) {
                            echo $_POST['update_category'];

                            $the_cat_title = mysqli_real_escape_string($conn, trim($_POST['cat_title']));

                            $stmt = mysqli_prepare($conn, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
                            mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id);
                            mysqli_stmt_execute($stmt);

                            if(!$stmt){                            
                                die("QUERY FAILED" . mysqli_error($connection));
                            }

                            mysqli_stmt_close($stmt);
                            header("Location: categories.php");
                        }
                    ?>

                </div>

                <div class="col-xs-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Category Id</th>
                                <th scope="col">Category Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT cat_id, cat_title FROM categories";
                                $categories = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($categories) > 0) {
                                    while($row = mysqli_fetch_assoc($categories)) {
                                        echo "<tr>
                                            <td>{$row['cat_id']}</td>
                                            <td>{$row['cat_title']}</td>
                                            <td><a href='categories.php?delete={$row['cat_id']}'>Delete</a></td>
                                            <td><a href='categories.php?edit={$row['cat_id']}'>Edit</a></td>
                                        </tr>";
                                    }
                                }

                                if(isset($_GET['delete'])) {
                                    $del_cat_id = $_GET['delete'];
                                    $sql = "DELETE FROM categories WHERE cat_id = {$del_cat_id}";
                                    $del_query = mysqli_query($conn, $sql);
                                    header("Location: categories.php");
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include "includes/footer.php";?>