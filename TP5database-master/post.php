<?php
require_once('_config.php');
require_once('classes/post.class.php');
$slug = $_GET['slug'];

$query = sprintf('SELECT * FROM post WHERE slug=%s',$pdo->quote($slug)); 
var_dump($query);
$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post');
$post = $results -> fetch();
/* gestion article manquant : erreur 404 */
if ($results->rowcount() == 0) {
    add_flash('warning', 'Erreur 404 : l\'article n\'existe pas.');
    header('Location: index.php');
}

/* traitement du formulaire de commentaire */
if (isset($_POST['nom']) && isset($_POST['commentaire'])) {
	$post->addComment($_POST['nom'], $_POST['commentaire']);
}

//var_dump($current_category['name']);echo '<br />';

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

        <h3 class="card mt-3 mb-3 border-info">
          <?php echo $post->getContent(); ?>

        </h3>

        <footer>
          <p style="color:blue; font-style:italic">Publié le <span class="label label-default"><?php echo $post->getFormatedDate(); ?></span> par 
			<span class="label label-default badge badge-secondary"><?php echo $post->getAuthorName();?>
			</span><a href
			<?php 
					echo "=\"".$post->getPermalinkEdit()."\"";
			?> 

style="color:red; border: 1px solid; margin: 60px; font-style: normal"> Modifier <a/>  </p>
        </footer>
	</br></br>
      </article>

      <aside>
<?php 	$commentaires = $post->getComments();
	$q=count($commentaires); ?>
	<?php if ($q > 0): ?>
    <?php foreach ($commentaires as $comment): ?>
        <div class="card mt-3 mb-3">
            <h2 class="card-header">
                <?php echo $comment->getAuthor() ?>
                <span class="badge badge-secondary"><?php echo $comment->getDate() ?></span>
            </h2>
          <div class="card-body">
            <p class="card-text"><?php echo $comment->getComment() ?></p>
          </div>
        </div>
    <?php endforeach ?>
<?php else: ?>
    <div class="alert alert-info" role="alert">Il n'y a pas encore de commentaire, soyez le premier !</div>
<?php endif ?>
        <?php require_once('_comments.php'); ?>
      </aside>
    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
