<?
$color = '#337ab7';
//$color = 'rgba(255, 0, 0, 0.84)';
// Type : '' for white color | img/background.jpg
$background = '';
// Оставьте '' если не хотите границ у таблицы иначе 'table-bordered'
$table_border = '';

$website = 'http://yoursite.ru/csrank/';
$pagination_per_page = 15;
$pagination_num_links = 3;

$mLang = 'ru';
$autoGetLang = true;

// Настройки подключения к FTP и MySql
define(FTP_HOST, "");
define(FTP_USER, "");
define(FTP_PASS, "");
define(FTP_DIR, "addons/amxmodx/configs/");

define(SQL_HOST, "localhost");
define(SQL_USER, "");
define(SQL_PASS, "");
define(SQL_DB, "");

function get_player_skins( $str )
{
	$str = str_replace("  ", " ", $str);
	$str = split(' ', $str);
	$skins = count($str) - 1;
	return $skins;
}

$weapons = array(
		"", "weapon_p228", "weapon_shield", "weapon_scout", "weapon_hegrenade", "weapon_xm1014", "weapon_c4",
		"weapon_mac10", "weapon_aug", "weapon_smokegrenade", "weapon_elite", "weapon_fiveseven", "weapon_ump45",
		"weapon_sg550", "weapon_galil", "weapon_famas", "weapon_usp", "weapon_glock18", "weapon_awp", "weapon_mp5navy",
		"weapon_m249", "weapon_m3", "weapon_m4a1", "weapon_tmp", "weapon_g3sg1", "weapon_flashbang", "weapon_deagle",
		"weapon_sg552", "weapon_ak47", "weapon_knife", "weapon_p90"
	);