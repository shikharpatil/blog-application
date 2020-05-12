
<script src="<?php echo site_url();?>application/assets/blog.js"></script>
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
          <form id="editpost" action="<?php echo site_url(); ?>user/update_blog" method="post">
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
            <span ><a id="get_pre_version" href="javascript:void(0);"><<</a> <input type="hidden" id="pre_post_url" value="<?php echo $previous_post;?>"></span>
            <?php
          }
          ?>
          <span style="align-content: center"><?php print_r("current version : ".$version_num);?></span>
          <?php
          if(isset($next_post))
          {
            ?>
            <span ><a id="get_next_version" href="javascript:void(0);">>></a><input type="hidden" id="next_post_url" value="<?php echo $next_post;?>"></span>
            <?php
            // echo $next_post;
          }
        } 
          ?>
          </div>