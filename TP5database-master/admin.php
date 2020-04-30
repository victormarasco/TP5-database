<?php

require_once('_config.php');
$query = sprintf('SELECT * FROM post');
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Post');
$posts = $results -> fetchAll();

$query = sprintf('SELECT * FROM category');
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Category');
$categories = $results -> fetchAll();

$query = sprintf('SELECT * FROM comment');
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Comment');
$comments = $results -> fetchAll();

$query = sprintf('SELECT * FROM user');
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'User');
$users = $results -> fetchAll();
?>

<?php 
function estActif($actif) {
	if($actif==1) {
		return "Actif";
	}
	else {
		return "Brouillon";
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <?php include('_head.php') ?>
  </head>
  <body>
	<?php include('_overheader.php');?>
    <?php include('_header.php') ?>

    <div class="container" >
      <article>
        <div class="card mb-3 border-info">
            <div class="card-header text-white bg-info">Catégories</div>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Nombre d'articles</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($categories as $category): ?>
                        <tr>
                          <th scope="row"><?php echo $category->getIdCategory(); ?></th>
                          <td>
                              <a href<?php echo "=\"".$category->getPermalink()."\""; ?>>
                               <?php echo $category->getName(); ?>
                              </a>
                          </td>
                          <th><?php echo $category->getNbArticles(); ?></th>
                        </tr>
                    <?php endforeach; ?>
              </tbody>
            </table>
        </div>
      </article>



        <article>
          <div class="card mb-3 border-info">
              <div class="card-header text-white bg-info">Articles</div>
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Date</th>
                    <th scope="col">Nombre de commentaires</th>
		    <th scope="col">Etat</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                          <tr>
                            <th scope="row"><?php echo $post->getIdArticle(); ?></th>
                            <td>
                              <a href <?php echo "=\"".$post->getPermalink()."\""; ?>>
                               <?php echo $post->getTitle(); ?>
                                </a>
                            </td>
                            <td><?php echo $post->getAuthorName(); ?></td>
                            <td><?php echo $post->getCategoryName(); ?></td>
                            <td><?php echo $post->getFormatedDate(); ?></td>
                            <td><?php echo $post->getNbComments(); ?></td>
		    	    <td><?php echo $post->getActive2(); ?></td>
                          </tr>
                      <?php endforeach; ?>
                </tbody>
              </table>
          </div>
        </article>



          <article>
            <div class="card mb-3 border-info">
                <div class="card-header text-white bg-info">Commentaires</div>
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Article</th>
                      <th scope="col">Auteur</th>
                      <th scope="col">Commentaire</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($comments as $comment): ?>
                            <tr>
                              <th scope="row"><?php echo $comment->getID(); ?></th>
                              <td>
                              <a href <?php echo "=\"".$comment->getArticle()->getPermalink()."\""; ?>>
                               <?php echo $comment->getArticle()->getTitle(); ?>
                                </a>
                              </td>
                              <td><?php echo $comment->getAuthor(); ?></td>
                              <td><?php echo $comment->getComment(); ?></td>
                              <td><?php echo $comment->getDate(); ?></td>
                            </tr>
                        <?php endforeach; ?>
                  </tbody>
                </table>
            </div>
          </article>



            <article>
              <div class="card mb-3 border-info">
                  <div class="card-header text-white bg-info">Utilisateurs</div>
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
			<th scope="col">Login</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nombre d'articles</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                              <tr>
                                <th scope="row"><?php echo $user->getIdUser(); ?></th>				
                                <td><?php echo $user->getName(); ?></td>
				<td><?php echo $user->getLogin();?></td>
                                <td><a href<?php echo "=\"mailto:".$user->getEmail()."\""; ?>><?php echo $user->getEmail(); ?>
				</a></td>
					<td><?php echo $user->getNbArticles() ;?></td>
                              </tr>
                          <?php endforeach; ?>
                    </tbody>
                  </table>
 		</div>
              </div>
            </article>



    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
