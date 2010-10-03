<?php
if ( ! class_exists ( "atom" ) ) {

$model_root = dirname(  __FILE__ ) . "/";
  
if ( ! class_exists( "cache" ) ) {
	// last ditch...
	include( $model_root . "cache.php" );
}

class atom extends cache {
	function atom( $url ) {
		cache::cache($url);
	}
	public function update() {
		$count  = 1;
		$url    = $this->url;
		$BodyContent = "";
		$doc = new DOMDocument();
		$doc->load( $url );
		$items = $doc->getElementsByTagName( "entry" );
		$i = 0;
		
		foreach( $items as $item ) {
			$titles = $item->getElementsByTagName( "title" );
			$dates  = $item->getElementsByTagName( "published" );
			$descrs = $item->getElementsByTagName( "content" );
			
			$title   = $titles->item(0)->nodeValue;
			$date    = $dates->item(0)->nodeValue;
			$descr   = $descrs->item(0)->nodeValue;
			
			$date = strtotime(substr($date, 0, 10) . ' ' . substr($date, 11, 8 ));
			
			$retItem['title'] = clean($title);
			$retItem['date']  = distanceOfTimeInWords($date, time());
			$retItem['descr'] = clean($descr);
			
			$ret[$i] = $retItem;
			++$i;
			if ( $i > $count ) { break; }
		}
		
		$this->cacheValue( json_encode($ret[0]) );
	}
}

}
?>
