<?
$_skinpath = "ftp/csrank.ini";
function parse_skins ( $path, $sql )
{
		if (!file_exists($path)) 	return false;
		
		$sql->query("DROP TABLE IF EXISTS `CSRank_skins`");
	
		$sql->query("CREATE TABLE `CSRank_skins` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`skin_id` int(10) unsigned NOT NULL,
			`weapon_csw` varchar(34) NOT NULL,
			`weapon_name` varchar(86) NOT NULL,
			`rank` int(3) unsigned NOT NULL, 
			PRIMARY KEY (`id`)
		)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1");
	
		$f = fopen($path, 'r');
		
		$arr = null;
		while (!feof($f))
		{
			$str = fgets($f);
			
			if($str[0] != '"') continue;
			
			$len = strlen($str);
			$in_quote = false;
			for ($i = 0; $i< $len; $i++)
			{
				if ($str[$i] == '"')
					$in_quote = $in_quote ? false : true;
				
				if($str[$i] == ' ' and $in_quote)
					$str[$i] = '_';
			}
			$arr = split(' ', $str);
			
			$skin_id = str_replace("\"", "", $arr[0]);
			$skin_csw = str_replace("\"", "", $arr[1]);
			$skin_name = str_replace("_", " ", $arr[2]);
			$skin_rank = str_replace("\"", "", $arr[count($arr) - 1]);
			
			/*$arr = preg_split('\"[\d|\w+(\s)?\w]+\"', $str);
			$skin_id = $arr[0];
			$skin_csw = $arr[1];
			$skin_name = $arr[2];
			$skin_rank = $arr[count($arr) - 1];*/
			$sql->query("INSERT INTO `CSRank_skins` VALUES ( '', '$skin_id', '$skin_csw', '$skin_name',
			'$skin_rank')");
		}
	
		fclose($f);
		return true;
}