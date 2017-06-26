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
 * Tests a condition.
 *
 * <pre>
 * {% if users %}
 *  <ul>
 *    {% for user in users %}
 *      <li>{{ user.username|e }}</li>
 *    {% endfor %}
 *  </ul>
 * {% endif %}
 * </pre>
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_If extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$lineno = $token->getLine();
		$expr = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();
		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);
		$body = $this->parser->subparse(array($this, 'decideIfFork'));
		$tests = array($expr, $body);
		$else = null;

		$end = false;
		while (!$end)
		{
			switch ($stream->next()->getValue())
			{
				case 'else':
					$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);
					$else = $this->parser->subparse(array($this, 'decideIfEnd'));
					break;

				case 'elseif':
					$expr = $this->parser->getExpressionParser()->parseExpression();
					$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);
					$body = $this->parser->subparse(array($this, 'decideIfFork'));
					$tests[] = $expr;
					$tests[] = $body;
					break;

				case 'endif':
					$end = true;
					break;

				default:
					throw new System_Libraries_Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "else", "elseif", or "endif" to close the "if" block started at line %d).', $lineno), $stream->getCurrent()->getLine(), $stream->getSourceContext());
			}
		}

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_If(new System_Libraries_Twig_Node($tests), $else, $lineno, $this->getTag());
	}

	public function decideIfFork(System_Libraries_Twig_Token $token)
	{
		return $token->test(array('elseif', 'else', 'endif'));
	}

	public function decideIfEnd(System_Libraries_Twig_Token $token)
	{
		return $token->test(array('endif'));
	}

	public function getTag()
	{
		return 'if';
	}

}
