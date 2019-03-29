<?
class Sqlx
{
	private $host = SQL_HOST;
	private $user = SQL_USER;
	private $pass = SQL_PASS;
	private $db = SQL_DB;
	
	public $mysqli;
	
	function init()
	{
		$this->mysqli = new mysqli($this->host, $this->user, $this->pass);
		return (@$this->mysqli and $this->mysqli->select_db($this->db)); 
	}
	function charset()
	{
		$this->mysqli->query("set names utf8");
	}
	
	function query( $query)
	{
		return $this->mysqli->query($query);
	}
	
	function connect()
	{
		$this->init();
		$this->charset();
	}
	
	function escape( $string )
	{
		return $this->mysqli->real_escape_string($string);
	}
}