<?php require_once('_config.php') ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TP4 database</title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>
    
    <div class="container" >
      <article>
<?php
          // Requête pour récupérer tous les articles de la catégorie
          $query = 'SELECT p.*,u.name AS u_name, c.name AS c_name
          FROM posts AS p
          LEFT OUTER JOIN users AS u ON (u.id_user = p.id_author)
          LEFT OUTER JOIN categories AS c ON (c.id_categories = p.id_category)';
          $posts = $pdo->query($query);
        ?>
        	<?php if ($posts->rowCount() == 0): ?>
        		<h1> Il n’y a pas encore d’article </h1>
        	<?php else : ?>
        			<?php foreach ($posts as $post): ?>
        				<article>
        					<div class="card mt-3 mb-3">
        						<h2 class="card-header">
        							<?php echo $post['title'] ?>
        							<span class="badge badge-secondary"><?php echo $post['u_name'] ?></span>
        						</h2>
        					  <div class="card-body">
        						<p class="card-text"><?php echo $post['summary'] ?></p>
        						<a href= "http://val-bd-miage.u-ga.fr/groupe1/TP4database-master/post.php?id=<?php echo $post['id'] ?>" class="btn btn-primary" title= "<?php echo $post['title']?>" >Lire la suite de l'article</a>
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
