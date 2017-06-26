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
 * Marks a section of a template to be escaped or not.
 *
 * <pre>
 * {% autoescape true %}
 *   Everything will be automatically escaped in this block
 * {% endautoescape %}
 *
 * {% autoescape false %}
 *   Everything will be outputed as is in this block
 * {% endautoescape %}
 *
 * {% autoescape true js %}
 *   Everything will be automatically escaped in this block
 *   using the js escaping strategy
 * {% endautoescape %}
 * </pre>
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_AutoEscape extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$lineno = $token->getLine();
		$stream = $this->parser->getStream();

		if ($stream->test(System_Libraries_Twig_Token::BLOCK_END_TYPE))
		{
			$value = 'html';
		}
		else
		{
			$expr = $this->parser->getExpressionParser()->parseExpression();
			if (!$expr instanceof System_Libraries_Twig_Node_Expression_Constant)
			{
				throw new System_Libraries_Twig_Error_Syntax('An escaping strategy must be a string or a bool.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
			$value = $expr->getAttribute('value');

			$compat = true === $value || false === $value;

			if (true === $value)
			{
				$value = 'html';
			}

			if ($compat && $stream->test(System_Libraries_Twig_Token::NAME_TYPE))
			{
				@trigger_error('Using the autoescape tag with "true" or "false" before the strategy name is deprecated since version 1.21.', E_USER_DEPRECATED);

				if (false === $value)
				{
					throw new System_Libraries_Twig_Error_Syntax('Unexpected escaping strategy as you set autoescaping to false.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
				}

				$value = $stream->next()->getValue();
			}
		}

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);
		$body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_AutoEscape($value, $body, $lineno, $this->getTag());
	}

	public function decideBlockEnd(System_Libraries_Twig_Token $token)
	{
		return $token->test('endautoescape');
	}

	public function getTag()
	{
		return 'autoescape';
	}

}
