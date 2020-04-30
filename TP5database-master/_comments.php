<?php

require_once('_config.php');

?>
<?php /* formulaire de commentaire */ ?>
<div class="card mt-3 mb-3 border-info">
  <div class="card-header text-white bg-info"><?php echo __('Your opinion').' ?';?></div>
  <div class="card-body">

    <form action="" method="POST">
      <div class="form-group">
        <label for="nom"><?php echo __('Username');?></label>
        <input type="text" class="form-control" id="nom" name="nom" required />
      </div>
      <div class="form-group">
        <label for="commentaire"><?php echo __('Comment'); ?></label>
        <textarea id="commentaire" name="commentaire" class="form-control" rows="5" required ></textarea>
      </div>
      <p class="text-right"><input type="submit" class="btn btn-primary" value="<?php echo __('Send');?>"></p>
    </form>

  </div>
</div>
