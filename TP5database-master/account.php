<?php 
require_once('_config.php');
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
	if($_POST['submit']=='Déconnexion') {
		unset($_SESSION['active']);
		unset($_SESSION['id_user']);
		header('Location: index.php');
		add_flash('success','Vous vous êtes déconnecté !');
		die;
	}
	if($_POST['submit']=='Changer votre mot de passe') {
		header('Location: set-password.php');
		die;
	}
	if($_POST['submit']=='Ecrire un article') {
		header('Location: create-post.php');
		die;
	}
}	
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
    <?php include('_header.php') ?>
    <div class="container">
        <div class="card mt-3 mb-3 border-info">
            <div class="card-header text-white bg-info">Vous avez écrit</div>
            <div class="card-body">
	<?php if($user->getNbArticles()==0) : ?>
	<h1> Vous n'avez pas encore écrit d'articles</h1>
	<?php else: ?>             
	
	<table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Date</th>
                    <th scope="col">Nombre de commentaires</th>
		    <th scope="col">Etat</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                          <tr>
                            <td>
                            <?php echo '<a href="'.$post->getPermalink().'">'.__($post->getTitle()).'</a>'; ?>
                            </td>
                            <td>
                            <?php echo '<a href="'.$post->getCategory()->getPermalink().'">'.$post->getCategory()->getName().'</a>'; ?>
                            </td>
                            <td><?php echo $post->getFormatedDate(); ?></td>
                            <td><?php echo $post->getNbComments(); ?></td>
		    	    <td><?php echo $post->getActive2(); ?></td>
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
		<input type="submit" name="submit" class="btn btn-primary" value="Ecrire un article">
            </p>
            <p class="text-right">
		<input type="submit" name="submit" class="btn btn-primary" value="Changer votre mot de passe">
            </p>
            <p class="text-right">
		<input type="submit" name="submit" class="btn btn-primary" value="Déconnexion">
            </p>
	    </form>
	    </div>
    </div>
            <?php include('_footer.php') ?>
</body>

