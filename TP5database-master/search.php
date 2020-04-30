<?php 
require_once('_config.php');
load_translation();
$recherche = $pdo->quote($_GET['recherche']);

function multiexplode ($delimiters,$string) {
   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

/* genere un string pour la recherche de type : champ LIKE '%$mots[0]%' OR champ LIKE '%$mots[1]%' .... */ 


function _echo_explode($string, $champ) {
	$mots = multiexplode(array("'"," "),$string);
	$i=0;
	$ret="";
	while($i!=count($mots)) {
		if($mots[$i]!="") {
		if(isset($mots[$i+1]) && $mots[$i+1]!="") {
			$ret=$ret.$champ." LIKE '%".$mots[$i]."%' OR "; 
		}
		else {
			$ret=$ret.$champ." LIKE '%".$mots[$i]."%'";
		}
		}
		$i=$i+1;
	}
	return $ret;
}

$query = sprintf('(SELECT * FROM post WHERE %s ) 
UNION 
(SELECT * FROM post WHERE %s )', _echo_explode($recherche,'title'),_echo_explode($recherche,'content'));
//var_dump($query);
$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Post');
$nb_posts_found= $results->rowcount();
$posts = $results
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
    <div class="container" >
      <article>
        <?php if ($nb_posts_found==0): ?>
        	<h1><?php echo __('No article found'); ?></h1>
        <?php else : ?>
		<h1><?php echo __('Result of the research').' : '.$nb_posts_found.' '.__('found');?></h1></br></br>
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
        			<a href="<?php echo $post->getPermalink().'&lang='.get_lang();?>" 
					class="btn btn-primary">
					<?php echo __('Read the rest of the article'); ?>
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
