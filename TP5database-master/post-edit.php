<?php
require_once('_config.php');


$post_id = $_GET['id'];

$query = sprintf('SELECT * FROM post WHERE id_article=%s',$pdo->quote($post_id)); 
$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post');
$post = $results -> fetch();
	if($_SESSION['active']==0) {
    		add_flash('warning', 'Vous devez vous identifier pour modifier l\'article');
    		header('Location: '.$post->getPermalink());
		die;	
	}	



?>

<?php 

if (isset($_POST['sub']) && isset($_POST['new-title']) && isset($_POST['new-text'])) { 

 $query = sprintf('UPDATE `post` SET `title`=%s,`content`=%s WHERE id_article=%s',$pdo->quote($_POST['new-title']),
$pdo->quote($_POST['new-text']),$post->getIdArticle());
  echo $query;	
  $result = $pdo->exec($query);
	if($_POST['sub']=='Enregistrer') {
		$query= sprintf('UPDATE `post` SET `actif`=1 WHERE id_article=%s',$post->getIdArticle());
		$result = $pdo->exec($query);
  		header('Location: '.$post->getPermalinkEdit());
  		die;
	}
	if($_POST['sub']=='Enregistrer comme brouillon') {
		$query= sprintf('UPDATE `post` SET `actif`=0 WHERE id_article=%s',$post->getIdArticle());
		$result = $pdo->exec($query);
  		header('Location: '.$post->getPermalinkEdit());
  		die;
	}
	if($_POST['sub']=='Publier') {
		$query= sprintf('UPDATE `post` SET `actif`=1 WHERE id_article=%s',$post->getIdArticle());
		$result = $pdo->exec($query);
  		header('Location: '.$post->getPermalink());
  		die;
	}
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TP5 database — <?php echo $post->getTitle(); ?></title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>

    <div class="container">
      <article>
        <header>
          <h1><?php echo $post->getTitle(); ?></h1>

          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item"><a href<?php  echo "=\"".$post->getCategory()->getPermalink()."\""; ?>>
				<?php echo $post->getCategory()->getName(); ?></a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $post->getTitle(); ?></li>
            </ol>
          </nav>

        </header>

   
<form action="" method="POST">
      <div class="form-group">
        <label for="new-title">Titre</label>
        <input type="text" class="form-control" id="new-title" name="new-title" value
<?php echo "=\"".$post->getTitle()."\"";?> size="50" required />
      </div>
      <div class="form-group">
        <label for="new-text">Article</label>
        <textarea id="new-text" name="new-text" class="form-control" rows="5" required ><?php echo $post->getContent();?>
</textarea>
      </div>
      <p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="Enregistrer comme brouillon"></p>
      <p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="Enregistrer"></p>
      <p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="Publier"></p>
    </form>

        <footer>
          <p>Publié le <span class="label label-default"><?php echo $post->getFormatedDate(); ?></span> par 
			<span class="label label-default"><?php echo $post->getAuthorName();?>
			</span></p>
        </footer>

      </article>

    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
