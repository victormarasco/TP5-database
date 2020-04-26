<?php
require_once('_config.php');
$current_category_id = $_GET['id'];
$query = sprintf('SELECT * FROM category WHERE id_category=%s',$pdo->quote($current_category_id));
$results = $pdo->query($query, PDO::FETCH_CLASS, 'Category');
if ($results->rowcount() == 0) {
    add_flash('warning', 'Erreur 404 : la catégorie n\'existe pas.');
    header('Location: index.php');
    die;
}
$current_category = $results->fetch();
$nb_articles = $current_category -> getNbArticlesActifs();
$current_category_posts = $current_category -> getPosts();

load_translation();
load_translation_category();



//header('Location: '.$current_category->getLinkLang());

//var_dump($current_category['name']);echo '<br />';

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo __category($current_category->getName());?></title>
    <?php include('_head.php') ?>
  </head>
  <body>
    <?php include('_header.php') ?>

    <div class="container">
      <section>
        <header>
          <h1>    <?php echo __category($current_category->getName()) ?> </h1>

            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><?php echo '<a href="index.php?lang='.get_lang().'">'.__('accueil').'</a>';?></li>
                <li class="breadcrumb-item active" aria-current="page">  <?php echo __category($current_category->getName()); ?></li>
              </ol>
            </nav>
        </header>



<?php
?>	<?php if ($nb_articles==0) : echo 'Aucun article dans cette catégorie'; else:?>
        <?php foreach ($current_category_posts as $post): ?>
		<?php if($post->getActive()==1): ?>
            <article>
                <div class="card mt-3 mb-3">
                    <h2 class="card-header">
                        <?php echo $post->getTitle(); ?>
                        <span class="badge badge-secondary"><?php echo $post->getAuthorName(); ?></span>
                    </h2>
                  <div class="card-body">
                    <p class="card-text"><?php echo $post->getSummary() ?>   </p>
                    <a href<?php echo "=\"".$post->getPermalink()."\""; ?>   
			class="btn btn-primary" title<?php echo "=\"".$post->getTitle(); ?>" ><?php echo __('suite-article');?></a>
                  </div>
                </div>
            </article>
		<?php endif ?>
        <?php endforeach ?>
	<?php endif ?>

      </section>
    </div>

    <?php include('_footer.php') ?>
  </body>
</html>
