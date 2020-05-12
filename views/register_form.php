<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <!-- <script src="main.js"></script> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
  <!-- bootsrap files for blogs -->
    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
         function check_field()
         {
            var username=document.getElementById('username').value;
            var password=document.getElementById('password').value; 
            if(username.length<1)
            {
                document.getElementById('info').innerHTML="username or password empty";
                return false;
            }
            else if(password.length<1)
            {
                document.getElementById('info').innerHTML="username or password empty";
                return false;
            }
            else
            {
                return true;
            }
         }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
         <a class="navbar-brand" href="#">Blogs</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="<?php echo site_url();?>">Login
               <span class="sr-only">(current)</span>
               </a>
            </li>
            <!-- <li class="nav-item">
               <a class="nav-link" href="<?php echo site_url();?>/user/logout">Logout</a>
            </li> -->
            <!-- <li class="nav-item">
               <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Contact</a>
            </li> -->
            </ul>
         </div>
      </div>
</nav>
    <div class="container">
        <!-- row class div -->
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mt-4">New User</h1>
                <div class="col-md-6" >
                    <div class="card my-4">
                        <h5 class="card-header">Register here</h5>
                        <div class="card-body">
                            <div class="input-group">
                                <form action="<?php echo base_url()?>register/register_user" onsubmit="return check_field()" method="post" >
                                    <div class="form-group">
                                    <input type="text" id="username" name="username" class="form-control" placeholder="username">
                                    </div>
                                    <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="password">
                                    </div>
                                    <span class="input-group-btn">
                                    <input class="btn btn-secondary" type="submit" name="register" value="register">
                                    </span>
                                    <div id="info"></div>
                                </form>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row class div -->
        <!-- <form action="<?php echo base_url();?>register/register_user" method="post">
           <table>
               <tr>
                  <th colspan="2">Registration</th>
               </tr>
               <tr>
                  <td>Enter username</td><td><input type="text" name="username"></td>
               </tr>
               <tr>
                   <td>Enter password</td><td><input type="password" name="password"></td>
               </tr>
               <tr>
                  <td colspan="2"><input type="submit" class="btn btn-info" name="register" value="register"></td>
               </tr>
           </table>
        </form>
        <a href="<?php echo site_url();?>">login</a> -->
    </div>
    <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; BLOGS 2020</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- footer ends -->
</body>
</html>