<?php
require_once('_config.php'); ?>
<?php 
remove_flash();
if(isset($_SESSION['active'])) {
	header('Location: account.php');
	die;
}

if (isset($_POST["connect"])) {
	$query = 'SELECT * FROM user WHERE login ='.$pdo->quote($_POST["login"]).' LIMIT 1';
	$result = $pdo->query($query)->fetch();
	if (($result) && password_verify($_POST["password"], $result['password'])) {
        	session_write_close();
        	session_start();
        	unset($_SESSION['id_user']);

        	$_SESSION['id_user'] = $result['id_user'];
		$_SESSION['active']=1; 				// savoir si il y a une session 	
        	add_flash('success', 'Bonjour '.$result['login'].', content de vous revoir !');
		header('Location: account.php');
		die;
    	} 
	else {
	        add_flash('warning', 'Identifiant ou mot de passe invalide !');
		unset($_SESSION['active']);
	        session_write_close();
    	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo __('connexion') ?>
    </title>
    <?php include('_head.php') ?>
</head>

<body>
    <?php include('_header.php') ?>
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info"><?php echo __('connexion'); ?></div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login" <?php echo 'placeholder="'.__('identifiant').'"';?> required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" <?php echo 'placeholder="'.__('mot-de-passe').'"';?> required />
                    </div>
                    <p class="text-right"><input type="submit" name="connect" class="btn btn-primary" <?php echo 'value="'.__('connexion').'"';?> >
                    </p>

                </form>
		<form action="register.php">
                    <p class="text-right">
			<input type="submit" name="connect" class="btn btn-primary" value="Inscription">
		    </p>
		</form>		
            </div>
	</div>
    </div>
            <?php include('_footer.php') ?>
</body>

</html>
