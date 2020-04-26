<?php 
	require_once('_config.php');
	$query = sprintf('SELECT * FROM category');
	$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Category');
	$categories = $results -> fetchAll();

	if(isset($_SESSION['active']) && isset($_SESSION['id_user'])) {
		$q=sprintf('SELECT * FROM user WHERE id_user=%s',$_SESSION['id_user']);
		$res=$pdo->query($q, PDO::FETCH_CLASS, 'User');
		$usr=$res->fetch();
	}

	load_translation();
	load_translation_category();


	

?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-info mb-4">
        <div class="container">
       <a class="navbar-brand badge-secondary" <?php echo 'href="index.php?lang='.get_lang().'"';?>><?php echo __('sitename') ?></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span> Menu
       </button>
       <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
               <a class="nav-link" <?php echo 'href="index.php?lang='.get_lang().'"';?> ><?php echo __('accueil'); ?> </a>
           </li>

           <?php 
            foreach ($categories as $category): ?>
               <li class="nav-item active">
                   <?php echo "<a class=\"nav-link\" href=\"".$category->getPermalinkLang2(have_lang())."\">" ?>
                       <?php echo __category($category->getName()) ?>
                       <span class="badge badge-secondary"><?php echo $category->getNbArticlesActifs(); ?> 
				</span>
                   </a>
               </li>
           <?php endforeach ?>
           <li class="nav-item active">
           </li>
         </ul>


<?php // QUESTION 3 : ajout d'une barre de recherche dans le header ?>
<form action="index.php" method="get">
&nbsp;&nbsp;
<button name="lang" value="fr">&#x1F1EB;&#x1F1F7;</button>
<button name="lang" value="en">&#x1F1EC;&#x1F1E7;</button>
<button name="lang" value="es">&#x1F1EA;&#x1F1F8;</button>
&nbsp;&nbsp;
</form>
			<form action="search.php" method="get">
			<input type="text" class="form-control" <?php echo 'placeholder="'.__('rechercher').'"'; ?> name="recherche" size="10">
		</form> 
       </div>


</div>              
		<?php if(isset($_SESSION['active']) && isset($_SESSION['id_user'])) : ?>
		<?php echo '<a style="color: white" href="login.php?lang='.get_lang().'">'.$usr->getName().'</a>'; ?>
		<?php else: ?> 	
			<a style="float: right; color: black; border: 1px dotted" <?php echo 'href="login.php?lang='.get_lang().'"'; ?> ><?php echo __('connexion')?></a>
		<?php endif ?>     
	</nav>  
</header>

<div class="container" >
<?php show_flash() ?>
</div>
