<?php /* Copyright (C) 2017 David O'Riva.  MIT License (see LICENSE)
       *****************************************************************/

namespace starekrow\travis_example\tests;

use \starekrow\travis_example\Example;

class ExampleTest extends TestFramework
{
	function t00_Construct()
	{
		$ex = new Example();
	}
	function t30_TestZero()
	{
		$ex = new Example();
		return $ex->ReturnZero() === 0;
	}
	function t31_TestThrow()
	{
		$ex = new Example();
		$this->ExpectException();
		$ex->ThrowSomething();
		// if we get here it didn't work
		return false;
	}

	function t32_TestNull()
	{
		$ex = new Example();
		return $ex->ReturnNull() === null;
	}
	function t32_TestString()
	{
		$ex = new Example();
		$s = $ex->ReturnString();

		return is_string( $s );
	}
}

