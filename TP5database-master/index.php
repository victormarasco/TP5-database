<?php require_once('_config.php'); ?>
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
    
    <div class="container" >
      <article>
<?php
	$query = sprintf('SELECT * FROM post WHERE actif=1');
	$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Post');
	$nb_articles = $results -> rowcount();
	$posts = $results -> fetchAll();
?>
        <?php if ($nb_articles==0): ?>
        	<h1> Il n’y a pas encore d’article </h1>
        <?php else : ?>
        	<?php foreach ($posts as $post): ?>
			<?php if($post->getActive()==1): ?>
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
			<?php endif ?>
        	<?php endforeach ?>
        <?php endif ?>
      </article>
    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
