<?php


/*
 * Traduction de données non structuré.
 * (Cette méthode ne s'applique pas à vos données structurées comme les références, formations, compétences…)
 * Utilisation: dans votre HTML, utilise simplement <?php echo __('sitename') ?> pour avoir la traduction de sitename.
 */


/* Structure de la table i18n (internationalization)
CREATE TABLE `i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lang` varchar(8) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `i18n` (`id`, `name`, `lang`, `value`) VALUES
(1,	'sitename',	'fr',	'Le blog'),
(2,	'sitename',	'en',	'The blog');
*/

/*
 * Permet de récupérer la langue de la page actuelle
 * La langue est définis par une variable dans l'url : ?lang=en
 */
function get_lang()
{
    $langs_available = array('fr', 'en', 'es');
    if (isset($_GET['lang']) && in_array($_GET['lang'], $langs_available)) {
        return $_GET['lang'];
    }

    return 'fr';
}

/*
 * Charge toutes les traductions de cette langue une première fois et les stocke dans un tableau associatif
 * Note: On pourrait choisir de stocker ces informations autre part : fichier .po (gettext) ou .xml (xliff)
 */
function load_translation()
{
    global $pdo;

    $translations = array();

    $sth = $pdo->prepare('SELECT * FROM i18n WHERE lang=?');
    $sth->execute(array(get_lang()));

    foreach ($sth->fetchAll() as $setting) {
        $translations[$setting['name']] = $setting['value'];
    }

    return $translations;
}

$i18n = load_translation();

/*
 * Retourne la traduction d'un terme s'il existe dans la base
 */
function __($message)
{
    global $i18n;

    if (isset($i18n[$message])) {
        return $i18n[$message];
    }

    return $message;
}


/* DE MEME POUR LES CATEGORIES */
function load_translation_category()
{
    global $pdo;

    $translations_category = array();

    $sth = $pdo->prepare('SELECT * FROM category_lang WHERE lang=?');
    $sth->execute(array(get_lang()));

    foreach ($sth->fetchAll() as $setting) {
        $translations_category[$setting['category_name']] = $setting['value'];
    }

    return $translations_category;
}
$i18n_category = load_translation_category();
function __category($message)
{
    global $i18n_category;

    if (isset($i18n_category[$message])) {
        return $i18n_category[$message];
    }

    return $message;
}


/* DE MEME POUR LES POSTS */
function load_translation_post()
{
    global $pdo;

    $translations_post = array();

    $sth = $pdo->prepare('SELECT * FROM post_lang WHERE lang=?');
    $sth->execute(array(get_lang()));

    foreach ($sth->fetchAll() as $setting) {
        $translations_post[$setting['post_id']] = $setting['value'];
    }

    return $translations_post;
}
$i18n_post = load_translation_post();
function __post($message)
{
    global $i18n_post;

    if (isset($i18n_post[$message])) {
        return $i18n_post[$message];
    }

    return $message;
}

function have_lang() {
	if(isset($_GET['lang'])) {
		return $_GET['lang'];
	}
	else {
		return null;
	}
}



