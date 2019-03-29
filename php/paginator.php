<? 
class Paginator {

	private $_conn;
	private $_limit;
	private $_page;
	private $_query;
	private $_total;
	
	public function init( $conn, $query)
	{
		$this->_conn = $conn;
		$this->_query = $query;
		$rs = $this->_conn->query( "SELECT COUNT(*) FROM `CSRank`" );
		$data = mysqli_fetch_array($rs);
		$this->_total = $data[0];
	}

	public

	function getData( $limit = 10, $page = 1 ) {

		global $label;
		
		$this->_limit = $limit;
		$this->_page = $page;
		if ( $this->_limit == 'all' ) {
			$query = $this->_query;
		} else {
			$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		$rs = $this->_conn->query( $query );

		while ( $row = $rs->fetch_assoc() ) {
			$results[] = $row;
		}

		$result = new stdClass();
		$result->page = $this->_page;
		$result->limit = $this->_limit;
		$result->total = $this->_total;
		$result->data = $results;

		$label = ( $this->_page - 1 ) * $this->_limit;
		return $result;
	}
	public

	function createLinks( $links, $list_class ) {
		if ( $this->_limit == 'all' ) {
			return '';
		}

		global $color;
		
		$last = ceil( $this->_total / $this->_limit );

		$start = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

		$html = '<nav style="text-align:center"><ul class="' . $list_class . '">';

		$class = ( $this->_page == 1 ) ? "disabled" : "";
		$html .= '<li class="' . $class . '"><a style="color: '.$color.'"href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

		if ( $start > 1 ) {
			$html .= '<li><a style="color: '.$color.'"href="?limit=' . $this->_limit . '&page=1">1</a></li>';
			$html .= '<li class="disabled"><span>...</span></li>';
		}

		for ( $i = $start; $i <= $end; $i++ ) {
			$class = ( $this->_page == $i ) ? "active" : "";
			$cc = ( $this->_page == $i ) ? 'style="background-color: '.$color.'"' : ' style="color: '.$color.'"';
			$html .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '" '.$cc.'>' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			$html .= '<li class="disabled"><span>...</span></li>';
			$html .= '<li><a  style="color: '.$color.'" href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
		}

		$class = ( $this->_page == $last ) ? "disabled" : "";
		$html .= '<li class="' . $class . '"><a style="color: '.$color.'" href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

		$html .= '</ul></nav>';

		return $html;
	}

}