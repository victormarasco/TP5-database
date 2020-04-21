<?php 

class Comment {
	public function getIdArticle() {
		return $this->id_article;	
	}
	public function getID() {
		return $this->id_comment;
	}
	public function getAuthor() {
		return $this->author;
	}	
	public function getComment() {
		return $this->comment;
	}	
	public function getDate() {
		return $this->published_at;
	}
	
	public function getArticle() {
		global $pdo;
		$query = sprintf('SELECT * FROM post WHERE id_article=%s',$this->getIdArticle());	
		$results = $pdo->query($query, PDO::FETCH_CLASS, 'Post');
		$post = $results->fetch();
		return $post;
	}

}
?>
