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
 * Flushes the output to the client.
 *
 * @see flush()
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_Flush extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$this->parser->getStream()->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_Flush($token->getLine(), $this->getTag());
	}

	public function getTag()
	{
		return 'flush';
	}

}
