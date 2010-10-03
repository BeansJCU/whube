<?php
if ( ! class_exists ( "rss" ) ) {

$model_root = dirname(  __FILE__ ) . "/";
  
if ( ! class_exists( "cache" ) ) {
	// last ditch...
	include( $model_root . "cache.php" );
}

class rss extends cache {
	function rss( $url ) {
		cache::cache($url);
	}
	public function update() {
		$count  = 1;
		$url    = $this->url;
		$BodyContent = "";
		$doc = new DOMDocument();
		$doc->load( $url );
		$items = $doc->getElementsByTagName( "item" );
		$i = 0;

$lookup = array(
	"Jan" => "1",
	"Feb" => "2",
	"Mar" => "3",
	"Apr" => "4",
	"May" => "5",
	"Jun" => "6",
	"Jul" => "7",
	"Aug" => "8",
	"Sep" => "9",
	"Oct" => "10",
	"Nov" => "11",
	"Dec" => "12",
);

		foreach( $items as $item ) {
			$titles = $item->getElementsByTagName( "title" );
			$links = $item->getElementsByTagName( "link" );
			$dates  = $item->getElementsByTagName( "pubDate" );
			$descrs = $item->getElementsByTagName( "description" );
			$title = $titles->item(0)->nodeValue;
			$link = $links->item(0)->nodeValue;
			$date = $dates->item(0)->nodeValue;
			$descr = $descrs->item(0)->nodeValue;
			$retItem['title'] = clean($title);
			$retItem['link']  = clean($link);

			$stringArray = explode(" ", $date);

			$day   = $stringArray[1];
			$month = $lookup[$stringArray[2]];
			$year  = $stringArray[3];

			$time =  explode(":", $stringArray[4]);

			$date = mktime($time[0],$time[1],$time[2],$month,$day,$year); 
			$retItem['date'] = distanceOfTimeInWords($date, time());

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
