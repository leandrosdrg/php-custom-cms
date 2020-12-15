<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
                $sql = "SELECT * FROM posts";

                if (isset($_POST['search'])) {
                    $search = $_POST['search']; 
                    $sql = "SELECT * FROM posts where post_title LIKE '%{$search}%'";
                }

                $posts = mysqli_query($conn, $sql);

                if (mysqli_num_rows($posts) > 0) {
                    while($row = mysqli_fetch_assoc($posts)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        // $post_comment_count = $row['post_comment_count'];
                        // $post_views_count = $row['post_views_count'];
            ?>
                            <h1 class="page-header">
                                <?php echo $post_title ?>
                                <small><?php echo $post_tags ?></small>
                            </h1>
                            <h2>
                                <a href="#"><?php echo $post_title ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $post_author ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_author ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>            
                            <hr>
            <?php
                    }
                }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php";?>