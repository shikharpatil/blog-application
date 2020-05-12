<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Search</title>

  <!-- Bootstrap core CSS -->
  <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom styles for this template -->
  <!-- <link href="css/blog-post.css" rel="stylesheet"> -->

  <!-- bootstrap files for blog -->
  <!-- Bootstrap core CSS -->
  <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <style>
      .tag {
	/* margin-top: 50px; */
	/* list-style-type: none; */
}

.tag_ {
	/* float: left; */
	list-style-type: none;
}

 .atag {
	float: left;
	/* list-style-type: none; */
	text-decoration: none;
	line-height: 2.3em;
}

.size1 {
	float: left;
	/* list-style-type: none; */
	text-decoration: none;
	/* line-height: 2.3em; */
	color: #999;
	padding: 5px;
}
.size1:hover {
		background-color: #007bff;
		color: white;
	}
  </style>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <!-- <a class="nav-link" href="#">Home -->
            <?php
               foreach($userList as $row)
               {
                 if($row->id==$_SESSION['id'])
                 {
                  ?>
                  <a class="nav-link" href="<?php echo site_url();?><?php echo $row->username ;?>">
                  <?php
                   echo "Logged in : ".$row->username;
                 }
               }
               ?>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url();?>home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url();?>files">Files</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url();?>/user/logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">Search results</h1>

        <!-- Author -->
        <!-- <p class="lead">
          by
          <a href="#">Start Bootstrap</a>
        </p> -->

        <hr>

        <!-- searched for -->
        <p>Searched for : "<?php echo $search_keyword;?>"</p>

        <hr>

        <!-- Preview Image -->
        <!-- <img class="img-fluid rounded" src="http://placehold.it/900x300" alt=""> -->

        <!-- <hr> -->

        <!-- search results -->
        <p class="lead">
            <?php
            // echo "<pre>";
            // print_r($results);
            if(isset($results))
            {
                if(empty($results))
                {
                    ?>
                    <p>Results not found.</p>
                    <?php
                }
                else
                {
                    // echo "<pre>";
                    // // print_r($username);
                    // print_r($results);
                    // die();
                    foreach($results as $key=>$row)
                    {
                        // echo $key;
                        foreach($row as $data)
                        {
                            ?>
                            <!-- show results here -->
                            <div class="card my-4">
                            <!-- <h5 class="card-header">Side Widget</h5> -->
                            <div class="card-body">
                                <a href="<?php echo site_url();?><?php echo $key;?>/<?php echo $data[0]->blog_url;?>"><?php echo $data[0]->title;?></a>
                            </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
            ?>
        </p>

        <p></p>

        <p></p>

        <!-- <blockquote class="blockquote">
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
          <footer class="blockquote-footer">Someone famous in
            <cite title="Source Title">Source Title</cite>
          </footer>
        </blockquote> -->

        <p></p>

        <p></p>

        <hr>

        <!-- Comments Form -->
        <!-- <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form>
              <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div> -->

        <!-- Single Comment -->
        <!-- <div class="media mb-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          <div class="media-body">
            <h5 class="mt-0">Commenter Name</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
          </div>
        </div> -->

        <!-- Comment with nested comments -->
        <!-- <div class="media mb-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          <div class="media-body">
            <h5 class="mt-0">Commenter Name</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

            <div class="media mt-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Commenter Name</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </div>
            </div>

            <div class="media mt-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Commenter Name</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </div>
            </div>

          </div>
        </div> -->

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
            <form action="<?php echo site_url();?>user/do_search" method="post">
            <div class="form-group">
              <input type="text" id="search" name="search_keyword" class="form-control" placeholder="Search for tags only" value="<?php echo $search_keyword;?>">
            </div>
              <span class="input-group-btn">
              <input class="btn btn-secondary" type="submit" name="search" value="Go!">
                <!-- <button class="btn btn-secondary" type="button">Go!</button> -->
              </span>
            </form>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Users</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                <?php
                        if(isset($userList))
                        {
                            //    
                            foreach ($userList as $row) 
                            {
                                if($row->id==$_SESSION['id'])
                                {
                                    ?>
                                    <!-- <li><a href="<?php echo site_url();?><?php echo $row->username ;?>">My blog</a></li> -->
                                    <?php
                                }
                                else
                                {
                                ?>
                                <li><a href="<?php echo site_url();?><?php echo $row->username ;?>"><?php echo $row->username;?>'s blog</a></li>
                                <?php
                                }
                            }
                            //    print_r($user_list);
                        }
                    ?>
                  <!-- <li>
                    <a href="#">Web Design</a>
                  </li>
                  <li>
                    <a href="#">HTML</a>
                  </li>
                  <li>
                    <a href="#">Freebies</a>
                  </li> -->
                </ul>
              </div>
              <!-- <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">JavaScript</a>
                  </li>
                  <li>
                    <a href="#">CSS</a>
                  </li>
                  <li>
                    <a href="#">Tutorials</a>
                  </li>
                </ul>
              </div> -->
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Popular Tags</h5>
          <div class="card-body">
            <ul class="list-unstyled mb-0">
            <?php
              foreach($Tags as $row)
              {
                  ?>
                  <li class="tag_">
                  <a class="size1" href="<?php echo site_url();?>search/tag/<?php echo $row;?>"><?php echo $row;?> </a>
                  </li>
                  <?php
              }
            ?>
           </ul>
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; BLOG 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <!-- <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

</body>

</html>
