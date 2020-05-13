<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <!-- bootsrap files -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
  <!-- bootstrap files for blog -->
  <!-- Bootstrap core CSS -->
  <!-- <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom styles for this template -->
  <!-- <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet"> -->

  <!-- Bootstrap core JavaScript -->
  <!-- <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script> -->
  <!-- <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

  <!-- Bootstrap core CSS from assetes folder -->
  <link href="<?php echo site_url();?>application/assets/bootstrap-blog/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo site_url();?>application/assets/bootstrap-blog/blog-post.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo site_url();?>application/assets/bootstrap-blog/jquery.min.js"></script>
  <script src="<?php echo site_url();?>application/assets/bootstrap-blog/bootstrap.bundle.min.js"></script>
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
    <!-- style="border:thick solid black;background-color:#e9ecef" -->
    <!-- <h1 class="jumbotron text-center">Home</h1>
    <div class="container"> -->
        <!-- this is navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
       <div class="container">
            <a class="navbar-brand" href="#">Blog</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <!-- <a class="nav-link" href=""> -->
                    <?php
               foreach($user_list as $row)
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
            <?php
               foreach($user_list as $row)
               {
                 if($row->id==$_SESSION['id'])
                 {
                  ?>
                  <a class="nav-link" href="<?php echo site_url();?><?php echo $row->username ;?>/drafts">Drafts</a>
                  <?php
                 }
               }
               ?>
               <!-- <a class="nav-link" href="<?php echo site_url();?>post/get_drafts">Drafts</a> -->
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url();?>home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url();?>files">Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url();?>user/logout">Logout</a>
                </li>
                </ul>
            </div>
       </div>
       <!-- <a class="navbar-brand" href="<?php echo site_url();?>/user/logout">logout</a>
       <a class="navbar-brand" href="<?php echo site_url();?>home">home</a> -->
    </nav>
    </div>
    <!-- content page -->
    <div class="container">
        <!-- class row div -->
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mt-4">HOME</h1>
                <!-- Author -->
                    <p class="lead">
                    for
                    <a href="#">Recent Blogs</a>
                    </p>

                    <hr>

                    <!-- Date/Time -->
                    <p>today's date</p>

                    <hr>

                    <!-- Preview Image -->
                    <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

                    <hr>

                    <!-- Post Content -->
                    <p class="lead"></p>

                    <p></p>

                    <p></p>

                    <blockquote class="blockquote">
                    <p class="mb-0"></p>
                    <footer class="blockquote-footer">
                        <cite title="Source Title"></cite>
                    </footer>
                    </blockquote>

                    <hr>

                    <?php
                        if(isset($feed))
                        {
                            if($feed==0)
                            {
                                ?>
                                <h3>No recent posts</h3>
                                <?php
                            }
                            else if($feed!==0)
                            {
                                // $i=$key-1;
                                foreach($feed as $row)
                                {
                                    if(is_array($row))
                                    {
                                        foreach($row as $data)
                                        {
                                            if(is_array($data))
                                            {
                                                echo "mk";
                                                print_r($data);

                                                // foreach($data as $info)
                                                // {
                                                    ?>
                                                        <!-- feed Form -->
                                                            <div class="card my-4">
                                                                <h5 class="card-header"><i><?php echo $data[0]->title; ?></i> By <?php echo $row["username"]  ;?></h5>
                                                                <div class="card-body">
                                                                <form>
                                                                    <div class="form-group">
                                                                    <div><?php echo $data[0]->content ;?></div>
                                                                    </div>
                                                                    <a href="<?php echo $row["username"]  ;?>" class="btn btn-primary">show blogs</a>
                                                                    <a href="<?php echo $row["username"]  ;?>/<?php echo $data[0]->blog_url;?>" class="btn btn-primary">Read Post</a>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        <!-- feed form end -->
                                                        <!-- <button type="submit" class="btn btn-primary">Submit</button>#editpost<?php echo $data[0]->id;?> -->
                                                    <?php
                                                // } 
                                            } 
                                        }    
                                    }   
                                    // $i=$i-1;
                                }
                                // echo "<pre>";
                                // print_r($feed);
                            }
                            
                        }
                        else if(isset($db_feed))
                            {echo "mk";
                                // 
                                foreach($db_feed as $row)
                                {
                                    if(is_array($row))
                                    {
                                        foreach($row as $data)
                                        {
                                            // if(is_array($data))
                                            // {
                                                // echo "<pre>";
                                                // print_r($data);

                                                // foreach($data as $info)
                                                // {
                                                    ?>
                                                        <!-- feed Form -->
                                                            <div class="card my-4">
                                                                <h5 class="card-header"><i><?php echo $data->title; ?></i> By <?php //echo $row["username"]  ;?></h5>
                                                                <div class="card-body">
                                                                <form>
                                                                    <div class="form-group">
                                                                    <div><?php echo $data->content ;?></div>
                                                                    </div>
                                                                    <!-- <a href="<?php echo $row["username"]  ;?>" class="btn btn-primary">show blogs</a>
                                                                    <a href="<?php echo $row["username"]  ;?>/<?php echo $data->blog_url;?>" class="btn btn-primary">Read Post</a> -->
                                                                </form>
                                                                </div>
                                                            </div>
                                                        <!-- feed form end -->
                                                        <!-- <button type="submit" class="btn btn-primary">Submit</button>#editpost<?php echo $data->id;?> -->
                                                    <?php
                                                // } 
                                            // } 
                                        }    
                                    }   
                                    // $i=$i-1;
                                }
                            }
                            // echo "<pre>";
                            // print_r($db_feed);
                    ?>
            </div>
            
            <!-- Sidebar Widgets Column -->
            <div class="col-md-4"> 
                <!-- Search Widget -->
                <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                    <form  action="<?php echo site_url();?>search/do_search" method="post">
                        <div class="form-group">
                           <input type="text" id="search" name="search_keyword" class="form-control" placeholder="Search by tags only">
                        </div>
                        <span class="input-group-btn">
                        <input class="btn btn-secondary" type="submit" name="search" value="Go!">
                            <!-- <button class="btn btn-secondary" type="button">Go!</button> -->
                        </span>
                    </form>
                    </div>
                </div>
                </div>

                <!-- user list Widget -->
                <div class="card my-4">
                <h5 class="card-header">Users</h5>
                <div class="card-body">
                    <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                        <?php
                            if(isset($user_list))
                            {
                                //    
                                foreach ($user_list as $row) 
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
                        </ul>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Side Widget -->
                <div class="card my-4">
                <h5 class="card-header">Popular Tags </h5>
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
            <!-- side widgets column end -->
        </div>
        <!-- class row div end -->
       <!-- users's list -->
       <!-- <ul class="container">
       <?php
    //    if(isset($user_list))
    //    {
    //     //    
    //        foreach ($user_list as $row) 
    //        {
    //            if($row->id==$_SESSION['id'])
    //            {
                   ?>
                   <li><a href="<?php echo site_url();?><?php echo $row->username ;?>">My blog</a></li>
                   <?php
            //    }
            //    else
            //    {
               ?>
               <li><a href="<?php echo site_url();?><?php echo $row->username ;?>"><?php echo $row->username;?>'s blog</a></li>
               <?php
    //            }
    //        }
    //     //    print_r($user_list);
    //    }
       ?>
    </ul> -->
    </div>
    <!-- content page end -->
    <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; BLOG 2020</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- footer ends -->
</body>
</html>