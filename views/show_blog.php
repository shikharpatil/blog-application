<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootsrap files -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
  <!-- froala files -->
	<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js">
</script>
<!-- project's css -->
<link rel="stylesheet" href="<?php echo base_url();?>uploads/style.css">
<!-- bootsrap files for blogs -->
    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo site_url();?>blog-bootsrap/css/blog-post.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo site_url();?>blog-bootsrap/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo site_url();?>blog-bootsrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- files for tags -->
    <link rel="stylesheet" href="<?php echo site_url();?>blog-bootsrap/OpenJS-Tags-master/tags.css">
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
		<script type="text/javascript" src="<?php echo site_url();?>blog-bootsrap/OpenJS-Tags-master/tags.js"></script>
		<script>
			$(function() {
				$("#tagsinput").tags({
          unique: true,
          maxTags: 10
				});
			});
		</script>
    <script>
      $(document).ready(function() {
         $('#submit').click(function(e) {
            e.preventDefault();
            var title=$("#title").val();
            var content=$("#froala-editor").val();
            var applied_tags=$("#tagsinput").val();
            if(title.length<1)
            {
               document.getElementById('title_error').innerHTML="title or content empty";
            }
            else if(content.length<1)
            {
               document.getElementById('title_error').innerHTML="title or content empty";
            }
            else
            {
               $.ajax({
                     type: "POST",
                     url: '<?php echo site_url() ;?>post/save_blog',
                     data: {title: title,content: content,applied_tags: applied_tags},
                     dataType: 'json',
                     success: function(data)
                     {
                        if (data === 'false') 
                        {
                      
                         document.getElementById('title_error').innerHTML="title already exists";
                        }
                      else 
                      {
                        // alert('Invalid Credentials');
                        window.location.href = '<?php echo site_url();?>'+data;
                        // document.getElementById('error').innerHTML="username or password invalid";
                      }
                    }
               });
            }
           });
       });

       $(document).ready(function() {
         $('#drafts').click(function(e) {
            e.preventDefault();
            var title=$("#title").val();
            var content=$("#froala-editor").val();
            var applied_tags=$("#tagsinput").val();
            if(title.length<1)
            {
               document.getElementById('title_error').innerHTML="title or content empty";
            }
            else if(content.length<1)
            {
               document.getElementById('title_error').innerHTML="title or content empty";
            }
            else
            {
               $.ajax({
                     type: "POST",
                     url: '<?php echo site_url() ;?>post/save_as_drafts',
                     data: {title: title,content: content,applied_tags: applied_tags},
                     dataType: 'json',
                     success: function(data)
                     {
                        if (data === 'false') 
                        {
                      
                         document.getElementById('title_error').innerHTML="title already exists";
                        }
                      else 
                      {
                        // alert('Invalid Credentials');
                        window.location.href = '<?php echo site_url();?>'+data+'/drafts';
                        // document.getElementById('error').innerHTML="username or password invalid";
                      }
                    }
               });
            }
           });
       });
      //  $(documnet).ready(function(){
        // $("input").val();
        // $("input").tagsinput('items')
      //  });
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
<!-- main container div -->
<div class="container">
  <!-- div for row -->
  <div class="row">
    <div class="col-lg-8">
      <?php
        if(isset($data)!==null)
        {
          if($_SESSION['id']==$user_id)
          {
            ?>
              <h1 class="mt-4">Create Post</h1>
              <hr>
                <div class="container">
                  <!-- action="<?php echo site_url(); ?>user/save_blog" -->
                  <form id="editor-data" class="form-main" method="post"  enctype="multipart/form-data" >
                  <hr>
                  <p>Title :</p><p id="title_error"></p>
                  <textarea class="form-control form-rounded" name="title" id="title" cols="50" rows="3" maxlength="100"></textarea>
                  <hr>
                  <p>Content :</p>
                    <textarea id="froala-editor" name="content" class="selector"></textarea>
                    <hr>
                    <p>Add Tags :</p>
                    <input type="hidden" name="applied_tags" id="tagsinput" value=""/>
                    <!-- <div><input type="text" name="tags"  id="tags" class="form-control"></div> -->
                    <br/>
                    <div>
                    <input type="submit" id="submit" class="btn btn-info" name="save" value="save">
                    <input type="submit" id="drafts" class="btn btn-info" name="save_as_drafts" value="Save as Drafts">
                    </div>
                    <!-- <div></div> -->
                  </form>
                </div>
                <!-- Author -->

                <hr>

                <p class="lead">
                   <h4>My Posts</h4>
                </p>

                <hr>
            <?php
          }
          else
          {
            ?>
              <h1 class="mt-4">blog</h1>

              <!-- Author -->

              <hr>
                
                <p class="lead">
                   <h4><?php echo $username;?>'s Posts</h4>
                </p>

              <hr>
            <?php
          }
        }
      ?>
      <?php
         if(isset($data)==null)
         {
           ?>
              <blockquote class="blockquote">
                <p class="mb-0">No posts yet</p>
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
             if(count($row)==1)
             {
             ?>
                <!-- show blog post -->
                <div class="card my-4">
                  <h5 class="card-header"><?php echo $num.")".$row[0]["created_timestamp"];?></h5>
                  <div class="card-body">
                    <form id="editpost<?php echo $row[0]["id"] ;?>" method="post" action="<?php echo site_url(); ?>post/update_blog">
                        <div class="form-group">
                          <div id="getEditor<?php echo $num ;?>"><?php echo $row[0]["content"]; ?>
                          </div>
                        </div>
                            <input type="hidden" name="parent_id" value="<?php echo $row[0]["id"]; ?>" >
                            <!-- <input type="hidden" name="user_id" value="<?php echo $row[0]["user_id"]; ?>" > -->
                            <input type="hidden" name="title" value="<?php echo $row[0]["title"]; ?>" >
                            <input type="hidden" name="blog_url" value="<?php echo $row[0]["blog_url"]; ?>" >
                            <input type="hidden" name="version" value="<?php echo count($row); ?>" >
                      <!-- <div class="form-group">
                        <textarea class="form-control" rows="3"></textarea>
                      </div> -->
                      <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                      <?php
                        if($_SESSION['id']==$user_id)
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-info" onclick="get_textarea(<?php echo $row[0]['id']; ?>,<?php echo $num; ?>)" >edit</a> -->
                            <a href="<?php echo base_url();?>post/delete_blog/<?php echo $row[0]["id"]; ?>" class="btn btn-info" onclick="return delete_post()">delete</a>
                            <?php
                        }
                      ?>
                      <a href="<?php echo base_url();?><?php echo $username  ;?>/<?php echo $row[0]["blog_url"];?>" class="btn btn-info">Read Post</a>
                    </form>
                  </div>
                </div>
                <!-- show blog post end -->
             <?php
             }
             else
             {
               $version=count($row);
               $latest=$version-1;
               ?>
                 <!-- show blog post -->
                <div class="card my-4">
                  <h5 class="card-header"><?php echo $num.")".$row[$latest]["created_timestamp"];?></h5>
                  <div class="card-body">
                    <form id="editpost<?php echo $row[$latest]["id"] ;?>" method="post" action="<?php echo site_url(); ?>post/update_blog">
                        <div class="form-group">
                          <div id="getEditor<?php echo $num ;?>"><?php echo $row[$latest]["content"]; ?>
                          </div>
                        </div>
                            <input type="hidden" name="parent_id" value="<?php echo $row[$latest]["id"]; ?>" >
                            <!-- <input type="hidden" name="user_id" value="<?php echo $row[$latest]["user_id"]; ?>" > -->
                            <input type="hidden" name="title" value="<?php echo $row[$latest]["title"]; ?>" >
                            <input type="hidden" name="blog_url" value="<?php echo $row[$latest]["blog_url"]; ?>" >
                            <input type="hidden" name="version" value="<?php echo $version; ?>" >
                      <!-- <div class="form-group">
                        <textarea class="form-control" rows="3"></textarea>
                      </div> -->
                      <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                      <?php
                        if($_SESSION['id']==$user_id)
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-info" onclick="get_textarea(<?php echo $row[$latest]['id']; ?>,<?php echo $num; ?>)" >edit</a> -->
                            <a href="<?php echo base_url();?>post/delete_blog/<?php echo $row[$latest]["id"]; ?>" class="btn btn-info" onclick="return delete_post()">delete</a>
                            <?php
                        }
                        // echo $version;
                      ?>
                      <!-- <a href="javascript:void(0)" class="btn btn-info" onclick="get_versions(<?php echo $row[$latest]['parent_id'];?>,<?php echo $num;?>)" >show previous</a> -->
                      <a href="<?php echo base_url();?><?php echo $username  ;?>/<?php echo $row[$latest]["blog_url"];?>" class="btn btn-info">Read Post</a>
                    </form>
                  </div>
                </div>
                <!-- show blog post end -->
               <?php
             }
             $i++;
           }
           ?>
           <?php
         }
      ?>
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
  <!-- div for row ends -->
