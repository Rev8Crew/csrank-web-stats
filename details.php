<? 
	include_once('php/global.php');
	include_once('php/mysqli.php');

	if (!isset($_POST['pid'])) die ("Error");
	
	

	$sql = new Sqlx();
	$sql->init();

	$pid = $sql->escape($_POST['pid']);
	$lang = $sql->escape($_POST['lang']);
	$query = $sql->mysqli->query("SELECT * FROM CSRank WHERE `id`='$pid'");
	$data = mysqli_fetch_assoc($query);

	$name = $data['player_name'];
	$steam = $data['player_id'];
	$medal = $data['player_medal'];
	$exp = $data['player_exp'];
	$coins = $data['player_coins'];
	$maxcoins = $data['player_coins_total'];

	$skins = get_player_skins($data['player_items']);

	$cases = $data['player_cases'];
	$keys = $data['player_keys'];

echo "
$('#detail-nick').html('$name');
$('#detail-steam').html('$steam');
$('#detail-medal').html('$medal');
$('#detail-exp').html('$exp');
$('#detail-coins').html('$coins');
$('#detail-maxcoins').html('$maxcoins');
$('#detail-skins').html('$skins');
$('#detail-cases').html('$cases');
$('#detail-keys').html('$keys');
$('#loading').hide();
$('#viewpid').attr({'href': 'search.php?pid=$pid&lang=$lang'});
$('#Details').modal();";  ?>