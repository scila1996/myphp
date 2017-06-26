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
 * Filters a section of a template by applying filters.
 *
 * <pre>
 * {% filter upper %}
 *  This text becomes uppercase
 * {% endfilter %}
 * </pre>
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_Filter extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$name = $this->parser->getVarName();
		$ref = new System_Libraries_Twig_Node_Expression_BlockReference(new System_Libraries_Twig_Node_Expression_Constant($name, $token->getLine()), null, $token->getLine(), $this->getTag());

		$filter = $this->parser->getExpressionParser()->parseFilterExpressionRaw($ref, $this->getTag());
		$this->parser->getStream()->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		$body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
		$this->parser->getStream()->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		$block = new System_Libraries_Twig_Node_Block($name, $body, $token->getLine());
		$this->parser->setBlock($name, $block);

		return new System_Libraries_Twig_Node_Print($filter, $token->getLine(), $this->getTag());
	}

	public function decideBlockEnd(System_Libraries_Twig_Token $token)
	{
		return $token->test('endfilter');
	}

	public function getTag()
	{
		return 'filter';
	}

}
