<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- bootsrap files -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
  <!-- <script src="https://static1.squarespace.com/static/sitecss/50363cf324ac8e905e7df861/634/55f0aac0e4b0f0a5b7e0b22e/5e844f843f1eeb2f755f59d9/336-05142015/1586423749963/site.css?&filterFeatures=false"></script> -->
    <!-- bootsrap files for blogs -->
    <!-- Bootstrap core CSS -->
      <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet">

      <!-- Bootstrap core JavaScript -->
      <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script>
      <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script>
      // function check_login()
      // {
      //    var username=document.forms["loginform"]["username"].value
      //    var password=document.forms["loginform"]["password"].value;
      //    if(username.length<1)
      //    {
      //       document.getElementById('error').innerHTML="username or password empty";
      //       return false;
      //    }
      //    else if(password.length<1)
      //    {
      //       document.getElementById('error').innerHTML="username or password empty";
      //       return false;
      //    }
      //    else
      //    {
      //       var value=login_ajax(username,password);
      //       if(value==1)
      //       {
      //          return true;
      //       }
      //       else
      //       {
      //          document.getElementById('error').innerHTML="username or password invalid";
      //          return false;
      //       }
      //    }
      // }
      // function login_ajax(username,password)
      // {
      //    check=new XMLHttpRequest();
            
      //       check.onreadystatechange=function()
      //       {
      //          if(check.readyState==4  && check.status==200)
      //          {
      //                // document.getElementById('error').innerHTML=check.responseText;
      //                if(check.responseText=='1')
      //                {
      //                   return 1;
      //                }
      //                else
      //                {
      //                   return false;
      //                }
      //                //showpost.innerHTML=post.responseText;
      //          }
      //       }

      //       check.open("GET","<?php echo base_url(); ?>login/verify_login/"+username+"/"+password,true);
      //       check.send(null);
      // }
      $(document).ready(function() {
         $('#submit').click(function(e) {
            e.preventDefault();
            var username=$("#username").val();
            var password=$("#password").val();
            if(username.length<1)
            {
               document.getElementById('error').innerHTML="username or password empty";
            }
            else if(password.length<1)
            {
               document.getElementById('error').innerHTML="username or password empty";
            }
            else
            {
               $.ajax({
                     type: "POST",
                     url: '<?php echo site_url() ;?>login/verify_login',
                     data: {username: username,password: password},
                     dataType: 'json',
                     success: function(data)
                     {
                        if (data === 'login') 
                        {
                         window.location.href = '<?php echo site_url();?>home';
                        }
                      else 
                      {
                        // alert('Invalid Credentials');
                        document.getElementById('error').innerHTML="username or password invalid";
                      }
                    }
               });
            }
           });
       });
      </script>
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
         <a class="navbar-brand" href="#">Blog</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="<?php echo site_url();?>register">Register
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
      <!-- div class row -->
      <div class="row">
         <div class="col-lg-8">
             <h1 class="mt-4">Get Started</h1>
             <!-- <form action="<?php echo base_url()?>login/verify_user" method="post" >
                  <table>
                     <tr>
                        <td>userame</td><td><input type="text" name="username"></td>
                     </tr>
                     <tr>
                        <td>password</td><td><input type="password" name="password"></td>
                     </tr>
                     <tr>
                        <td><input type="submit" class="btn btn-info" name="login" value="login"></td>
                     </tr>
                     
                  </table>
               </form> -->
               <div class="col-md-6" >
                  <div class="card my-4">
                     <h5 class="card-header">Login</h5>
                     <div class="card-body">
                     <div class="input-group">
                        <!-- action="<?php echo base_url()?>login/verify_user" -->
                        <!-- onsubmit="return check_login()" -->
                     <form id="loginform" method="post" >
                        <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="password">
                        </div>
                        <span class="input-group-btn">
                           <input class="btn btn-secondary" type="submit" id="submit" name="login" value="Login!">
                        </span>
                        <div id="error"></div>
                        <?php
                     if(isset($is_user))
                     {
                        echo "<br>";
                        print_r($is_user);
                     }
                     ?>
                  </form>   
                     </div>
                     </div>
                  </div>
               </div>   
         </div>
         
      </div>
        
        <!-- <a href="<?php echo site_url();?>register">register here</a> -->
   </div>
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