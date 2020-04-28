<?php


function slugify($string)
{
    // replace non letter or digits by -
    $slug = preg_replace('~[^\pL\d]+~u', '-', $string);

    // transliterate
    $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

    // remove unwanted characters
    $slug = preg_replace('~[^-\w]+~', '', $slug);

    // trim
    $slug = trim($slug, '-');

    // remove duplicate -
    $slug = preg_replace('~-+~', '-', $slug);

    // lowercase
    $slug = strtolower($slug);

    if (empty($slug)) {
       $slug= 'n-a';
    }

global $pdo;
$query='SELECT * from post WHERE slug='.$pdo->quote($slug);
$rs=$pdo->query($query)->fetch();
if(!$rs) {
	return $slug;
}
else {
	return $slug.'-'.rand(0,1000000);
}

}

