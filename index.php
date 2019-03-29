<?
include_once('php/global.php');
include_once('php/ftp.php');
include_once('php/mysqli.php');
include_once('php/paginator.php');
include_once('php/skins.php');

$ftp = new FTP();
$sql = new Sqlx();

try
{
	$sql->connect();
	$ftp->init();
}
catch (Exception $e)
{
	die($e->getMessage());
}

$main = true;

$lang = isset($_GET['lang']) ? $sql->escape($_GET['lang']) : $mLang;
if (!isset($_GET['lang']) and $autoGetLang)
{
	$translate = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	if ($translate != 'ru' and $translate != 'ua')
	{
		?>
		<script type="text/javascript">
		window.location ='?lang=en';
		</script>
		<?
	}
}

include_once("lang/$lang.php");



$label = 1;

$Paginator = new Paginator();
$Paginator->init($sql->mysqli, "SELECT * FROM `CSRank` ORDER by `player_medal` DESC, `player_exp` DESC");
$results = $Paginator->getData( $pagination_per_page,  isset($_GET['page']) ? intval($_GET['page']) : 1 );
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
	
	
<title>CSRank | <?=lang('board_text')?></title>
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
	<? if ($background == ''): ?>
	<table class="table <?=$table_border?> table-hover">
<? else: ?>
	<table class="table <?=$table_border?> table-hover" style="background: white; color: black">
<? endif ?>

    <thead>
        <tr>
            <th>#</th>
            <th><?=lang('nick')?></th>
            <th><?=lang('medals')?></th>
            <th><?=lang('exp')?></th>
            <th><?=lang('coins')?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
 
	<?	for( $i = 0; $i < count( $results->data ); $i++ ): ?>
		<tr >
            <th scope="row"><?=(++$label)?></th>
            <td><span class="label" style="background-color: <?=$color?>"><?=$results->data[$i]['player_name']?></span></td>
            <td><?=$results->data[$i]['player_medal']?></td>
            <td><?=$results->data[$i]['player_exp']?></td>
            <td><?=$results->data[$i]['player_coins']?></td>
            <td><a style="cursor: pointer" onClick="request('<?=$results->data[$i]['id']?>')"><i style="color: <?=$color?>;" class="fa fa-th-large"></i></a></td>
        </tr>
	<? endfor; ?>
    </tbody>
</table>
	</div>
	
<?php echo $Paginator->createLinks( $pagination_num_links, 'pagination' ); ?> 
<div class="row">
<div class="alert alert-info" role="alert">
CSRank 2017.0 | Version 1.0.0
</div>	
</div>
</div>
<div id="loading" style="display: none">
<div class="cssload-loader">
	<div class="cssload-inner cssload-one" style="border-bottom: 8px solid <?=$color?>;"></div>
	<div class="cssload-inner cssload-two" style="border-right: 8px solid <?=$color?>;"></div>
	<div class="cssload-inner cssload-three" style="border-top: 8px solid <?=$color?>;"></div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="Details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: <?=$color?>">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=lang('show_text')?></h4>
      </div>
      <div class="modal-body">
       	<table class="table table-bordered table-hover">
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('nick')?></strong></td>
       		<td class="col-lg-3" id="detail-nick"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong>SteamID</strong></td>
       		<td class="col-lg-3" id="detail-steam"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('medals')?></strong></td>
       		<td class="col-lg-3" id="detail-medal"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('exp')?></strong></td>
       		<td class="col-lg-3" id="detail-exp"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('coins')?></strong></td>
       		<td class="col-lg-3" id="detail-coins"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('maxcoins')?></strong></td>
       		<td class="col-lg-3" id="detail-maxcoins"></td>
       	</tr>
       		<tr>
       		<td class="col-lg-1"> <strong><?=lang('cases')?></strong></td>
       		<td class="col-lg-3" id="detail-cases"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('keys')?></strong></td>
       		<td class="col-lg-3" id="detail-keys"></td>
       	</tr>
       	<tr>
       		<td class="col-lg-1"> <strong><?=lang('skin_num')?></strong></td>
       		<td class="col-lg-3" id="detail-skins"></td>
       	</tr>
       	<tr> 
       		<td colspan="2" style="text-align: center"><a href="#" id="viewpid" class="btn btn-default"><?=lang('show_full_button')?></a></td>
       	</tr>
		</table>
      </div>
      <div class="modal-footer" >
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></button>
      </div>
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
	
	function request( id )
	{
		var pid = id;
		
		$('#loading').show();
		$.post('details.php', {'pid': pid, 'lang': '<?=$lang?>'}, function(data){
		eval(data);
	   });
	}
	</script>
</body>
</html>