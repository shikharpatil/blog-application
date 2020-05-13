// function get_pre_post(url,blogger_id)
//   {
//     // alert(url);
//     // document.getElementById('version').innerHTML=url;
//     post=new XMLHttpRequest();
            
//     post.onreadystatechange=function()
//     {
//         if(post.readyState==4  && post.status==200)
//         {
//                document.getElementById('version').innerHTML=post.responseText;
//               //  document.getElementById('hide').style.visibility = 'visible';
//               // document.getElementById('cancel_edit').style.visibility = 'hidden';
//               // document.getElementById('button_operate').innerHTML="<button class='btn btn-primary' id='hide' onclick='check_status(<?php echo $open_blog[0]->id ;?>,<?php echo $open_blog[0]->user_id ;?>)'>Edit</button>";
//                //showpost.innerHTML=post.responseText;
//               //  get_editor();
//         }
//     }

//     post.open("GET","<?php echo base_url(); ?>ajaxcall/get_post_versions/"+url+"/"+blogger_id,true);
//     post.send(null);
//   }


// to get versions through ajax request
  $(document).ready(function()
  {
    $('#get_pre_version').click(function()
    // $('body').on('click','#get_pre_version',function(event))
    {
      // event.preventDefault();
      var posturl=$('#pre_post_url').val();
      var blogger_id=$('#blogger_id').val();
      // var blog_url=$('#blog_url').val();
      // '<?php echo site_url();?>ajaxcall/get_post_versions/'+posturl+'/'+blogger_id,
      // else
      // {
        $.ajax({
          type:'POST',
          url:'http://localhost/blog/ajaxcall/get_post_versions',
          data:{posturl : posturl,blogger_id : blogger_id},
          cache:false,
          dataType:'html',
          success:function(data)
          {
            if(data)
            {
              // document.getElementById('version').innerHTML=data;
              $('#version').html(data);
            }
            else
            {
            //   // get username,
            //   // window.location.href = main_link;
                 window.location.reload();
            }
          }
        });
      // }
    });
  });

  $(document).ready(function()
  {
    $('#get_next_version').click(function(event)
    {
      event.preventDefault();
      var posturl=$('#next_post_url').val();
      var blogger_id=$('#blogger_id').val();
      // var blog_url=$('#blog_url').val();
      
      // else
      // {
        $.ajax({
          type:'POST',
          url:'http://localhost/blog/ajaxcall/get_post_versions',
          data:{posturl : posturl,blogger_id : blogger_id},
          cache:false,
          dataType:'html',
          success:function(data)
          {
            if(data)
            {
              // document.getElementById('version').innerHTML=data;
              
              $('#version').html(data);
            }
            else
            {
            //   // get username,
            //   // window.location.href = main_link;
                 window.location.reload();
            }
          }
        });
      // }
    });
  });

  // fucntion to make comments through ajax
  $(document).ready(function(){
    $('#commentSubmit').click(function(e){
      e.preventDefault();
      var comment=$('#commentContent').val();
      var blog_post_id=$('#blog_post_id').val();
      var commenter_id=$('#commenter_id').val();
      var blogger_id=$('#blogger_id').val();
      var blog_url=$('#blog_url').val();
      var main_link=$('#main_link').val();
      if(comment.length<1)
      {
        document.getElementById('message').innerHTML="comment can not be empty";
      }
      else
      {
        $.ajax({
          type:'POST',
          url:'http://localhost/blog/ajaxcall/save_comment',
          data:{comment: comment,blog_post_id: blog_post_id,commenter_id:commenter_id,
          blogger_id: blogger_id,blog_url: blog_url},
          dataType:'html',
          success:function(data)
          {
            if(data == 'false')
            {
              document.getElementById('message').innerHTML="comment could not be posted";
            }
            else
            {
              // get username,
              // window.location.href = main_link;
                 $("#comment_made").html(data);
                 $("#commentContent").val('');
            }
          }
        });
      }
    });
  });

  function get_dynamic_editor(num)
  {
    new FroalaEditor(".edit_comment_content"+num,{
      toolbarButtons: {
        'moreText': {
          'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
        },
        'moreParagraph': {
          'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
        },
        'moreRich': {
          'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
        },
        'moreMisc': {
          'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
        }
      },
      // Set the image upload parameter.
    imageUploadParam: 'file',

    // Set the image upload URL.
    imageUploadURL: 'http://localhost/blog/post/upload_image',

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
  
      // Change buttons for XS screen.
      // toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']]
});
  }
 function get_comment_textarea(comment_id,post_id,blogger_id,num)
 {
  // 
  $.ajax({
          type: "POST",
          url: "http://localhost/blog/ajaxcall/get_comment_textarea",
          data:{comment_id : comment_id,post_id : post_id,blogger_id : blogger_id,num : num},
          dataType:'html',
          success: function(html)
          {
            $("#editcomment"+num).html(html);
            // document.getElementById('comment_button'+num).innerHTML="<button class='btn btn-info' style='margin-left:5px' id='cancel_comment_edit"+num+"' onclick='cancel_comment("+num+")'>Cancel</button>";
            get_dynamic_editor(num);
            $("#comment_button"+num).hide();
            // $("#comment_button"+num).html("<button class='btn btn-info' style='margin-left:5px' id='cancel_comment_edit"+num+"' onclick='cancel_comment("+comment_id+","+post_id+","+blogger_id+","+num+")'>Cancel</button>");
          }
        });
 }

 function cancel_comment()
{
  //  alert("edit is cancelled"+num);
  var blog_post_id=$('#blog_post_id').val();
      // var commenter_id=$('#commenter_id').val();
      var blogger_id=$('#blogger_id').val();
      // var blog_url=$('#blog_url').val();
      // var comment_id=$('#comment_id'+num).val();
      // if(edited_comment.length<1)
      // {
      //   document.getElementById('message').innerHTML="comment can not be empty";
      // }
      // else
      // {
        $.ajax({
          type:'POST',
          url:'http://localhost/blog/ajaxcall/cancel_comment',
          data:{blog_post_id: blog_post_id,
          blogger_id: blogger_id},
          dataType:'html',
          success:function(data)
          {
            if(data == 'false')
            {
              document.getElementById('message').innerHTML="comment could not be posted";
            }
            else
            {
              // get username,
              // window.location.href = main_link;
                 $("#comment_made").html(data);
                //  $("#commentContent").val('');
            }
          }
        });
      // }
}

