<?php require_once('_config.php');

$q=sprintf('SELECT * FROM user WHERE id_user=%s',$_SESSION['id_user']);
$r=$pdo->query($q)->fetch();
if(isset($_POST['submit'])) {
	if(password_verify($_POST['old-password'],$r['password'])) {
		$qi = sprintf('UPDATE `user` SET `password`=%s WHERE id_user=%s',
			$pdo->quote(password_hash($_POST['new-password'],PASSWORD_BCRYPT)),
			$_SESSION['id_user']);
		var_dump($qi);
		
		$r=$pdo->exec($qi);
		if($r){header('Location: account.php');
		add_flash('success',__('The password has been changed').' !');
		die;}
	}
	else {
		add_flash('warning',__('Invalid password').' !');
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Blog Du Groupe 5</title>
    <?php include('_head.php') ?>
</head>

<body>
    <?php include('_header.php') ?>
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info"><?php echo __('Change password');?></div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="password" class="form-control" name="old-password" placeholder="<?php echo __('Old password');?>" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="new-password" placeholder="<?php echo __('New password');?>" required />
                    </div>
                    <p class="text-right"><input type="submit" name="submit" class="btn btn-primary" value="<?php echo __('Validate');?>">
                    </p>

                </form>	
            </div>
	</div>
    </div>
            <?php include('_footer.php') ?>
</body>

</html>
