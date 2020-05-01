<?php
require_once('_config.php');

if (isset($_POST['sub'])) { 
$q='SELECT * FROM user WHERE email='.$pdo->quote($_POST['email']).' OR login='.$pdo->quote($_POST['login']);
var_dump($q);
$r=$pdo->query($q)->fetch();
if(!$r) {
	$qi = sprintf('INSERT INTO `user` (`email`, `login`, `password`) VALUES (%s,%s,%s)',
		$pdo->quote($_POST['email']),
		$pdo->quote($_POST['login']),
		$pdo->quote(password_hash($_POST['password'],PASSWORD_BCRYPT)));
	$pdo->exec($qi);
	add_flash('success',__('Welcome').' '.$_POST['login'].' '.__('thanks for registration'));
	header('Location: login.php');
	die;
}

else {
	header('Location: register.php');
	add_flash('warning',__('E-mail or username already used'));
	die;
}
}

	
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
    <?php include('_head.php') ?>
  </head>
  <body>
<?php include ('_overheader.php');?>
    <?php include('_header.php') ?>

    <div class="container">
      <article>

<form action="" method="POST">
      <div class="form-group">
        <label for="email"><?php echo __('E-mail');?></label>
        <input type="text" class="form-control" name="email" required />
      </div>
      <div class="form-group">
        <label for="new-summary"><?php echo __('Username');?></label>
        <input type="text" class="form-control" name="login"  required />
      </div>
      <div class="form-group">
        <label for="password"><?php echo __('Password');?></label>
        <input type="password" class="form-control" name="password" required />
      </div>
      	<p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="S'inscrire"></p>
</form>


      </article>

    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