function submit_edit_comment(num)
 {
  var edited_comment=$('#edited_comment_content').val();
      var blog_post_id=$('#blog_post_id').val();
      // var commenter_id=$('#commenter_id').val();
      var blogger_id=$('#blogger_id').val();
      // var blog_url=$('#blog_url').val();
      var comment_id=$('#comment_id'+num).val();
      if(edited_comment.length<1)
      {
        document.getElementById('message').innerHTML="comment can not be empty";
      }
      else
      {
        $.ajax({
          type:'POST',
          url:'http://localhost/blog/ajaxcall/edit_comment',
          data:{edited_comment: edited_comment,blog_post_id: blog_post_id,comment_id:comment_id,
          blogger_id: blogger_id},
          dataType:'html',
          success:function(data)
          {
            if(data == 'false')
            {
              document.getElementById('message').innerHTML="comment could not be posted";
            }
            else
            {
              // get username,
              // window.location.href = main_link;
                 $("#comment_made").html(data);
                //  $("#commentContent").val('');
            }
          }
        });
      }
 }

 function get_blog_list(post_id,blogger_id)
 {
  //  var status=check_status_before_move(post_id,blogger_id);
  //  if(status==1)
  //  {
    $.ajax({
      type:'POST',
      url:'http://localhost/blog/ajaxcall/get_post_lock_status',
      data:{post_id : post_id,blogger_id : blogger_id},
      dataType:'json',
      success:function(data)
      {
        // $("#button_operate").html(data);
        if(data=="unlocked")
        {
          $.ajax({
            type:'POST',
            url:'http://localhost/blog/ajaxcall/get_blog_list',
            data:{post_id : post_id,blogger_id : blogger_id},
            dataType:'html',
            success:function(data)
            {
              $("#button_operate").html(data);
            }
          });
        }
        else
        {
          alert("this post can not be moved now try later");
        }
      }
    });
  //  }
    // alert("function is getting called"+post_id+blogger_id);
 }

//  function to make final move
 $(document).ready(function(){
   $("#submit_blog").click(function(e){
     e.preventDefault();
     var post_id=$("#post_id").val();
     var original_blogger_id=$("#original_blogger_id").val();
     var new_blogger_id=$("#new_blogger_id").children("option:selected").val();
    //  alert("this"+post_id+" "+original_blogger_id+" "+new_blogger_id);
    $.ajax({
      type:'POST',
      url:'http://localhost/blog/move',
      data:{post_id : post_id,original_blogger_id : original_blogger_id,
        new_blogger_id : new_blogger_id},
      dataType:'json',
      success:function(data)
      {
        // $("#button_operate").html(data);
        if(data[0]=="post is moved")
        {
          alert("post moved successfully");
        }
        else
        {
          alert(data);
        }
        // window.location.reload();
        window.location.href = 'http://localhost/blog/'+data[1];

      }
    });

   })
 });

//  function ot create copy of a post
function make_copy(post_id)
{

  var bool= confirm("do you want to copy")
	  if(bool==true)
	  {
      $.ajax({
        type:'POST',
        url:'http://localhost/blog/copy',
        data:{post_id : post_id},
        dataType:'json',
        success:function(data)
        {
          // $("#button_operate").html(data);
          if(data[0]=="post is copied")
          {
            alert("post copied successfully");
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

  // fucntion to make comments through ajax
  // $(document).ready(function()
  // {
  //   $('#submit_edited_comment').click(function(e)
  //   {
  //     e.preventDefault();
  //     var edited_comment=$('#edited_comment_content').val();
  //     var blog_post_id=$('#blog_post_id').val();
  //     // var commenter_id=$('#commenter_id').val();
  //     var blogger_id=$('#blogger_id').val();
  //     // var blog_url=$('#blog_url').val();
  //     var comment_id=$('#comment_id').val();
  //     if(edited_comment.length<1)
  //     {
  //       document.getElementById('message').innerHTML="comment can not be empty";
  //     }
  //     else
  //     {
  //       $.ajax({
  //         type:'POST',
  //         url:'http://localhost/blog/ajaxcall/edit_comment',
  //         data:{edited_comment: edited_comment,blog_post_id: blog_post_id,comment_id:comment_id,
  //         blogger_id: blogger_id},
  //         dataType:'html',
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
  //                $("#comment_made").html(data);
  //               //  $("#commentContent").val('');
  //           }
  //         }
  //       });
  //     }
  //   });
  // });

//   function get_dynamic_editor(num)
//   {
//     new FroalaEditor("#edit_comment_content"+num,{
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
//             get_dynamic_editor(num);
//           }
//         });
//  }