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
 * Returns the value or the default value when it is undefined or empty.
 *
 * <pre>
 *  {{ var.foo|default('foo item on var is not defined') }}
 * </pre>
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_Node_Expression_Filter_Default extends System_Libraries_Twig_Node_Expression_Filter
{

	public function __construct(System_Libraries_Twig_NodeInterface $node, System_Libraries_Twig_Node_Expression_Constant $filterName, System_Libraries_Twig_NodeInterface $arguments, $lineno, $tag = null)
	{
		$default = new System_Libraries_Twig_Node_Expression_Filter($node, new System_Libraries_Twig_Node_Expression_Constant('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());

		if ('default' === $filterName->getAttribute('value') && ($node instanceof System_Libraries_Twig_Node_Expression_Name || $node instanceof System_Libraries_Twig_Node_Expression_GetAttr))
		{
			$test = new System_Libraries_Twig_Node_Expression_Test_Defined(clone $node, 'defined', new System_Libraries_Twig_Node(), $node->getTemplateLine());
			$false = count($arguments) ? $arguments->getNode(0) : new System_Libraries_Twig_Node_Expression_Constant('', $node->getTemplateLine());

			$node = new System_Libraries_Twig_Node_Expression_Conditional($test, $default, $false, $node->getTemplateLine());
		}
		else
		{
			$node = $default;
		}

		parent::__construct($node, $filterName, $arguments, $lineno, $tag);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler->subcompile($this->getNode('node'));
	}

}
