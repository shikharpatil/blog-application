<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Blog</title>
  <?php $this->load->helper("url");?>
  <!-- froala files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" type="text/css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js""></script>
<!-- bootstrap files for blog -->
  <!-- Bootstrap core CSS -->
  <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>application/assets/blog.js"></script>
  
  <script>
  // $(document).ready(function(){
  //   $('#commentSubmit').click(function(e){
  //     e.preventDefault();
  //     var comment=$('#commentContent').val();
  //     var blog_post_id=$('#blog_post_id').val();
  //     var commenter_id=$('#commenter_id').val();
  //     var blogger_id=$('#blogger_id').val();
  //     var blog_url=$('#blog_url').val();
  //     var main_link=$('#main_link').val();
  //     if(comment.length<1)
  //     {
  //       document.getElementById('message').innerHTML="comment can not be empty";
  //     }
  //     else
  //     {
  //       $.ajax({
  //         type:'POST',
  //         url:'<?php echo site_url();?>user/save_comment',
  //         data:{comment: comment,blog_post_id: blog_post_id,commenter_id:commenter_id,
  //         blogger_id: blogger_id,blog_url: blog_url},
  //         dataType:'json',
  //         success:function(data)
  //         {
  //           if(data == 'false')
  //           {
  //             document.getElementById('message').innerHTML="comment could not be posted";
  //           }
  //           else
  //           {
  //             // get username,
  //             // window.location.href = main_link;
  //                window.location.reload();
  //           }
  //         }
  //       });
  //     }
  //   });
  // });
  // function for getting the froala editor
  function get_editor()
  {
	  // new FroalaEditor('textarea#froala-editor'+num)
  new FroalaEditor('#selector', {
    
    // Set the image upload parameter.
    imageUploadParam: 'file',

    // Set the image upload URL.
    imageUploadURL: '<?php echo base_url(); ?>post/upload_image',

    // Additional upload params.
    imageUploadParams: {id: 'froala-editor'},

    // Set request type.
    imageUploadMethod: 'POST',

    // Set max image size to 5MB.
    imageMaxSize: 5 * 1024 * 1024,

    // Allow to upload PNG and JPG.
    imageAllowedTypes: ['jpeg', 'jpg', 'png'],

    events: 
    {
      'image.beforeUpload': function (images) {
        // Return false if you want to stop the image upload.
      },
      'image.uploaded': function (response) {
        // Image was uploaded to the server.
      },
      'image.inserted': function ($img, response) {
        // Image was inserted in the editor.
      },
      'image.replaced': function ($img, response) {
        // Image was replaced in the editor.
      },
      'image.error': function (error, response) {
        // Bad link.
        if (error.code == 1) { alert("link not working") }

        // No link in upload response.
        else if (error.code == 2) { alert("no link to upload") }

        // Error during image upload.
        else if (error.code == 3) { alert("error in upload") }

        // Parsing response failed.
        else if (error.code == 4) { alert("response failed") }

        // Image too text-large.
        else if (error.code == 5) { alert("image too large") }

        // Invalid image type.
        else if (error.code == 6) { alert("invalid image") }

        // Image can be uploaded only to same domain in IE 8 and IE 9.
        else if (error.code == 7) { alert("on same domain") }

        // Response contains the original server response to the request if available.
      }
    }
  });
  }
  // function to get textarea
  function get_textarea(id,blogger_id)
  {
    // document.getElementById("getEditor"+num).innerHTML="<textarea class='text' name='data'></textarea>";
    // var data="/"+id+"/"+num;
    post=new XMLHttpRequest();
            
    post.onreadystatechange=function()
    {
        if(post.readyState==4  && post.status==200)
        {
               document.getElementById('editnow').innerHTML=post.responseText;
              //  document.getElementById('hide').style.visibility = 'hidden';
              document.getElementById('button_operate').innerHTML="<button class='btn btn-primary' style='margin-left:5px' id='cancel_edit' onclick='edit_cancel(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Cancel</button>";
              //  document.getElementById('cancel_edit').style.visibility = 'visible';
               //showpost.innerHTML=post.responseText;
               get_editor();
        }
    }

    post.open("GET","<?php echo base_url(); ?>post/get_textarea_2/"+id+"/"+blogger_id,true);
    post.send(null);

    // get_editor(num);
  }

  // function to check status
  function check_status(post_id,blogger_id)
  {
    post=new XMLHttpRequest();
            
      post.onreadystatechange=function()
      {
        if(post.readyState==4  && post.status==200)
        {
          if(post.responseText=="editable")
          {
            get_textarea(post_id,blogger_id)
          }
          else
          {
            alert(post.responseText+" is editing this post");
          }
            // document.getElementById('editnow').innerHTML=post.responseText;
            // document.getElementById('hide').style.visibility = 'hidden';
            //showpost.innerHTML=post.responseText;
            // get_editor();
        }
      }
  
      post.open("GET","<?php echo base_url(); ?>post/is_locked/"+post_id+"/"+blogger_id,true);
      post.send(null); 
  }

  // function to cancel edit by onclick cancel button and update the post lock status
  function edit_cancel(blog_post_id,blogger_id)
  {
    post=new XMLHttpRequest();
            
    post.onreadystatechange=function()
    {
        if(post.readyState==4  && post.status==200)
        {
               document.getElementById('editnow').innerHTML=post.responseText;
              //  document.getElementById('hide').style.visibility = 'visible';
              // document.getElementById('cancel_edit').style.visibility = 'hidden';
              document.getElementById('button_operate').innerHTML="<button class='btn btn-primary' id='hide' onclick='check_status(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Edit</button>  <button id='move_post_button' class='btn btn-primary' onclick='move_post(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Move</button>  <button id='copy_post_button' class='btn btn-primary' onclick='make_copy(<?php echo $open_blog[0]->id ;?>)'>Copy</button>";
               //showpost.innerHTML=post.responseText;
              //  get_editor();<button id='move_post_button' class='btn btn-primary' onclick='move_post(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Move</button>";
        }
    }

    post.open("GET","<?php echo base_url(); ?>post/cancel_edit/"+blog_post_id+"/"+blogger_id,true);
    post.send(null);
  }

