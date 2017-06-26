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
 * Creates a nested scope.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_With extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$stream = $this->parser->getStream();

		$variables = null;
		$only = false;
		if (!$stream->test(System_Libraries_Twig_Token::BLOCK_END_TYPE))
		{
			$variables = $this->parser->getExpressionParser()->parseExpression();
			$only = $stream->nextIf(System_Libraries_Twig_Token::NAME_TYPE, 'only');
		}

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		$body = $this->parser->subparse(array($this, 'decideWithEnd'), true);

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_With($body, $variables, $only, $token->getLine(), $this->getTag());
	}

	public function decideWithEnd(System_Libraries_Twig_Token $token)
	{
		return $token->test('endwith');
	}

	public function getTag()
	{
		return 'with';
	}

}
