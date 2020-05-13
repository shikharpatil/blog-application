<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Drafts</title>

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
      function get_editor(num)
  {
	  // new FroalaEditor('textarea#froala-editor'+num)
  new FroalaEditor('.selector'+num, {

    toolbarButtons: {
    // Key represents the more button from the toolbar.
    moreText: {
      // List of buttons used in the  group.
      buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],

      // Alignment of the group in the toolbar.
      align: 'left',

      // By default, 3 buttons are shown in the main toolbar. The rest of them are available when using the more button.
      buttonsVisible: 13
    },


    moreParagraph: {
      buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote'],
      align: 'left',
      buttonsVisible: 10
    },

    moreRich: {
      buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR'],
      align: 'left',
      buttonsVisible: 5
    },

    moreMisc: {
      buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
      align: 'right',
      buttonsVisible: 2
    }
  },

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

    events: {
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
  function get_textarea(id,num)
  {
    // document.getElementById("getEditor"+num).innerHTML="<textarea class='text' name='data'></textarea>";
    var data="/"+id+"/"+num;
    post=new XMLHttpRequest();
            
    post.onreadystatechange=function()
    {
        if(post.readyState==4  && post.status==200)
        {
               document.getElementById('getEditor'+num).innerHTML=post.responseText;
               //showpost.innerHTML=post.responseText;
               document.getElementById('drafts_button'+num).style.visibility = 'hidden';
               get_editor(num);
        }
    }

    post.open("GET","<?php echo base_url(); ?>post/get_textarea/"+id+"/"+num,true);
    post.send(null);

    // get_editor(num);
  }

//   function to cancel draft editing
function cancel_draft_edit(num,post_id)
{
    // alert(num);
    post=new XMLHttpRequest();
            
    post.onreadystatechange=function()
    {
        if(post.readyState==4  && post.status==200)
        {
               document.getElementById('getEditor'+num).innerHTML=post.responseText;
              document.getElementById('drafts_button'+num).style.visibility ='visible';
               //showpost.innerHTML=post.responseText;
        }
    }

    post.open("GET","<?php echo base_url(); ?>post/cancel_draft_edit/"+num+"/"+post_id,true);
    post.send(null);
}

// function to publish post
function publish_post(post_id)
{
    var bool= confirm("do you want to publish post")
	  if(bool==true)
	  {
        $.ajax({
          type: "POST",
          url: "http://localhost/blog/post/publish_post",
          data:{post_id : post_id},
          dataType:'json',
          success: function(data)
          {
                if(data[0]=="Draft is published")
                {
                    alert("Draft is published");
                }
                else
                {
                    alert(data);
                }
                // window.location.reload();
                window.location.href = 'http://localhost/blog/'+data[1];
          }
        });
	  }
	  else
	  {
        return false
    }
}
  function delete_draft()
  {
    // 
    var bool= confirm("do you want to delete")
	  if(bool==true)
	  {
		    return true
	  }
	  else
	  {
        return false
    }
  }
  </script>

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
            <a class="nav-link" href="<?php echo site_url();?>/user/logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- main container div  -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">Drafts</h1>

        <!-- Author -->
        <!-- <p class="lead">
          by
          <a href="#">Start Bootstrap</a>
        </p> -->

        <hr>

        <!-- Date/Time -->
        <!-- <p>Posted on January 1, 2019 at 12:00 PM</p> -->

        <!-- <hr> -->

        <!-- Preview Image -->
        <!-- <img class="img-fluid rounded" src="http://placehold.it/900x300" alt=""> -->
       

        <!-- <hr> -->

        <!-- Post Content -->
        <p class="lead"></p>

        <?php
         if(isset($data)==null)
         {
           ?>
              <blockquote class="blockquote">
                <p class="mb-0">No Drafts yet</p>
                <!-- <footer class="blockquote-footer">Someone famous in
                  <cite title="Source Title">Source Title</cite>
                </footer> -->
              </blockquote>
            <?php  
         }
         else
         {
          // echo "<pre>";
          // print_r($data);
          // die();
           $i=0;
           foreach($data as $row)
           {
             $num=$i+1;
            //  if(count($row)==1)
            //  {
             ?>
                <!-- show blog post -->
                <div class="card my-4">
                  <h5 class="card-header"><?php echo $num.")".$row->created_timestamp;?></h5>
                  <div class="card-body">
                    <form id="editdraft<?php echo $row->id ;?>" method="post" action="<?php echo site_url(); ?>post/edit_drafts">
                        <div class="form-group">
                          <div id="getEditor<?php echo $num ;?>"><?php echo $row->content; ?>
                          </div>
                        </div>
                            <input type="hidden" name="post_id" value="<?php echo $row->id; ?>" >
                            <!-- <input type="hidden" name="user_id" value="<?php echo $row->user_id; ?>" > -->
                            <!-- <input type="hidden" name="title" value="<?php echo $row->title; ?>" > -->
                            <!-- <input type="hidden" name="blog_url" value="<?php echo $row->blog_url; ?>" > -->
                            <!-- <input type="hidden" name="version" value="<?php //echo count($row); ?>" > -->
                      <!-- <div class="form-group">
                        <textarea class="form-control" rows="3"></textarea>
                      </div> -->
                      <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                      <?php
                        if($_SESSION['id']==$user_id)
                        {
                            ?>
                            <div id="drafts_button<?php echo $num ;?>">
                            <a href="javascript:void(0)" class="btn btn-info" onclick="get_textarea(<?php echo $row->id; ?>,<?php echo $num; ?>)" >edit</a>
                            <!-- <a href="<?php echo base_url();?>post/delete_blog/<?php echo $row->id; ?>" class="btn btn-info" onclick="return delete_draft()">delete</a> -->
                            <a href="javascript:void(0)" class="btn btn-info" onclick="publish_post(<?php echo $row->id;?>)">Publish Post</a>
                            </div>
                            <?php
                        }
                      ?>
                    </form>
                  </div>
                </div>
                <!-- show blog post end -->
             <?php
            //  }
             $i++;
           }
           ?>
           <?php
         }
      ?>

        <!-- <blockquote class="blockquote">
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
          <footer class="blockquote-footer">Someone famous in
            <cite title="Source Title">Source Title</cite>
          </footer>
        </blockquote> -->

        <hr>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <!-- <input type="text" class="form-control" placeholder="Search for..."> -->
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

        <!-- Userlist Widget -->
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
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
