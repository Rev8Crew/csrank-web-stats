<?
function lang($str)
{
	$str = strtolower($str);
    $lang = array(
        'main' 				=> 'Главная',
		'lang' 				=> 'Язык',
		'medals'			=> 'Медали',
		'skins'				=> 'Скины',
		'board_text'		=> 'Статистика игроков сервера',
		'nick'				=> 'Ник',
		'medals'			=> 'Медали',
		'exp'				=> 'Опыт',
		'coins'				=> 'Монеты',
		'maxcoins'			=> 'Макс. монет',
		'cases'				=> 'Кейсы',
		'keys'				=> 'Ключи',
		'skin_num'			=> 'Количество скинов',
		'show_full_button'	=> 'Показать подробности',
		'show_text'			=> 'Подробности игрока',
		'close'				=> 'Закрыть',
		'ru'				=> 'Русский',
		'en'				=> 'English',
		'main_info'			=> 'Основная информация',
		'weapon_skins'		=> 'Скины оружия',
		'skins_text'		=> 'Скины сервера',
		'souvenir'			=> 'Сувенирный',
		'secret'			=> 'Тайное',
		'rare'				=> 'Редкий',
		'normal'			=> 'Обычный',
		'called'			=> 'Название',
		'model'				=> 'Модель',
		'class'				=> 'Класс'
 
    );
    
    $str = $lang[$str];
    
    if(in_array($str, $lang)) return $str; else return false;
}

function lang_inverse()
{
	return 'en';
}

function lang_link( $link )
{
	if (!isset($_GET['lang']))	return "$link.php";
	else						return "$link.php?lang=ru";
}
function lang_link_add( $link )
{
	if (!isset($_GET['lang']))	return $link;
	else						return "$link&lang=ru";
}
?>