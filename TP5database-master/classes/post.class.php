<?php
require_once('classes/comment.class.php');
class Post {
	// fonctions pour recuperer les champs de la base de donnees
	public function getIdArticle() {
		return $this->id_article;
	}
	public function getIdCategory() {
		return $this->id_category;
	}
	public function getIdAuthor() {
		return $this->id_author;
	}		
	public function getTitle() {
		return $this->title;
	}	
	public function getContent() {
		return $this->content;
	}
	public function getSummary() {
		return $this->summary;
	}		
	public function getActive() {
		return $this->actif;
	}
	public function getDate() {
		return $this->date;
	}
	public function getSlug() {
		return $this->slug;
	}

	// fonctions renvoyant des champs d'autres tables
	public function getAuthorName() {
		global $pdo;
		$query = sprintf('SELECT name FROM user WHERE id_user=%s',$this->getIdAuthor());
		$result = $pdo -> query($query);
		$name = $result -> fetch();
		return $name['name'];
	}
	public function getCategoryName() {
		global $pdo;
		$query = sprintf('SELECT category_name FROM category WHERE id_category=%s',$this->getIdCategory());
		$result = $pdo -> query($query);
		$name = $result -> fetch();
		return $name['category_name'];
	}

	public function getCategory() {
		global $pdo;
		$query = sprintf('SELECT * FROM category WHERE id_category=%s', $this->getIdCategory());
		$result = $pdo -> query($query, PDO::FETCH_CLASS, 'Category');
		$category = $result -> fetch();
		return $category;
	}

	// renvoi la date au format Jour num_jour Mois num_annee
	public function getFormatedDate() {
		return date('l d F Y',strtotime($this->getDate()));
	}

	// renvoi l'url de l'article
	public function getPermalink() {
		return 'http://val-bd-miage.u-ga.fr/groupe5/TP4database-master/post.php?slug='.$this->getSlug();
	}
	
	public function getPermalinkEdit() {
		return 'http://val-bd-miage.u-ga.fr/groupe5/TP4database-master/post-edit.php?id='.$this->getIdArticle();
	}
	// renvoi les commentaires lies a l'article
	public function getComments() {
		global $pdo;
		$query = sprintf('SELECT * FROM comment WHERE id_article=%s',$this->getIdArticle());	
		$results = $pdo->query($query, PDO::FETCH_CLASS, 'Comment');
		$commentaires = $results->fetchAll();
		return $commentaires;
	}
	
	public function getNbComments() {
		return count($this->getComments());
	}

	// ajoute un commentaire
	public function addComment($nom, $commentaire) {
		global $pdo;
  		$query = sprintf('INSERT INTO comment (id_article, author, comment, published_at) VALUES (%s, %s, %s, NOW())',
				$this->getIdArticle(),$pdo->quote($nom),$pdo->quote($commentaire));
		var_dump($query);
  		$result = $pdo->exec($query);
  		if ($result) {
      			add_flash('success', 'Merci pour votre commentaire');
      			header('Location: '.$this->getPermalink());
  		}
				
	}


	public function slugify($string, $delimiter = '-') {
	$oldLocale = setlocale(LC_ALL, '0');
	setlocale(LC_ALL, 'en_US.UTF-8');
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower($clean);
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = trim($clean, $delimiter);
	setlocale(LC_ALL, $oldLocale);
	return $clean;
	}
	

}
?>

