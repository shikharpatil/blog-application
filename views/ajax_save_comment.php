<script src="<?php echo site_url();?>application/assets/blog.js"></script>
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
            { $i=1;
              foreach($comments as $row)
              {
              ?>
                  <!-- Single Comment -->
                  <div class="media mb-4">
                  <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                  <div class="media-body">
                    <h5 class="mt-0"><?php echo $row->username;?></h5>
                    <!-- comment here<?php echo $row->content;?> -->
                    
                     <!-- <form> -->
                    <div class="comment-container<?php echo $i ;?>">
                        <div id="editcomment<?php echo $i ;?>"><?php echo $row->content; ?>
                        </div>
                    </div>   
                        <input type="hidden" id="comment_id" value="<?php echo $row->id; ?>" >
                        <!-- <input type="hidden" id="comment_div_id" value="<?php //echo $i; ?>" > -->
                        <!-- <input type="hidden" id="comment_blogger_id" value="<?php //echo $row->blogger_id; ?>" > -->
                     <!-- </form> -->
                     <?php
                     if($_SESSION["username"]==$row->username)
                     {
                       ?>
                       <span id="comment_button<?php echo $i;?>"><a href="javascript:void(0)" id="edit_comment_button" class="btn btn-info" style="margin-top:5px" onclick="get_comment_textarea(<?php echo $row->id; ?>,<?php echo $row->blog_post_id; ?>,<?php echo $blogger_id ;?>,<?php echo $i; ?>)" >edit</a></span>
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