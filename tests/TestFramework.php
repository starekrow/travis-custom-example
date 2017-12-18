<?php /* Copyright (C) 2017 David O'Riva.  MIT License (see LICENSE)
       *****************************************************************/

namespace starekrow\travis_example\tests;

spl_autoload_register( function( $cls ) {
	if (substr( $cls, 0, 25 ) == "starekrow\\travis_example\\") {
		$cls = substr( $cls, 25 );
		include __DIR__ . "/../src/$cls.php";
	}
} );

use Exception;

class TestFramework_Fail extends Exception
{
}

class TestFramework
{
	private $_tf_want_exception;
	private $_tf_name;
	private $_tf_passed = 0;
	private $_tf_failed = 0;

	private function _tf_Begin( $name )
	{
		$n = substr( $name, strpos( $name, "_" ) + 1 );
		$re = '/(?#! splitCamelCase Rev:20140412)
		    # Split camelCase "words". Two global alternatives. Either g1of2:
		      (?<=[a-z])      # Position is after a lowercase,
		      (?=[A-Z])       # and before an uppercase letter.
		    | (?<=[A-Z])      # Or g2of2; Position is after uppercase,
		      (?=[A-Z][a-z])  # and before upper-then-lower case.
		    /x';
		$this->_tf_name = $n = implode( " ", preg_split($re, $n) );
		echo "[      ] " . $n;
		fflush( STDOUT );
	}

	private function _tf_Success()
	{
		++$this->_tf_passed;
		echo str_repeat( "\x08", strlen( $this->_tf_name ) + 8 );
		echo " pass ] " . $this->_tf_name . PHP_EOL;
		fflush( STDOUT );
	}

	private function _tf_Fail( $message = null )
	{
		++$this->_tf_failed;
		echo str_repeat( "\x08", strlen( $this->_tf_name ) + 8 );
		echo "-FAIL-] " . $this->_tf_name . PHP_EOL;
		if (!$message)  $message = $this->_tf_fail_msg;
		if ($message) {
			echo "         Reason: $message" . PHP_EOL;
		}
		fflush( STDOUT );		
	}

	public function ExpectException( $type = "Exception" )
	{
		$this->_tf_want_exception = $type;
	}


	public function FailMessage( $msg )
	{
		$this->_tf_fail_msg = $msg;
	}

	public function Check( $val, $msg = null )
	{
		if (!$val) {
			throw new TestFramework_Fail( $msg );
		}
	}

	public function RunAllTests()
	{
		$eol = PHP_EOL;
		$l = get_class_methods( $this );
		$tl = [];
		foreach ($l as $el) {
			if (preg_match( "/^t[0-9]*_/", $el )) {
				if ($el[1] == "_") {
					//$el = "t50_" . substr( $el, 2 );
				}
				$tl[] = $el;
			}
		}
		sort( $tl );
		echo "$eol";
		foreach ($tl as $el) {
			$this->_tf_want_exception = null;
			$this->_tf_fail_msg = null;
			try {
				$this->_tf_Begin( $el );
				$res = $this->{$el}();
				if ($res === false) {
					$this->_tf_Fail();
				} else {
					$this->_tf_Success();
				}
			} catch (\TestFramework_Fail $e) {
				$this->_tf_Fail( $e->getMessage() );
			} catch (\Exception $e) {
				if ($this->_tf_want_exception) {
					if ($e instanceof $this->_tf_want_exception) {
						$this->_tf_Success();
					} else {
						$this->_tf_Fail( "Unexpected " . get_class( $e ) );
					}
				} else {
					$this->_tf_Fail( "Unexpected " . get_class( $e ) );
				}
			} //PHP 7 only: } catch (FatalException $e) { .. .}
		}
		if ($this->_tf_failed) {
			echo "{$eol}FAILED\x07 " . $this->_tf_failed . " of " . 
				($this->_tf_passed + $this->_tf_failed) . " tests$eol$eol";
			return 1;
		} else {
			echo "{$eol}Passed " . $this->_tf_passed . " tests$eol$eol";
		}
	}
}


if (!empty( $argv[1] ) && $argv[1] == "run" ) {
	$d = opendir( __DIR__ );
	$out = 0;
	echo PHP_EOL;
	for (;$d && ($fn = readdir( $d )) !== FALSE;) {
		if (substr( $fn, -4 ) != ".php"
			|| $fn == "TestFramework.php") {
			continue;
		}
		$cl = substr( $fn, 0, -4 );
		echo "--- $cl ---";
		$cl = "starekrow\\travis_example\\tests\\$cl";
		require( __DIR__ . "/$fn" );
		$ci = new $cl;
		if ($ci->RunAllTests()) {
			$out = 1;
		}
	}
	closedir( $d );
	exit( $out );
}
