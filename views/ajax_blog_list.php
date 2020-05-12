
<script src="<?php echo site_url();?>application/assets/blog.js"></script>
<div class="form-group">
<form id="select_blog" method="post">
<input type="hidden" id="post_id" name="post_id" value="<?php echo $data["post_id"] ;?>">
<input type="hidden" id="original_blogger_id" name="original_blogger_id" value="<?php echo $data["blogger_id"] ;?>">
<label for="new_blogger_id"><strong>Choose Blog to move post</strong></label>
<div class="form-group" >
<select class="form-control" id="new_blogger_id" name="new_blogger_id">
<?php
if(isset($all_users))
{
    foreach($all_users as $row)
    {
        ?>
        <option value="<?php echo $row->id ;?>"><?php echo $row->username?>'s blog</option>
        <?php
    }
}
?>
</select> 
</div>
<div class="input-group-btn"><input class="btn btn-primary" type="submit" value="submit" id="submit_blog"></div>
</form>
</div>