<?php 
require_once('_config.php');
$recherche = $_GET['recherche'];
$query = '(SELECT * FROM post WHERE title LIKE \'%'.$recherche.'%\') 
UNION 
(SELECT * FROM post WHERE content LIKE \'%'.$recherche.'%\')';
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Post');
$nb_posts_found= $results->rowcount();
$posts = $results
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TP5 database — Recherche</title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>
    <div class="container" >
      <article>
        <?php if ($nb_posts_found==0): ?>
        	<h1> Aucun article trouvé </h1>
        <?php else : ?>
		<h1><?php echo $nb_posts_found.' articles trouvés pour le mot clé '.$pdo->quote($recherche);?></h1></br></br>
        	<?php foreach ($posts as $post): ?>
        		<article>
        		<div class="card mt-3 mb-3">
        			<h2 class="card-header">
        				<?php echo $post->getTitle(); ?>
        				<span class="badge badge-secondary">
						<?php echo $post->getAuthorName(); ?>
					</span>
        			</h2>
        		<div class="card-body">
        			<p class="card-text"><?php echo $post->getSummary(); ?></p>
        			<?php echo "<a href=\"".$post->getPermalink()."\""; ?> 
					class="btn btn-primary" 
					title="<?php echo $post->getTitle(); ?>" >
					Lire la suite de l'article
				</a>
        		</div>
        		</div>
        		</article>
        	<?php endforeach ?>
        <?php endif ?>
      </article>
    </div>
    <?php include('_footer.php') ?>
  </body>
</html>
