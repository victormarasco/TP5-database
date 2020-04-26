<?php
require_once('_config.php'); ?>
<?php if(isset($_SESSION["active"])): ?>
<?php 
$query2 = sprintf('SELECT *FROM post WHERE id_author=%s',$_SESSION['id_user']);
// var_dump($query2);
$result2 = $pdo->query($query2, PDO::FETCH_CLASS, 'Post');
// var_dump($result2);
$nb_post = $result2->rowcount();
$posts = $result2 -> fetchAll();
$query3 = 'SELECT * FROM user WHERE id_user ='.$_SESSION['id_user'].' LIMIT 1';

$user = $pdo->query($query3, PDO::FETCH_CLASS, 'User')->fetch();

if(isset($_POST["disc"])) {
	unset($_SESSION["active"]);
	unset($_SESSION["id_user"]);
	session_write_close();

}

?>
<?php else : ?>
<?php if (isset($_POST["connect"])) : ?>
<?php
remove_flash();
$query = 'SELECT * FROM user WHERE login ='.$pdo->quote($_POST["login"]).' LIMIT 1';

$result = $pdo->query($query)->fetch();


// var_dump($result);
    if (($result) && ($_POST["password"]==$result['password']) && ($_POST["login"]==$result['login'])) {
        session_write_close();
        session_start();
        unset($_SESSION['id_user']);

        $_SESSION['id_user'] = $result['id_user'];
	$_SESSION['active']=1; 				// savoir si il y a une session 	
        add_flash('success', 'Connecté !');
$query2 = sprintf('SELECT *FROM post WHERE id_author=%s',$_SESSION['id_user']);
// var_dump($query2);
$result2 = $pdo->query($query2, PDO::FETCH_CLASS, 'Post');
// var_dump($result2);
$nb_post = $result2->rowcount();
$posts = $result2 -> fetchAll();
$query3 = 'SELECT * FROM user WHERE id_user ='.$_SESSION['id_user'].' LIMIT 1';

$user = $pdo->query($query3)->fetch();
    } else {
        add_flash('warning', 'Identifiant ou mot de passe invalide !');
	unset($_SESSION['active']);
        session_write_close();
    }

?>
<?php endif ?>
<?php endif ?>
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
    <?php if(!isset($_SESSION['active'])) : ?>	
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info"><?php echo __('connexion'); ?></div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" id="login" name="login" <?php echo 'placeholder="'.__('identifiant').'"';?> required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" <?php echo 'placeholder="'.__('mot-de-passe').'"';?> required />
                    </div>
                    <p class="text-right"><input type="submit" name="connect" class="btn btn-primary" <?php echo 'value="'.__('connexion').'"';?> >
                    </p>

                </form>

            </div>
	</div>
    </div>
    <?php else : ?>
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info"><?php echo __('bonjour')." ".$user->getName().", ".__('res-activ')." "; ?> </div>
            <div class="card-body">
		<?php if ($nb_post==0) : ?>
		<?php echo "Vous n'avez pas encore écrit d'articles !"; ?>
		<?php else : ?>
		<?php foreach ($posts as $post) : ?>
		<p>Vous avez écrit :</br>
			<?php echo '<a href="'.$post->getPermalink().'">'.$post->getTitle().'</a>'; ?>
		</br></p>
		<?php endforeach ?>
		<?php endif ?>

            </div>
	</div>
	<form action ="change-password.php" method="post">
      <p class="text-right"><input type="submit" class="btn btn-primary" name="cp" <?php echo 'value="'.__('change-mdp').'"';?> ></p>
	</form>
	<form action ="create-post.php" method="post">
      <p class="text-right"><input type="submit" class="btn btn-primary" name="cp" value="Ecrire un article" ></p>
	</form>
	<form action="" method="post">
      <p class="text-right"><input type="submit" class="btn btn-primary" name="disc" <?php echo 'value="'.__('deconnexion').'"';?>></p>
	</form>
    </div>
	<?php endif ?>
            <?php include('_footer.php') ?>
</body>

</html>