</div>
<!-- main container div ends -->
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; BLOG 2020</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- footer ends -->
    	    
    <!-- <div class="container">
	    <div class="navbar navbar-expand-sm bg-light navbar-light">
            <p class="navbar-brand">Blog Posts</p>
        </div>
    </div> -->
    <!-- previous post design start here -->
    <!-- <div class="container">
        <div class="main-post-container">
	       <?php 
                if(isset($data)==null)
                {
       	            echo "<div style='color:black'>no posts</div>";
                }
                else
                {
       	            $i=0;
       	            foreach($data as $row) 
       	            { 
       	   	            $num=$i+1;
       	   	            ?>
       	   	            <div class="container">
       	   	  	            <span><strong><?php echo $num; ?>)</strong></span>
                            <span><?php echo $row->date_time ;?></span>
       	   	  	            <form  id="editpost" method="post" action="<?php echo site_url(); ?>user/update_blog" > -->
                            <!-- div to show post -->
                                <!-- <div class="post-container"><div id="getEditor<?php echo $num ;?>" style="padding:10px"><?php echo $row->content; ?></div></div>
                                    <input type="hidden" name="update" value="<?php echo $row->id; ?>" >
                                    <br/>
                                    <?php
                                         if($_SESSION['id']==$user_id)
                                         {
                                             ?>
                                             <a href="javascript:void(0)" class="btn btn-info" onclick="get_textarea(<?php echo $row->id; ?>,<?php echo $num; ?>)" >edit</a>
                                             <a href="<?php echo base_url();?>user/delete_blog/<?php echo $row->id; ?>" class="btn btn-info" onclick="return delete_post()">delete</a>
                                             <?php
                                         }
                                    ?>
                                    
                            </form>
                        </div>
                        <hr/>
                        <?php
                        $i++; 
                    }
                }
            ?>
        </div>
    </div> --> 
    <!-- previous post design end -->
<script>
//   new FroalaEditor('textarea#froala-editor')
  new FroalaEditor('.selector', {

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
               get_editor(num);
        }
    }

    post.open("GET","<?php echo base_url(); ?>post/get_textarea/"+id+"/"+num,true);
    post.send(null);

    // get_editor(num);
  }
  function delete_post()
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

</body>
</html>