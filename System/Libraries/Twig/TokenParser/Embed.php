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
 * Embeds a template.
 *
 * @final
 */
class System_Libraries_Twig_TokenParser_Embed extends System_Libraries_Twig_TokenParser_Include
{

	public function parse(System_Libraries_Twig_Token $token)
	{
		$stream = $this->parser->getStream();

		$parent = $this->parser->getExpressionParser()->parseExpression();

		list($variables, $only, $ignoreMissing) = $this->parseArguments();

		$parentToken = $fakeParentToken = new System_Libraries_Twig_Token(System_Libraries_Twig_Token::STRING_TYPE, '__parent__', $token->getLine());
		if ($parent instanceof System_Libraries_Twig_Node_Expression_Constant)
		{
			$parentToken = new System_Libraries_Twig_Token(System_Libraries_Twig_Token::STRING_TYPE, $parent->getAttribute('value'), $token->getLine());
		}
		elseif ($parent instanceof System_Libraries_Twig_Node_Expression_Name)
		{
			$parentToken = new System_Libraries_Twig_Token(System_Libraries_Twig_Token::NAME_TYPE, $parent->getAttribute('name'), $token->getLine());
		}

		// inject a fake parent to make the parent() function work
		$stream->injectTokens(array(
			new System_Libraries_Twig_Token(System_Libraries_Twig_Token::BLOCK_START_TYPE, '', $token->getLine()),
			new System_Libraries_Twig_Token(System_Libraries_Twig_Token::NAME_TYPE, 'extends', $token->getLine()),
			$parentToken,
			new System_Libraries_Twig_Token(System_Libraries_Twig_Token::BLOCK_END_TYPE, '', $token->getLine()),
		));

		$module = $this->parser->parse($stream, array($this, 'decideBlockEnd'), true);

		// override the parent with the correct one
		if ($fakeParentToken === $parentToken)
		{
			$module->setNode('parent', $parent);
		}

		$this->parser->embedTemplate($module);

		$stream->expect(System_Libraries_Twig_Token::BLOCK_END_TYPE);

		return new System_Libraries_Twig_Node_Embed($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
	}

	public function decideBlockEnd(System_Libraries_Twig_Token $token)
	{
		return $token->test('endembed');
	}

	public function getTag()
	{
		return 'embed';
	}

}
