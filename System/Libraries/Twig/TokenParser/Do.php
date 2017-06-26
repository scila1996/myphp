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
 * Evaluates an expression, discarding the returned value.
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_Do extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$expr = $this->parser->getExpressionParser()->parseExpression();

		$this->parser->getStream()->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_Do($expr, $token->getLine(), $this->getTag());
	}

	public function getTag()
	{
		return 'do';
	}

}
