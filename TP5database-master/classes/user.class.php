<?php

class User {
	
	public function getLogin() {
		return $this->login;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getName() {
		return $this->name;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getIdUser() {
		return $this->id_user;
	}

	public function getArticles() {
		global $pdo;
		$query = sprintf('SELECT * FROM post WHERE id_author=%s',$this->getIdUser());
		$results = $pdo -> query($query, PDO::FETCH_CLASS, 'Post');
		$articles = $results -> fetchAll();
		return $articles;
	} 

	public function getNbArticles() {
		return count($this->getArticles());
	}

}
?>