//   function get_dynamic_editor(num)
//   {
//     new FroalaEditor(".edit_comment_content"+num,{
//   toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'underline']
// });
//   }
//  function get_comment_textarea(comment_id,post_id,blogger_id,num)
//  {
//   // 
//   $.ajax({
//           type: "POST",
//           url: "http://localhost/blog/ajaxcall/get_comment_textarea",
//           data:{comment_id : comment_id,post_id : post_id,blogger_id : blogger_id,num : num},
//           dataType:'html',
//           success: function(html)
//           {
//             $("#editcomment"+num).html(html);
//             // document.getElementById('comment_button'+num).innerHTML="<button class='btn btn-info' style='margin-left:5px' id='cancel_comment_edit"+num+"' onclick='cancel_comment("+num+")'>Cancel</button>";
//             get_dynamic_editor(num);
//             $("#comment_button"+num).html("<button class='btn btn-info' style='margin-left:5px' id='cancel_comment_edit"+num+"' onclick='cancel_comment("+comment_id+","+post_id+","+blogger_id+","+num+")'>Cancel</button>");
//           }
//         });
//  }
// function cancel_comment(comment_id,post_id,blogger_id,num)
// {
//    alert("edit is cancelled"+num);
// }
//  function submit_edit_comment(num)
//  {
//   var edited_comment=$('#edited_comment_content').val();
//       var blog_post_id=$('#blog_post_id').val();
//       // var commenter_id=$('#commenter_id').val();
//       var blogger_id=$('#blogger_id').val();
//       // var blog_url=$('#blog_url').val();
//       var comment_id=$('#comment_id'+num).val();
//       if(edited_comment.length<1)
//       {
//         document.getElementById('message').innerHTML="comment can not be empty";
//       }
//       else
//       {
//         $.ajax({
//           type:'POST',
//           url:'http://localhost/blog/ajaxcall/edit_comment',
//           data:{edited_comment: edited_comment,blog_post_id: blog_post_id,comment_id:comment_id,
//           blogger_id: blogger_id},
//           dataType:'html',
//           success:function(data)
//           {
//             if(data == 'false')
//             {
//               document.getElementById('message').innerHTML="comment could not be posted";
//             }
//             else
//             {
//               // get username,
//               // window.location.href = main_link;
//                  $("#comment_made").html(data);
//                 //  $("#commentContent").val('');
//             }
//           }
//         });
//       }
//  }
  // new FroalaEditor("textarea");


  // to get versions through ajax request
  // $(document).ready(function()
  // {
  //   $('#get_pre_version').click(function()
  //   // $('body').on('click','#get_pre_version',function(event))
  //   {
  //     // event.preventDefault();
  //     var posturl=$('#pre_post_url').val();
  //     var blogger_id=$('#blogger_id').val();
  //     // var blog_url=$('#blog_url').val();data:{posturl : posturl,blogger_id : blogger_id},
      
  //     // else
  //     // {
  //       $.ajax({
  //         type:'GET',
  //         url:'<?php echo site_url();?>ajaxcall/get_post_versions/'+posturl+'/'+blogger_id,
  //         cache:false,
  //         dataType:'html',
  //         success:function(data)
  //         {
  //           if(data)
  //           {
  //             // document.getElementById('version').innerHTML=data;
  //             $('#version').html(data);
  //           }
  //           else
  //           {
  //           //   // get username,
  //           //   // window.location.href = main_link;
  //                window.location.reload();
  //           }
  //         }
  //       });
  //     // }
  //   });
  // });

  // $('#version').ready(function()
  // {
  //   $('#get_pre_version').click(function()
  //   // $('body').on('click','#get_pre_version',function(event))
  //   {
  //     // event.preventDefault();
  //     var posturl=$('#pre_post_url').val();
  //     var blogger_id=$('#blogger_id').val();
  //     // var blog_url=$('#blog_url').val();data:{posturl : posturl,blogger_id : blogger_id},
      
  //     // else
  //     // {
  //       $.ajax({
  //         type:'GET',
  //         url:'<?php echo site_url();?>ajaxcall/get_post_versions/'+posturl+'/'+blogger_id,
  //         cache:false,
  //         dataType:'html',
  //         success:function(data)
  //         {
  //           if(data)
  //           {
  //             // document.getElementById('version').innerHTML=data;
  //             $('#version').html(data);
  //           }
  //           else
  //           {
  //           //   // get username,
  //           //   // window.location.href = main_link;
  //                window.location.reload();
  //           }
  //         }
  //       });
  //     // }
  //   });
  // });

  // $(document).ready(function()
  // {
  //   $('#get_next_version').click(function(event)
  //   {
  //     event.preventDefault();
  //     var posturl=$('#next_post_url').val();
  //     var blogger_id=$('#blogger_id').val();
  //     // var blog_url=$('#blog_url').val();
      
  //     // else
  //     // {
  //       $.ajax({
  //         type:'POST',
  //         url:'<?php echo site_url();?>ajaxcall/get_post_versions',
  //         data:{posturl : posturl,blogger_id : blogger_id},
  //         cache:false,
  //         dataType:'html',
  //         success:function(data)
  //         {
  //           if(data)
  //           {
  //             // document.getElementById('version').innerHTML=data;
              
  //             $('#version').html(data);
  //           }
  //           else
  //           {
  //           //   // get username,
  //           //   // window.location.href = main_link;
  //                window.location.reload();
  //           }
  //         }
  //       });
  //     // }
  //   });
  // });
 
  </script>
 <?php
 $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
 "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
 $_SERVER['REQUEST_URI']; 
 ?>
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
            <?php
               foreach($userList as $row)
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
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">
      <div id="version">

        <?php
        if(isset($open_blog))
        {
              // echo "<pre>";
              // print_r($open_blog);
        ?>
          <!-- Title -->
          <h1 class="mt-4"><?php echo $open_blog[0]->title;?></h1>

          <!-- Author -->
          <p class="lead">
            by
            <a href="<?php echo site_url();?><?php echo $username;?>"><?php echo $username;?></a>
          </p>

          <hr>

          <!-- Date/Time -->
          <p><strong>Published on : </strong><?php echo $open_blog[0]->created_timestamp;?>   <strong>Edited on : </strong> <?php echo $open_blog[0]->edited_timestamp;?>  </p>
          <p> <strong>Tags : </strong>
          <?php
          if(isset($tags))
          {
            if($tags==0)
            {
              echo "no tags";
            }
            else
            {
              // print_r($tags);
              // foreach($tags as $row)
              // {
              //   // $string = rtrim(implode(',', $row), ',');
              //   // echo $string;
              // }
              $string = rtrim(implode(',', $tags), ',');
                echo $string;
            }
          }
          ?></p>

          <hr>

          <!-- Preview Image -->
          <!-- <img class="img-fluid rounded" src="http://placehold.it/900x300" alt=""> -->

          <hr>

          <!-- Post Content -->
          <form id="editpost" action="<?php echo site_url(); ?>post/update_blog" method="post">
              <div id="editnow"><p class="lead"><?php echo $open_blog[0]->content; ?></p></div>
              <input type="hidden" name="parent_id" value="<?php echo $open_blog[0]->id; ?>" >
              <input type="hidden" name="user_id" value="<?php echo $open_blog[0]->user_id; ?>" >
              <input type="hidden" name="title" value="<?php echo $open_blog[0]->title; ?>" >
              <input type="hidden" name="blog_url" value="<?php echo $open_blog[0]->blog_url; ?>" >
              <input type="hidden" name="version" value="<?php echo $version_num; ?>" >
          </form>

          <!-- <p> Ut, aecati impe Temporibus, voluptatibus.</p>

          <p>Lorem neque dicta incidunt ullam ea hic p</p> -->

          <!-- <blockquote class="blockquote">
            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <footer class="blockquote-footer">Someone famous in
              <cite title="Source Title">Source Title</cite>
            </footer>
          </blockquote>get_textarea(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>) -->

          <!-- <p>Lorem ipsum dolor sit amet<?php echo site_url();?>user/get_next_versions/<?php echo $open_blog[0]->id;?>/<?php echo $open_blog[0]->user_id;?></p>

          <p>Lorem ipsum dolor sit amet</p><?php echo site_url();?>user/get_versions/<?php echo $open_blog[0]->parent_id;?>/<?php echo $open_blog[0]->user_id;?> -->
          <?php
          if(empty($next_post))
          {
            ?>
              <div id="button_operate" >
                <button class="btn btn-primary" id="hide" onclick="check_status(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)">Edit</button>
                <button id="move_post_button" class="btn btn-primary" onclick="get_blog_list(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)">Move</button>
                <?php
                 if($_SESSION['id']==$open_blog[0]->user_id)
                 {
                   ?>
                   <button id="copy_post_button" class="btn btn-primary" onclick="make_copy(<?php echo $open_blog[0]->id ;?>)">Copy</button>
                   <?php
                 }
                ?>
              </div>
            <?php
          }
          ?>
          
          <!-- <button class="btn btn-primary" id="hide" onclick="check_status(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)">Edit</button> -->
          <!-- <button class='btn btn-primary' style="visibility:hidden" id='cancel_edit' onclick='edit_cancel(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Cancel</button> -->
          <hr>
          <div>
          <?php 
          if(isset($previous_post))
          {
            ?>
            <span><a id="get_pre_version"  href="javascript:void(0);"><<</a><input type="hidden" id="pre_post_url" value="<?php echo $previous_post;?>"></span>  
            <?php
          }
          ?>
          <span style="align-content: center"><?php print_r("current version : ".$version_num);?></span>
          <?php
          if(isset($next_post))
          {
            ?>
            <span ><a id="get_next_version" href="javascript:void(0);">>></a><input type="hidden" id="next_post_url" value="<?php echo $next_post;?>"> </span>
            <?php
            // echo $next_post;
          }
        }
          ?>
          </div>
      </div>
        <hr>
        

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment: <p id="message" style="color:red"></p> </h5>
          <div class="card-body">
            <form id="comment-form" class="form-main" method="post"  enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" name="commenter_id" id="commenter_id" value="<?php echo $_SESSION['id'] ;?>" >
                <input type="hidden" name="blog_post_id" id="blog_post_id" value="<?php echo $open_blog[0]->id ;?>" >
                <input type="hidden" name="blogger_id" id="blogger_id" value="<?php echo $open_blog[0]->user_id ;?>" >
                <input type="hidden" name="blog_url" id="blog_url" value="<?php echo $open_blog[0]->blog_url ;?>" >
                <input type="hidden" name="main_url" id="main_url" value="<?php echo $link;?>" >
                <textarea class="form-control" rows="3" name="comment" id="commentContent" maxlength="500"></textarea>
              </div>
              <input type="submit" id="commentSubmit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>
        <hr>
        <div id="comment_made">
            <?php
            if(empty($comments))
            {
              ?>
                  <!-- Single Comment -->
                  <!-- <div class="media mb-4">
                  <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                  <div class="media-body">
                    <h5 class="mt-0">username</h5>
                    12345677hello
                  </div>
                </div> -->
                <div class="lead">No comments yet</div>
              <?php
            }
            else
            {
              $i=1;
              foreach($comments as $row)
              {
              ?>
                  <!-- Single Comment -->
                  <div class="media mb-4">
                  <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                  <div class="media-body">
                    <h5 class="mt-0"><?php echo $row->username;?></h5>
                     <!-- <textarea name="" id="editcomment<?php echo $i;?>" cols="30" rows="5"></textarea> -->
                     
                     <!-- <form method="post"> -->
                    <div class="comment-container<?php echo $i ;?>">
                        <div id="editcomment<?php echo $i ;?>"><?php echo $row->content; ?>
                        </div>
                    </div>  
                        <input type="hidden" id="comment_id<?php echo $i;?>" value="<?php echo $row->id; ?>" >
                        <!-- <input type="hidden" id="comment_div_id" value="<?php echo $i; ?>" > -->
                        <!-- <input type="hidden" id="comment_blogger_id" value="<?php // echo $row->blogger_id; ?>" > -->
                     <!-- </form> href="javascript:void(0)" -->
                     <?php
                     if($_SESSION["username"]==$row->username)
                     {
                       ?>
                       <span id="comment_button<?php echo $i;?>">
                          <button id="edit_comment_button<?php echo $i;?>" class="btn btn-info" style="margin-top:5px" onclick="get_comment_textarea(<?php echo $row->id; ?>,<?php echo $row->blog_post_id; ?>,<?php echo $open_blog[0]->user_id ;?>,<?php echo $i; ?>)" >edit</button>
                       </span>
                       <?php
                     }
                     ?>
                  </div>
                  </div>
                <hr>
              <?php
              $i++;
              }
            }

            ?>
        </div>  
        

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
            <form action="<?php echo site_url();?>search/do_search" method="post">
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
        <?php
          if(isset($userList))
          {
        ?>
        <!-- User List Widget -->
        <div class="card my-4">
          <h5 class="card-header">Users</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <!-- <li>
                    <a href="#"><?php //echo $userList?></a>
                  </li>
                  <li>
                    <a href="#">HTML</a>
                  </li>
                  <li>
                    <a href="#">Freebies</a>
                  </li> -->
                  <?php
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
                    //  echo "<pre>";
                    //  print_r($userList);
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
        <?php
          }
        ?>

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
        <?php
        // echo "<pre>";
        // print_r($open_blog); 
        // print_r($comments);
      
        ?>

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
