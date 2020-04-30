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



?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-info mb-4">
        <div class="container">
       <a class="navbar-brand badge-secondary" href="index.php?<?php echo 'lang='.get_lang();?>">Le Blog Du Groupe 5</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span> Menu
       </button>
       <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
               <a class="nav-link" href="index.php?<?php echo 'lang='.get_lang();?>"><?php echo __('Home page'); ?></a>
           </li>

           <?php 
            foreach ($categories as $category): ?>
               <li class="nav-item active">
                   <?php echo "<a class=\"nav-link\" href=\"".$category->getPermalinkLang()."\">" ?>
                       <?php echo __($category->getName()) ?>
                       <span class="badge badge-secondary"><?php echo $category->getNbArticlesActifs(); ?> 
				</span>
                   </a>
               </li>
           <?php endforeach ?>
           <li class="nav-item active">
           </li>
         </ul>


</ul>
			<form action="search.php?<?php echo '?lang='.get_lang();?>" method="get">
			<input type="text" class="form-control" <?php echo 'placeholder="'.__('Search').'..."'; ?> name="recherche" size="10">
		</form> 
       </div>


</div>              
		<?php if(isset($_SESSION['active'])) : ?>
		<?php echo '<a style="color: white" href="account.php?lang='.get_lang().'">'.$usr->getLogin().'</a>'; ?>
		<?php else: ?> 	
			<a style="color: white;" size="50" <?php echo 'href="login.php?lang='.get_lang().'">'.__('Sign in');?></a>
		<?php endif ?>     
	</nav>  
</header>

<div class="container" >
<?php show_flash() ?>
</div>
