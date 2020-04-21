<?php
require_once('_config.php');
$post_id = $_GET['id'];

$query = 'SELECT p.*, c.name AS category_name, u.name AS author_name
FROM posts AS p
LEFT OUTER JOIN categories AS c ON (c.id_categories = p.id_category)
LEFT OUTER JOIN users AS u ON (u.id_user = p.id_author)
WHERE p.id_article= '.$pdo->quote($_GET['id']); 

//var_dump($query);echo '<br />';

$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post'); 
echo $results->rowcount().' enregistrements'."\n";
echo '12345';
/* gestion article manquant : erreur 404 *//*
if ($current_post_result->rowcount() == 0) {
    add_flash('warning', 'Erreur 404 : l\'article n\'existe pas.');
    header('Location: '.$root_url);
}*/
$current_post = $results->fetch();

/*$query2 = $pdo -> query('SELECT * FROM users WHERE id_user='.$current_post['id_author']) -> fetch();*/


/* traitement du formulaire de commentaire */
if (isset($_POST['nom']) && isset($_POST['commentaire'])) {
  // requête d'ajout du commentaire :
  $query = sprintf('INSERT INTO comments2 (id_article, author, comment, published_at) VALUES (%s, %s, %s, NOW())', $_GET['id'], $pdo->quote($_POST['nom']), $pdo->quote($_POST['commentaire']));
  $result = $pdo->exec($query);
 /* if ($result) {
      add_flash('success', 'Merci pour votre commentaire');
      header('Location: http://val-bd-miage.u-ga.fr/groupe5/TP4database-master/post.php?id='.$root_url.'post.php?id='.$current_post['id']);
  }*/	
}

//var_dump($current_category['name']);echo '<br />';

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TP4 database — <?php echo $current_post['title'] ?></title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>

    <div class="container">
      <article>
        <header>
          <h1><?php echo $current_post['title'] ?></h1>

          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item"><?php echo $current_post['category_name']; ?></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $current_post['title'] ?></li>
            </ol>
          </nav>

        </header>

        <div>
          <?php echo $current_post['content'] ?>
	<?php echo '13245';?>
        </div>

        <footer>
          <p>Publié le <span class="label label-default"><?php echo $current_post['published_at'] ?></span> par 
			<span class="label label-default"><?php echo $current_post['author_name'];?>
			</span></p>
        </footer>

      </article>

      <aside>
        <?php require_once('_comments.php'); ?>
      </aside>
    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
