<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Blog Post - Files</title>

  <!-- Bootstrap core CSS -->
  <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom styles for this template -->
  <!-- <link href="css/blog-post.css" rel="stylesheet"> -->

  <!-- Bootstrap core JavaScript -->
  <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
  <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

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
            <!-- <a class="nav-link" href="#"> -->
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
            <a class="nav-link" href="<?php echo site_url();?>user/logout">Logout</a>
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
        <h1 class="mt-4">Files</h1>

        <!-- Author -->
        <!-- <p class="lead">
          by
          <a href="#">Start Bootstrap</a>
        </p> -->

        <hr>
        <p>
          <strong>Create directory</strong> :<span style="color:red">
          <?php
          if(isset($sub_name))
          {
            if(!empty($sub_name))
            {
              print_r($sub_name);
            }
          }
          ?>
          </span>
          <div class="input-group">
          
            <form action="<?php echo site_url();?>/files/sub_create" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="sub_dir_name">
              </div>
              <div class="input-group-btn">
                <input class="btn btn-secondary" type="submit" name="create" value="Create">
              </div>
            </form>
          </div>
        </p>  
        <hr>
        <p>
        <?php 
        if(isset($directories))
        {
          if($directories==0)
          {
            echo "<strong>no user directory</strong>";
          }
          else if(empty($directories))
          {
            // print_r($directories);
            echo "<strong>no sub directories</strong>";
          }
          else
          {
            $root="application/uploads/".$_SESSION["id"];
            echo "<div><strong>Select Directory : </strong></div>";
            // print_r($directories);
            ?>
            <!-- <span class="size1">
                <form action="<?php echo site_url();?>files/set_dir_path" method="post">
                  <input type="hidden" name="dir_path" value='<?php echo $root ;?>' >
                  <input type="hidden" name="dir_name" value="root" >
                  <div class="input-group-btn">
                  <input class="btn btn-secondary" type="submit" name="get_dir" value="root">
                  </div>
                </form>
            </span>   -->
            <?php
            foreach($directories as $row)
            {
              ?>
              <span class="size1">
                <form action="<?php echo site_url();?>files/set_dir_path" method="post">
                  <input type="hidden" name="dir_path" value="<?php echo $row[1];?>" >
                  <input type="hidden" name="dir_name" value="<?php echo $row[0];?>" >
                  <div class="input-group-btn">
                  <input class="btn btn-secondary" type="submit" name="get_dir" value="<?php echo $row[0];?>">
                  </div>
                </form>
              </span>  
              <?php
            }
          }
        }
        ?></p>
        <br>
        <hr>
        <!-- Date/Time -->
        <p>
        <strong>Current Upload Directory</strong> >> 
        <?php
        //  echo $_SESSION["current_path"];
         $dir_current=explode("application/uploads/".$_SESSION["id"]."/",$_SESSION["current_path"]);
        //  print_r($dir_current);
         if($dir_current[0]=="application/uploads/".$_SESSION["id"])
         {
            echo "root";
         }
         elseif($directories==0)
         {
           ?>
           <span></span>
           <?php
         }
         else
         {
            ?>
            <span><a href="" ><?php echo $dir_current[1];?></a></span>
            <?php
         } 
         ?>
        <!-- <form action="<?php echo site_url();?>/files/upload_files" method="post" enctype="multipart/form-data">
          <table>
            <tr>
              <td>
                <input type="file" name="upload_file" id="files">
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" class="btn btn-secondary" name="upload" value="upload" >
              </td>
            </tr>
          </table>
        </form> -->
        <div>
        <?php
        if($error==!0)
        {
          ?>
          <div style="color:red"> <?php print_r($error);?></div>
          <?php
        }
        ?>
        </div>
        <div class="input-group">
          <form  action="<?php echo site_url();?>files/upload_files" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <input type="file" id="files" name="upload_file" class="form-control" >
                  <input type="hidden" name="current_set_path" value="<?php echo $_SESSION["current_path"];?>" >
                  <input type="hidden" name="upload_dir_name" value="<?php echo $dir_current[1];?>" >
              </div>
              <div class="input-group-btn">
                  <input class="btn btn-secondary" type="submit" name="upload" value="Upload">
                  <!-- <button class="btn btn-secondary" type="button">Go!</button> -->
              </div>
          </form>
        </div>
        </p>
        <hr>
        <p>
            <?php
            if(!empty($directories) || $directories!==0)
            {
                // echo $_SESSION["current_path"];
                $dir_current=explode("application/uploads/".$_SESSION["id"]."/",$_SESSION["current_path"]);
                //  print_r($dir_current);
                if($dir_current[0]=="application/uploads/".$_SESSION["id"])
                {
                    echo "root";
                }
                else
                {
                    ?>
                    <span><strong> Files from Directory : </strong><a href="" ><?php echo $dir_current[1];?></a></span>
                    <?php
                }
            } 
            ?>
        </p>    
        
        
        <!-- <hr> -->
        <!-- Preview Image -->
        <!-- <img class="img-fluid rounded" src="http://placehold.it/900x300" alt=""> -->
        
        <!-- <hr> -->

        <!-- files info -->
        <p class="lead">
          <?php
          if(isset($files_info))
          {
            if(empty($files_info))
            {
              ?>
                <p>No Files Uploaded</p>
              <?php
            }
            else
            {
              ?>
                <table class="table">
                  <tr>
                    <th scope="col">S.no</th>
                    <!-- <th scope="col">File</th> -->
                    <th scope="col">Name</th>
                    <th scope="col">Extension</th>
                    <th scope="col">Size</th>
                  </tr>
                  <?php
                  $num=1;
                   foreach($files_info as $row)
                   {
                     ?>
                       <tr>
                         <td><?php echo $num;?></td>
                         <!-- <td><img src="<?php site_url()?><?php echo $row->path;?>" alt="not available" height="30px" width="30px"></td> -->
                         <td><?php echo $row->name;?></td>
                         <td><?php echo $row->extension;?></td>
                         <td><?php echo $row->size;?></td>
                       </tr>
                     <?php
                     $num++;
                   }
                  ?>
                </table>
              <?php
            }
          } 
          ?>
        </p>

        <!-- <p></p> -->

        <!-- <p></p> -->

        <!-- <blockquote class="blockquote">
          <p class="mb-0"></p>
          <footer class="blockquote-footer">
            <cite title="Source Title">Source Title</cite>
          </footer>
        </blockquote> -->

        <!-- <p></p> -->

        <!-- <p></p> -->

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

</body>

</html>
