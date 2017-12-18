<?php /* Copyright (C) 2017 David O'Riva.  MIT License (see LICENSE)
       *****************************************************************/

namespace starekrow\travis_example;

class Example
{
	function ThrowSomething()
	{
		throw new \Exception( "Ack!" );
	}

	function ReturnZero()
	{
		// Hey look, I broke the build
		return 7;
	}

	function ReturnString()
	{
		return "My thesis, in essence, is that Stalin was a poopyhead.";
	}

	function ReturnNull()
	{
		return null;
	}
}

