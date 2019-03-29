<?
class FTP
{
	private $ftp_server = FTP_HOST;
	private $ftp_user = FTP_USER;
	private $ftp_pass = FTP_PASS;
	private $ftp_path = FTP_DIR;
	
	function getFtpConnection($host, $user, $pass, $path) 
	{ 
		// Set up a connection 
		$conn = ftp_connect($host); 

		// Login 
		if (ftp_login($conn, $user, $pass)) 
		{ 
			// Change the dir 
			ftp_chdir($conn, $path); 

			// Return the resource 
			return $conn; 
		} 

		// Or retun null 
		return -1; 
	} 
	function ftp_get_contents($ftp_stream, $remote_file, $mode, $resume_pos=null){
    $pipes=stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);
    if($pipes===false) return false;
    if(!stream_set_blocking($pipes[1], 0)){
        fclose($pipes[0]); fclose($pipes[1]);
        return false;
    }
    $fail=false;
    $data='';
    if(is_null($resume_pos)){
        $ret=ftp_nb_fget($ftp_stream, $pipes[0], $remote_file, $mode);
    } else {
        $ret=ftp_nb_fget($ftp_stream, $pipes[0], $remote_file, $mode, $resume_pos);
    }
    while($ret==FTP_MOREDATA){
        while(!$fail && !feof($pipes[1])){
            $r=fread($pipes[1], 8192);
            if($r==='') break;
            if($r===false){ $fail=true; break; }
            $data.=$r;
        }
        $ret=ftp_nb_continue($ftp_stream);
    }
    while(!$fail && !feof($pipes[1])){
        $r=fread($pipes[1], 8192);
        if($r==='') break;
        if($r===false){ $fail=true; break; }
        $data.=$r;
    }
    fclose($pipes[0]); fclose($pipes[1]);
    if($fail || $ret!=FTP_FINISHED) return false;
    return $data;
}
	function init()
	{
		if ( file_exists("ftp/csrank.ini"))
		{
			$time = intval(file_get_contents("ftp/tmp.cfg"));
			
			if ($time - time() > 0)
				return false;
			
		}
		$uri = $this->getFtpConnection($this->ftp_server, $this->ftp_user, $this->ftp_pass, $this->ftp_path);
		if ($uri == null)
			throw new Exception('Error Detect');
		
		ftp_get($uri, "ftp/csrank.ini", "CSRank_items.ini", FTP_BINARY);
		$f = fopen("ftp/tmp.cfg", "w");
		fputs($f,time()+1440*60*60);
		fclose($f);
		
		global $_skinpath, $sql;
		parse_skins ( $_skinpath, $sql);
		var_dump($this->ftp_get_contents($uri, "CSRank_items.ini", FTP_BINARY));
	}
}