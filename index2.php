<?php
$page_title = "Список банов сервера";
//error_reporting( E_ALL );
include_once("connect.php");
include_once("b_page_head.tpl");
include("pag.inc.php");

if(isset($_GET['bid']))
{
	$bid = $_GET['bid'];
	$q = mysql_query("SELECT * FROM  `b_bans` WHERE  `bid` = $bid");
	$r = mysql_fetch_array($q, MYSQL_ASSOC);

	if(isset($_GET['unban']))
	{
		if($level >= 2)
		{
			if(isset($_GET['true']))
			{

				$q = mysql_query("UPDATE `b_bans` SET `expired` = '1', `unbanned` = '1' WHERE `bid` = $bid");
				$q = mysql_affected_rows();

				if($q)
				{
					$formatex .=  "<div class='alert alert-success'>Игрок успешно разбанен!</div>";
				}
				else
				{
					$formatex .=  "<div class='alert alert-info'>Данный игрок не обнаружен в списке забаненых.</div>";
				}
			}
			else
			{
				$formatex .= 'Вы уверены, что хотите разбанить игрока '.$r['player_nick'].'?</br>';
				$formatex .= '<a href="./b_bans.php?bid='.$bid.'&unban=1&true=1"><button type="button" class="btn btn-default btn-sm">Да</button></a>';
				$formatex .= '<a href="./b_bans.php?bid='.$bid.'"><button type="button" class="btn btn-default btn-sm">Нет</button></a>';
			}
		}
		else
		{
			$formatex .=  "<div class='alert alert-danger'>У вас нет требуемого уровня доступа для данной операции!</div>";
		}
		
		$formatex .= '</br></br><a href="./b_bans.php?bid='.$bid.'">« Вернуться</a>';

	}
	else
	{

	$r['ban_type'] = $r['ban_type'] > 1 ? 'IP' : 'STEAM';

	$str = $r['unbanned'] > 0 ? 'Разбанен' : date('d-m-Y H:i:s', $r['ban_created']+$r['ban_length']*60);

	$expired = $r['expired'] > 0 ? "<span class='glyphicon glyphicon-ok'></span><font color='green'> <b>Истек</b></font> ($str)" : "<span class='glyphicon glyphicon-lock'></span><font color='red'> <b>Не истек</b></font> ($str)";
	$r['ban_created'] = date('d-m-Y H:i:s', $r['ban_created']);

	$formatex .= '<table class="table table-hover"><thead><tr><th><small>Название</small></th><th><small>Описание</small>';

	if($level >= 2 && $r['expired'] < 1)
	{
	$formatex .= '<a href="./b_bans.php?bid='.$r['bid'].'&edit=steam"><button type="button" class="btn btn-info btn-sm pull-right" disabled="disabled"><span class="glyphicon glyphicon-pencil"></span> Изменить</button></a> <a href="./b_bans.php?bid='.$r['bid'].'&unban=1"> <button type="button" class="btn btn-info btn-sm pull-right"><span class="glyphicon glyphicon-thumbs-up"></span> Разбанить</button></a></th></tr></thead><tbody>';
	}
	else
	{
	$formatex .= '<a href="./b_bans.php?bid='.$r['bid'].'&edit=steam"><button type="button" class="btn btn-info btn-sm pull-right" disabled="disabled"><span class="glyphicon glyphicon-pencil"></span> Изменить</button></a> <a href="./b_bans.php?bid='.$r['bid'].'&unban=1"> <button type="button" class="btn btn-info btn-sm pull-right" disabled="disabled"><span class="glyphicon glyphicon-thumbs-up"></span> Разбанить</button></a></th></tr></thead><tbody>';
	}

	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Ник</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['player_nick'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">IP</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['player_ip'].'</small></td></tr>';

	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">STEAM</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['player_id'].'</small></td></tr>';

	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Админ</span></b></td><td><span class="glyphicon glyphicon-user"></span> <small>'.$r['admin_nick'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">STEAM_ID Админа</span></b></td><td><span class="glyphicon glyphicon-user"></span> <small>'.$r['admin_id'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Тип бана</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['ban_type'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Причина</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['ban_reason'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Дата</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['ban_created'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Время</span></b></td><td><span class="glyphicon glyphicon-time"></span> <small>'.$r['ban_length'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Сервер</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$r['server_name'].'</small></td></tr>';
	$formatex .= '<tr><td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">Истек</span></b></td><td><small>'.$expired.'</small></td></tr>';

	$formatex .= '</tbody></table></br>';

//if(isset($_GET['edit']))
//{

//$formatex .= '<form class="form-inline" role="form" action="b_bans.php" method="POST"><h4 class="form-signin-heading">Изменение данных</h4><div class="form-group"><input type="login" class="form-control" name="time" placeholder="Введите время бана"></div><button type="submit" class="btn btn-primary" name="time_submit">Сохранить</button></form>';

//}

}

}
else
{
$scriptname = basename(__FILE__);
$q = paging("SELECT * FROM `b_bans` ORDER BY `ban_created` DESC", $scriptname, '', 0);

if($q)
{

	$formatex .= '<table class="table table-hover"><thead><tr><th><small>Ник</small></th><th><small>Причина</small></th><th><small>Время</small></th><th><small>Админ</small></th><th><small>Описание</small></th></tr></thead><tbody>';

	while($r = mysql_fetch_array($q, MYSQL_ASSOC))
	{
	    $ban_length = $r['ban_length'];
	    $expired = $r['expired'];
	     
	    if($expired > 0)
	    {
			$expired_tr = "<tr class='success'>";
	    	$ban_length .= " <span class='glyphicon glyphicon-ok'>";
	    }
	    else
	    {
			if($r['ban_length'] < 1)
			{
				$expired_tr = "<tr class='danger'>";
			}
			else
			{
				$expired_tr = "<tr>";
			}
			
	    	$ban_length .= " <span class='glyphicon glyphicon-lock'>";
	    }
		$sendmsg_str = '<a href="./b_bans.php?bid='.$r['bid'].'"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span> Подробнее</button></a>';
		$reason = mb_substr($r['ban_reason'], 0, 15, 'UTF-8');
		
		
		$formatex .= $expired_tr.'<td><span class="glyphicon glyphicon-user"></span> <b><span class="label label-primary">'.$r['player_nick'].'</span></b></td><td><span class="glyphicon glyphicon-globe"></span> <small>'.$reason.'</small></td><td><span class="glyphicon glyphicon-time"></span> <small>'.$ban_length.'</small></td><td><span class="glyphicon glyphicon-user"></span> <small>'.$r['admin_nick'].'</small></td><td>'.$sendmsg_str.'</td></tr>';
	};

	$formatex .= '</tbody></table></br>'.$page_links;
}

else
	$formatex = 'Нет пользователей';
}
echo $formatex;


include_once("b_page_foot.tpl");
?>