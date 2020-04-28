<?php
require_once('_config.php');

if($_SESSION['active']==0) {
    	add_flash('warning', 'Page inexistante');
    	header('Location: index.php');
	die;	
}	
$query = sprintf('SELECT * FROM user WHERE id_user =%s LIMIT 1',$_SESSION['id_user']);
$result = $pdo->query($query, PDO::FETCH_CLASS, 'User');
$user = $result -> fetch();
$query2 = sprintf('SELECT * FROM category'); 
$results2 = $pdo->query($query2, PDO::FETCH_CLASS, 'Category');
$categories = $results2 -> fetchAll();




?>

<?php 
if (isset($_POST['sub']) && isset($_POST['new-text']) && isset($_POST['new-summary']) && isset($_POST['new-text'])) { 
 $queryInsert = sprintf('INSERT INTO `post` (`id_author`, `id_category`, `title`, `slug`,  `date`, `content`, `summary`, `published_at`)
VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
$user->getIdUser(),
$_POST['new-category'],
$pdo->quote($_POST['new-title']),
$pdo->quote(slugify($pdo->quote($_POST['new-title']))),
'NOW()',
$pdo->quote($_POST['new-text']),
$pdo->quote($_POST['new-summary']),
'NOW()');
//var_dump($queryInsert);
$pdo->exec($queryInsert);

	if($_POST['sub']=='Enregistrer comme brouillon') {
		$query= sprintf('BEGIN; UPDATE `post` SET `actif`=0 WHERE title=%s; COMMIT',$pdo->quote($_POST['new-title']));
		$result = $pdo->exec($query);
	}
	if($_POST['sub']=='Publier') {
		$query= sprintf('BEGIN; UPDATE `post` SET `actif`=1 WHERE title=%s; COMMIT;',$pdo->quote($_POST['new-title']));
		$result = $pdo->exec($query);
	}

add_flash('success','Votre article a bien été créé !');
header('Location: login.php');
die;

}

	
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvel article</title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>

    <div class="container">
      <article>

<form action="" method="POST">
      <div class="form-group">
        <label for="new-title">Titre</label>
        <input type="text" class="form-control" id="new-title" name="new-title" size="50" required />
      </div>
      <div class="form-group">
        <label for="new-summary">Résumé</label>
        <textarea id="new-summary" name="new-summary" class="form-control"  required >
	</textarea>
      </div>
      <div class="form-group">
        <label for="new-text">Contenu</label>
        <textarea id="new-text" name="new-text" class="form-control"  required >
	</textarea>
      </div>

<div>
<?php // choix de catégorie ?>
	<select name="new-category">
	<?php foreach ($categories as $category) :?>
<?php echo '<option value="'.$category->getIdCategory().'"> '.$category->getName().' </option>'; ?>
	<?php endforeach ?>
	</select>
</div>


      	<p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="Enregistrer comme brouillon"></p>
      	<p class="text-right"><input type="submit" class="btn btn-primary" name="sub" value="Publier"></p>


</form>


      </article>

    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
