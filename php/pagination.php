<?
function pagination($array) 
{
	$page = $_GET['page'] ? $array['mysqli']->escape(abs((int)$_GET['page'])) : 1; 
	$page_total = floor((mysqli_num_rows($array['mysqli']->mysqli->query($array['query'])) - 1) / $array['page_num'] +1);
	
	$page_query = $array['query'].' LIMIT '.($page*$array['page_num']-$array['page_num']).','.$array['page_num'].''; 	
	$page_count = $page*$array['page_num']-$array['page_num']; 												
	$pagination .= '<nav style="text-align: center">
    <ul class="pagination">';
	if($page > 1) $pagination .= '<li><a aria-label="Previous" href="'.$array['url'].'&page='.($page-1).'"> <span aria-hidden="true">&laquo;</span></a></li>';
	for($i = max(1, $page - 2); $i <= min($page + 2, $page_total); $i++)
		if($i==$page)
			$pagination .= '<li class="disabled"><a>'.$i.'</a></li>';
		else
			$pagination .= '<li>'.('<a href="'.$array['url'].'&page='.$i.'">'.$i.'</a>').'</li>';
	$pagination .= ''.($page<$page_total?'<li><a aria-label="Next" href="'.$array['url'].'&page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>':'<li class="disabled"><a><span aria-hidden="true">&raquo;</span></a></li>').'';
	
	if($page_total > 1)
	if($page == $page_total)
		$pagination .= '<li><a href="'.$array['url'].'&page=1">В начало</a></li>';
	else
		$pagination .= '<li><a href="'.$array['url'].'&page='.$page_total.'">В конец</a></li>';
	$pagination .= '</ul></nav>';
	
	return array('query'=>$page_query, 'pages'=>$pagination, 'count'=>$page_count);
}
