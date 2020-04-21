<?php
require_once('_config.php'); ?>
<?php if (isset($_POST["connect"])) : ?>
<?php
remove_flash();
$query = 'SELECT * FROM user WHERE login ='.$pdo->quote($_POST["login"]).' LIMIT 1';
$result = $pdo->query($query)->fetch();
var_dump($result);
    if (($result) && ($_POST["password"]==$result['password']) && ($_POST["login"]==$result['login'])) {
        session_write_close();
        session_start();
        unset($_SESSION['id_user']);

        $_SESSION['id_user'] = $result['id_user'];
	$_SESSION['active']=1; 				// savoir si il y a une session 	
        add_flash('success', 'Connecté !');
        header('Location: index.php');
        die;
    } else {
        add_flash('warning', 'Identifiant ou mot de passe invalide !');
	unser($_SESSION['active']);
        session_write_close();
    }
?>
<?php endif ?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion
    </title>
    <?php include('_head.php') ?>
</head>

<body>
    <?php include('_header.php') ?>

    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info">Connexion</div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" id="login" name="login" placeholder="Identifiant" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required />
                    </div>
                    <p class="text-right"><input type="submit" name='connect' class="btn btn-primary" value="Connexion">
                    </p>

                </form>

            </div>

            <?php include('_footer.php') ?>
</body>

</html>
