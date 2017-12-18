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
		return 0;
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

