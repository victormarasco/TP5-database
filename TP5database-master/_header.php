<?php 
	require_once('_config.php');
	$query = sprintf('SELECT * FROM category');
	$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Category');
	$categories = $results -> fetchAll();
	if(isset($_POST['deco']) ) {
		unset($_SESSION['id_user']);
		unset($_SESSION['active']);
		session_write_close();
	
	}

	if(isset($_SESSION['active']) && isset($_SESSION['id_user'])) {
		$q=sprintf('SELECT * FROM user WHERE id_user=%s',$_SESSION['id_user']);
		$res=$pdo->query($q, PDO::FETCH_CLASS, 'User');
		$usr=$res->fetch();
	}

?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-info mb-4">
        <div class="container">
       <a class="navbar-brand" href="index.php"><?php echo __('Le Blog du groupe 5') ?></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span> Menu
       </button>
       <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item active">
               <a class="nav-link" href="index.php">Accueil</a>
           </li>

           <?php 
            foreach ($categories as $category): ?>
               <li class="nav-item active">
                   <?php echo "<a class=\"nav-link\" href=\"".$category->getPermalink()."\">" ?>
                       <?php echo $category->getName() ?>
                       <span class="badge badge-secondary"><?php echo $category->getNbArticlesActifs(); ?> 
				</span>
                   </a>
               </li>
           <?php endforeach ?>
           <li class="nav-item active">
           </li>
         </ul>
			<form action="search.php" method="get">
			<input type="text" class="form-control" placeholder="Rechercher" name="recherche" size="10">
		</form> 
       </div>


</div>              
		<?php if(isset($_SESSION['active']) && isset($_SESSION['id_user'])) : ?>
			<h5 style="background-color: white"><?php echo $usr->getName() ;?> </h5>
		<form action="index.php" method="post">	
<input type="hidden" name="deco" value="deco">		
<input type="submit" value="Deconnection" name="disconnect" style="float: right; color: black; border: 1px dotted">
		</form>
		<?php else: ?> 		
			<a style="float: right; color: black; border: 1px dotted" href="login.php">Connection</a>
		<?php endif ?>     
	</nav>  
</header>

<div class="container" >
<?php show_flash() ?>
</div>
