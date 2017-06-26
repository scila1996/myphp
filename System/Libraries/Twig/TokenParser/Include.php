<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Includes a template.
 *
 * <pre>
 *   {% include 'header.html' %}
 *     Body
 *   {% include 'footer.html' %}
 * </pre>
 */
class System_Libraries_Twig_TokenParser_Include extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$expr = $this->parser->getExpressionParser()->parseExpression();

		list($variables, $only, $ignoreMissing) = $this->parseArguments();

		return new System_Libraries_Twig_Node_Include($expr, $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
	}

	protected function parseArguments()
	{
		$stream = $this->parser->getStream();

		$ignoreMissing = false;
		if ($stream->nextIf(System_Libraries_Twig_Token::NAME_TYPE, 'ignore'))
		{
			$stream->expect(System_Libraries_Twig_Token::NAME_TYPE, 'missing');

			$ignoreMissing = true;
		}

		$variables = null;
		if ($stream->nextIf(System_Libraries_Twig_Token::NAME_TYPE, 'with'))
		{
			$variables = $this->parser->getExpressionParser()->parseExpression();
		}

		$only = false;
		if ($stream->nextIf(System_Libraries_Twig_Token::NAME_TYPE, 'only'))
		{
			$only = true;
		}

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return array($variables, $only, $ignoreMissing);
	}

	public function getTag()
	{
		return 'include';
	}

}
