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
 * Imports macros.
 *
 * <pre>
 *   {% from 'forms.html' import forms %}
 * </pre>
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_From extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$macro = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();
		$stream->expect('import');

		$targets = array();
		do
		{
			$name = $stream->expect(System_Libraries_Twig_Token::NAME_TYPE)->getValue();

			$alias = $name;
			if ($stream->nextIf('as'))
			{
				$alias = $stream->expect(System_Libraries_Twig_Token::NAME_TYPE)->getValue();
			}

			$targets[$name] = $alias;

			if (!$stream->nextIf(System_Libraries_Twig_Token::PUNCTUATION_TYPE, ','))
			{
				break;
			}
		}
		while (true);

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		$node = new System_Libraries_Twig_Node_Import($macro, new System_Libraries_Twig_Node_Expression_AssignName($this->parser->getVarName(), $token->getLine()), $token->getLine(), $this->getTag());

		foreach ($targets as $name => $alias)
		{
			if ($this->parser->isReservedMacroName($name))
			{
				throw new System_Libraries_Twig_Error_Syntax(sprintf('"%s" cannot be an imported macro as it is a reserved keyword.', $name), $token->getLine(), $stream->getSourceContext());
			}

			$this->parser->addImportedSymbol('function', $alias, 'get' . $name, $node->getNode('var'));
		}

		return $node;
	}

	public function getTag()
	{
		return 'from';
	}

}
