<?php
require_once('_config.php');
require_once('classes/post.class.php');
$slug = $_GET['slug'];

$query = sprintf('SELECT * FROM post WHERE slug=%s',$pdo->quote($slug)); 
// var_dump($query);
// QUESTION 0.2
// Récupération d'un objet Post 
$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post');
$post = $results -> fetch();

// QUESTION 1.1-2-3-4
// Si l'article n'existe pas, la base de données ne renvoi rien

/* gestion article manquant : erreur 404 */
if ($results->rowcount() == 0) {
$msg=__('Error').' 404 : '.__('the article does not exist');

    add_flash('warning',$msg);

    header('Location: index.php?lang='.get_lang());
    die;
}

/* traitement du formulaire de commentaire */
if (isset($_POST['nom']) && isset($_POST['commentaire'])) {
	$post->addComment($_POST['nom'], $_POST['commentaire']);
}

load_translation();

//var_dump($current_category['name']);echo '<br />';

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Blog Du Groupe 5</title>
    <?php include('_head.php') ?>
  </head>
  <body>
	<?php include('_overheader.php');?>
    <?php include('_header.php') ?>

    <div class="container">
      <article>
        <header>
          <h1><?php echo $post->getTitle(); ?></h1>

          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php"><?php echo __('Home page'); ?></a></li>
              <li class="breadcrumb-item"><a href<?php  echo "=\"".$post->getCategory()->getPermalink()."\""; ?>>
				<?php echo __($post->getCategory()->getName()); ?></a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $post->getTitle(); ?></li>
            </ol>
          </nav>

        </header>

        <p class="card mt-3 mb-3 border-info">
          <?php echo $post->getContent(); ?>

        </p>

        <footer>
          <p style="color:blue; font-style:italic"><?php echo __('Published on').' ';?><span class="label label-default"><?php echo $post->getFormatedDate2(); ?></span><?php echo ' '.__('by'); ?>
			<span class="label label-default badge badge-secondary"><?php echo $post->getAuthorName();?>
			</span>

<?php 
// QUESTION 2.1 : Lien "modifier" ?>
	<a href="<?php echo $post->getPermalinkEdit();?>" style="color:red; border: 1px solid; margin: 60px; font-style: normal"> <?php echo __('Modify'); ?><a/> 
	</p>
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
    <div class="alert alert-info" role="alert"><?php echo __('There are no comments yet').', '.__('be the first').'!';?></div>
<?php endif ?>
        <?php require_once('_comments.php'); ?>
      </aside>
    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
