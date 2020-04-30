<?php require_once('_config.php');?>
<header style="background-color:  #ccd1d1">

<?php	// choix de la langue
$flags=['&#x1F1EB;&#x1F1F7;','&#x1F1EC;&#x1F1E7;','&#x1F1F7;&#x1F1FA;','&#x1F1E6;&#x1F1F1;','&#x1F1E9;&#x1F1EA;',
'&#x1F1E6;&#x1F1F2;','&#x1F1E7;&#x1F1FE;','&#x1F1E7;&#x1F1E6;','&#x1F1E7;&#x1F1EC;','&#x1F1E8;&#x1F1F3;',
'&#x1F1ED;&#x1F1F7;','&#x1F1E9;&#x1F1F0;','&#x1F1EA;&#x1F1F8;','&#x1F1EC;&#x1F1F7;','&#x1F1EE;&#x1F1F1;',
'&#x1F1ED;&#x1F1FA;','&#x1F1EE;&#x1F1F8;','&#x1F1EE;&#x1F1F9;','&#x1F1EF;&#x1F1F5;','&#x1F1F1;&#x1F1F9;',
'&#x1F1F3;&#x1F1F1;','&#x1F1F3;&#x1F1F4;','&#x1F1F5;&#x1F1F1;','&#x1F1F5;&#x1F1F9;','&#x1F1F7;&#x1F1F4;',
'&#x1F1F7;&#x1F1F8;','&#x1F1F8;&#x1F1EA;','&#x1F1E8;&#x1F1FF;','&#x1F1F9;&#x1F1ED;','&#x1F1F9;&#x1F1F7;',
'&#x1F1FA;&#x1F1E6;'];
$langs=['fr','en','ru','al','de','hy','by','ba','bg','zh','hr','dk','es','gr','il','hu','is','it','jp','lt',
'nl','no','pl','pt','ro','rs','se','cz','th','tr','ua'];

if(isset($_GET['recherche']) || isset($_GET['id']) || isset($_GET['slug'])) {
$i=0;
	while($i!=count($flags)) {
		echo '<a href="'.getLink().'&lang='.$langs[$i].'">'.$flags[$i].'&nbsp;&nbsp;</a>';
		$i++;
	}
}
else {
$i=0;
	while($i!=count($flags)) {
		echo '<a href="'.getLink().'?lang='.$langs[$i].'">'.$flags[$i].'&nbsp;&nbsp;</a>';
		$i++;
	}
}
?>

</header>
