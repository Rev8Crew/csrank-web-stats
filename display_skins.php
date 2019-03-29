<?
include_once('php/global.php');
include_once('php/mysqli.php');

$sql = new Sqlx();
$sql->connect();

$display_skins = true;

$label = 0;

$res = $sql->query("SELECT * FROM `CSRank_skins` ORDER BY `rank` DESC, `id`");

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
	
	
<title>CSRank | <?=lang('skins')?></title>
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
			<h1><?=$_SERVER['HTTP_HOST']?><br><small><?=lang('skins_text')?></small></h1>

</div>
	</div> 
	<div class="row">
	<? if ($background == ''): ?>
	<table class="table <?=$table_border?> table-hover">
<? else: ?>
	<table class="table <?=$table_border?> table-hover" style="background: white; color: black">
<? endif ?>

    <thead>
        <tr>
            <th>#</th>
            <th><?=lang('name')?></th>
            <th><?=lang('model')?></th>
            <th><?=lang('class')?></th>
        </tr>
    </thead>
    <tbody>
 
	<?	while ($data = mysqli_fetch_assoc($res)): ?>
	
	<? 
		$col_rank = lang('normal');
		
		switch ($data['rank']):
		case 4: $col_rank = '<font color="yellow">'.lang('souvenir').'</font>';break;
		case 3: $col_rank = '<font color="red">'.lang('secret').'</font>';break;
		case 2: $col_rank = '<font color="grey">'.lang('rare').'</font>';break;
		endswitch;
		
		?>
		<tr >
            <th scope="row"><?=(++$label)?></th>
            <td><?=$data['weapon_name']?></td>
            <td><span class="label" style="background-color: <?=$color?>"><?=substr($data['weapon_csw'],7)?></span></td>
            
            <td><?=$col_rank?></td>
        </tr>
	<? endwhile; ?>
    </tbody>
</table>
	</div>
	
<div class="row">
<div class="alert alert-info" role="alert">
CSRank 2017.0 | Версия веб-сайта 1.0.0
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