<?php
require_once('_config.php');
load_translation();
$current_category_id = $_GET['id'];
$query = sprintf('SELECT * FROM category WHERE id_category=%s',$pdo->quote($current_category_id));
$results = $pdo->query($query, PDO::FETCH_CLASS, 'Category');
if ($results->rowcount() == 0) {
$msg=__('Error').' 404 : '.__('the category does not exist');

    add_flash('warning',$msg);

    header('Location: index.php?lang='.get_lang());
    die;
}
$current_category = $results->fetch();
$nb_posts = $current_category -> getNbArticlesActifs();
$current_category_posts = $current_category -> getPosts();



//header('Location: '.$current_category->getLinkLang());

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
      <section>
        <header>
          <h1>    <?php echo __($current_category->getName()) ?> </h1>

            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><?php echo '<a href="index.php?lang='.get_lang().'">'.__('Home page').'</a>';?></li>
                <li class="breadcrumb-item active" aria-current="page">  <?php echo __($current_category->getName()); ?></li>
              </ol>
            </nav>
        </header>

	<?php if ($nb_posts==0) : echo __('No article in this category'); else:?>
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
                    <?php echo '<a href="'.$post->getPermalink().'&lang='.get_lang().'"'; ?>   
			class="btn btn-primary" title<?php echo "=\"".$post->getTitle(); ?>" ><?php echo __('Read the rest of the article');?></a>
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
