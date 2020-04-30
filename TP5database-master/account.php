<?php 
require_once('_config.php');
load_translation();
if(!isset($_SESSION['id_user'])) {
	header('Location: index.php');
	add_flash('warning','Page inexistante');
}
else {
$query = sprintf('SELECT * FROM user WHERE id_user=%s',$_SESSION['id_user']);
$user = $pdo->query($query,PDO::FETCH_CLASS,'User')->fetch();
$posts = $user->getArticles();
}

if(isset($_POST['submit'])) {
	if($_POST['submit']==__('Disconnect')) {
		unset($_SESSION['active']);
		unset($_SESSION['id_user']);
		header('Location: index.php?lang='.get_lang());
		add_flash('success',__('You signed out'));
		die;
	}
	if($_POST['submit']==__('Change password')) {
		header('Location: set-password.php?lang='.get_lang());
		die;
	}
	if($_POST['submit']==__('Write an article')) {
		header('Location: create-post.php?lang='.get_lang());
		die;
	}
}
load_translation();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon compte</title>
    <?php include('_head.php') ?>
</head>
<body>
	<?php include('_overheader.php');?>
    <?php include('_header.php') ?>
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info"><?php echo __('Summary of your activity');?></div>
            <div class="card-body">
	<?php if($user->getNbArticles()==0) : ?>
	<h1> <?php echo __("You haven't written any articles yet");?> </h1>
	<?php else: ?>             
	
	<table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col"><?php echo __('Title');?></th>
                    <th scope="col"><?php echo __('Category');?></th>
                    <th scope="col"><?php echo __('Date');?></th>
                    <th scope="col"><?php echo __('Number of comments');?></th>
		    <th scope="col"><?php echo __('State');?></th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                          <tr>
                            <td>
                            <?php echo '<a href="'.$post->getPermalink().'">'.__($post->getTitle()).'</a>'; ?>
                            </td>
                            <td>
                            <?php echo '<a href="'.$post->getCategory()->getPermalink().'">'.__($post->getCategory()->getName()).'</a>'; ?>
                            </td>
                            <td><?php echo $post->getFormatedDate2(); ?></td>
                            <td><?php echo $post->getNbComments(); ?></td>
		    	    <td><?php echo __($post->getActive2()); ?></td>
                          </tr>
                      <?php endforeach; ?>
                </tbody>
              </table>
	<?php endif;?>
            </div>
	</div>
            <div class="form-group">
	    <form action="" method="POST">
            <p class="text-right">
		<input type="submit" name="submit" class="btn btn-primary" value="<?php echo __('Write an article');?>">
            </p>
            <p class="text-right">
		<input type="submit" name="submit" class="btn btn-primary" value="<?php echo __('Change password');?>">
            </p>
            <p class="text-right">
		<input type="submit" name="submit" class="btn btn-primary" value="<?php echo __('Disconnect');?>">
            </p>
	    </form>
	    </div>
    </div>
            <?php include('_footer.php') ?>
</body>

