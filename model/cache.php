<?php
if ( ! class_exists ( "cache" ) ) {

$model_root = dirname(  __FILE__ ) . "/";
  
if ( ! class_exists( "sql" ) ) {
	// last ditch...
	include( $model_root . "sql.php" );
}

abstract class cache {
	var $sql;
	var $url;
	var $cache_table;
	var $pk;
	var $ttl;

	function cache( $url ) {
		$this->sql = new sql();
		$this->url = $url;
		$this->cache_table = "cache";
		$this->pk          = "url";
		$this->ttl         = ( 60 * 60 ); // seconds
	}

	function outdated() {
		$this->sql->query( "SELECT * FROM " . $this->cache_table . " WHERE " . $this->pk . " = '" . $this->url . "';" );
		if ( $row = $this->sql->getNextRow() ) {
			if ( ( $row['timeski'] + $this->ttl ) < time() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	function cacheValue( $value ) {
		$this->sql->query( "SELECT * FROM " . $this->cache_table . " WHERE " . $this->pk . " = '" . $this->url . "';" );
		if ( $row = $this->sql->getNextRow() ) {
			$this->sql->query( "UPDATE " . $this->cache_table . " SET valueski = '" . $value . "' WHERE " . $this->pk . " = '" . $this->url . "';" );
			$this->sql->query( "UPDATE " . $this->cache_table . " SET timeski = '"  . time() . "' WHERE " . $this->pk . " = '" . $this->url . "';" );
			// echo "Should be set to " . time() . "<br />";
		} else {
			$this->sql->query( "INSERT INTO " . $this->cache_table . " VALUES ( '" . $this->url . "', '" . $value . "', '" . time() . "' );" );
		}
	}

	function toString() {
		$this->sql->query( "SELECT * FROM " . $this->cache_table . " WHERE " . $this->pk . " = '" . $this->url . "';" );
		$row = $this->sql->getNextRow();

		if ( isset( $row['url'] ) ) {
			return $row['valueski'];
		} else {
			return "Unknown";
		}
	}

	public function getValue() {
		if ( $this->outdated() ) {
			$this->update();
			return $this->toString();
		} else {
			return $this->toString();
		}
	}

	abstract function update();
}

}
?>
