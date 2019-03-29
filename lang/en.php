<? 
function lang($str)
{
	$str = strtolower($str);
    $lang = array(
        'main' 				=> 'Main',
		'lang' 				=> 'Lang',
		'medals'			=> 'Medals',
		'skins'				=> 'Skins',
		'board_text'		=> 'Server players stats',
		'nick'				=> 'Nick',
		'exp'				=> 'Exp',
		'coins'				=> 'Coins',
		'maxcoins'			=> 'Max coins',
		'cases'				=> 'Cases',
		'keys'				=> 'Keys',
		'skin_num'			=> 'Skins num',
		'show_full_button'	=> 'Show details',
		'show_text'			=> 'Player details',
		'close'				=> 'Close',
		'ru'				=> 'Ru',
		'en'				=> 'En',
		'main_info'			=> 'Main info',
		'weapon_skins'		=> 'Weapon skins',
		'skins_text'		=> 'Server skins',
		'souvenir'			=> 'Souvenir',
		'secret'			=> 'Secret',
		'rare'				=> 'Rare',
		'normal'			=> 'Normal',
		'called'			=> 'Name',
		'model'				=> 'Model',
		'class'				=> 'Class'
 
    );
     
    $str = $lang[$str];
    
    if(in_array($str, $lang)) return $str; else return false;
}

function lang_inverse()
{
	return 'ru';
}

function lang_link( $link )
{
	if (!isset($_GET['lang']))	return "$link.php";
	else						return "$link.php?lang=en";
}
function lang_link_add( $link )
{
	if (!isset($_GET['lang']))	return $link;
	else						return "$link&lang=en";
}
?>