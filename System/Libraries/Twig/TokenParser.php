<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class System_Libraries_Twig_TokenParser implements System_Libraries_Twig_TokenParserInterface
{

	/**
	 * @var System_Libraries_Twig_Parser
	 */
	protected $parser;

	/**
	 * Sets the parser associated with this token parser.
	 */
	public function setParser(System_Libraries_Twig_Parser $parser)
	{
		$this->parser = $parser;
	}

}
