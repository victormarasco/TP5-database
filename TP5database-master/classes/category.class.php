<?php

class Category {
	public function getName() {
		return $this->category_name;
	}

	public function getIdCategory() {
		return $this->id_category;
	}

	public function getPermalink() {
		return 'http://val-bd-miage.u-ga.fr/groupe5/TP4database-master/categorie.php?id='.$this->getIdCategory();
	}
	
	public function getNbArticles() {
		global $pdo;
		$query = sprintf('SELECT * FROM post WHERE id_category=%s',$this->getIdCategory());
		$results = $pdo->query($query);
		$nb_articles=$results->rowcount();
		return $nb_articles;
	}
	public function getNbArticlesActifs() {
		global $pdo;
		$query = sprintf('SELECT * FROM post WHERE id_category=%s AND actif=1',$this->getIdCategory());
		$results = $pdo->query($query);
		$nb_articles=$results->rowcount();
		return $nb_articles;
	}

	public function getPosts() {
		global $pdo;
		$query = sprintf('SELECT * FROM post WHERE id_category=%s',$this->getIdCategory());	
		$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post');
		$posts = $results->fetchAll();
		return $posts;
	}

}

?>
