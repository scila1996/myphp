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
 * Imports blocks defined in another template into the current template.
 *
 * <pre>
 * {% extends "base.html" %}
 *
 * {% use "blocks.html" %}
 *
 * {% block title %}{% endblock %}
 * {% block content %}{% endblock %}
 * </pre>
 *
 * @see http://www.twig-project.org/doc/templates.html#horizontal-reuse for details.
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_Use extends System_Libraries_Twig_TokenParser
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$template = $this->parser->getExpressionParser()->parseExpression();
		$stream = $this->parser->getStream();

		if (!$template instanceof System_Libraries_Twig_Node_Expression_Constant)
		{
			throw new System_Libraries_Twig_Error_Syntax('The template references in a "use" statement must be a string.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
		}

		$targets = array();
		if ($stream->nextIf('with'))
		{
			do
			{
				$name = $stream->expect(System_Libraries_Twig_Token::NAME_TYPE)->getValue();

				$alias = $name;
				if ($stream->nextIf('as'))
				{
					$alias = $stream->expect(System_Libraries_Twig_Token::NAME_TYPE)->getValue();
				}

				$targets[$name] = new System_Libraries_Twig_Node_Expression_Constant($alias, -1);

				if (!$stream->nextIf(System_Libraries_Twig_Token::PUNCTUATION_TYPE, ','))
				{
					break;
				}
			}
			while (true);
		}

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		$this->parser->addTrait(new System_Libraries_Twig_Node(array('template' => $template, 'targets' => new System_Libraries_Twig_Node($targets))));
	}

	public function getTag()
	{
		return 'use';
	}

}
