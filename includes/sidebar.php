<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <form class="example" action=""  method="post" style="margin:auto;max-width:300px">
                <input type="text" name="search" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" value="Submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </form>
        </div>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php 
                        $sql = "SELECT cat_id, cat_title FROM categories";
                        $categories = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($categories) > 0) {
                            while($row = mysqli_fetch_assoc($categories)) {
                                echo "<li><a href='#'>{$row['cat_title']}</a></li>";
                            }
                        }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet.</p>
    </div>

</div>