<?
include_once('php/global.php');
include_once('php/mysqli.php');

$sql = new Sqlx();
$sql->connect();

$pid = isset($_GET['pid']) ? $sql->escape($_GET['pid']) : -1;

if ($pid == -1)
	echo '<script type="text/javascript"> window.location="index.php" </script>';

$data = mysqli_fetch_assoc($sql->mysqli->query("SELECT * FROM `CSRank` WHERE (`id`='$pid' OR `player_id` = '$pid' OR `player_ip` = '$pid' OR `player_name` = '%$pid%' OR `player_name` LIKE '%$pid%') LIMIT 1"));

$lang = isset($_GET['lang']) ? $sql->escape($_GET['lang']) : $mLang;

include_once("lang/$lang.php");
?>


<!doctype html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Content-Language" content="ru"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	
	<meta name="author" content="RevCrew (Skype:revcrew77)"/>
	<meta name="copyright" content="RevCrew (Skype:revcrew77)"/>
	<meta name="generator" content="RevCrew (Skype:revcrew77)"/>
	
	<link href="favicon.ico" rel="shortcut icon"/>
	
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/loader.css"/>
	
	
<title>CSRank | <?=lang('show_text')?></title>
</head>

<? if ($background == ''): ?>
<body>
<? else: ?>
<body style="background: url(<?=$background?>)">
<? endif ?>
<? include_once("php/menu.php");?>
<div class="container">
	<div class="row">
		<div class="jumbotron">
			<h1><?=$_SERVER['HTTP_HOST']?><br><small><?=lang('board_text')?></small></h1>

</div>
	</div> 
	<div class="row">
	<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading"><?=lang('show_text')?> <?=$data['player_name']?></div>
		<div class="panel-body"><p><strong><?=lang('main_info')?></strong></p></div>

    <!-- Table -->
    <table class="table table-bordered table-hover">
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('nick')?></strong></td>
       		<td class="col-lg-3"><?=$data['player_name']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong>SteamID</strong></td>
       		<td class="col-lg-3"><?=$data['player_id']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('medals')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_medal']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('exp')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_exp']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('coins')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_coins']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('maxcoins')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_coins_total']?></td>
       	</tr>
       		<tr>
       		<td class="col-lg-1"> <strong><?=lang('cases')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_cases']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('keys')?></strong></td>
       		<td class="col-lg-3"> <?=$data['player_keys']?></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('skin_num')?></strong></td>
       		<td class="col-lg-3"> <?=get_player_skins($data['player_items'])?></td>
       	</tr>
		</table>
		<div class="panel-body"><p> <strong><?=lang('weapon_skins')?></strong></p><p></p></div>

    <!-- Table -->
    <table class="table table-bordered table-hover">
<? 
		$weap = split(' ',str_replace("  ", " ",$data['player_weapon_skin']));
	  	$weap = array_slice($weap,1);
	  	foreach( $weapons as $index=>$weapon):
	  		$curr_weap = $weap[$index];
	  
	  		if( $curr_weap == 0)	continue;
				
			$res = mysqli_fetch_assoc($sql->query("SELECT * FROM `CSRank_skins` WHERE `skin_id`='$curr_weap'"));
				
			$res_cc = $res['weapon_name'];
				
			switch ($res['rank']):
			case 4: $res_cc = '<font color="yellow">'.$res['weapon_name'].'</font>';break;
			case 3: $res_cc = '<font color="red">'.$res['weapon_name'].'</font>';break;
			case 2: $res_cc = '<font color="grey">'.$res['weapon_name'].'</font>';break;
			endswitch;
		?>
       	<tr>
       		<td class="col-lg-1"><?=substr($weapon, 7, strlen($weapon)-1) ?></td>
       		<td class="col-lg-3"><?=$res_cc?></td>
       	</tr>
       	<? endforeach; ?>
		</table>
</div>	
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	var s_show = false;
	
	function	ShowSearch()
	{
		s_show = (s_show == false) ? true : false;
		
		document.getElementById('search_icon').style.display='none';
		$('#search').toggle('slow', function() {
			s_show ? document.getElementById('search_icon').style.position='' : document.getElementById('search_icon').style.position='absolute';
			document.getElementById('search_icon').style.display='';
		});
	}
</script>
</body>
</html>