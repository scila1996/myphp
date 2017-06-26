<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class System_Libraries_Twig_Node_Expression_Binary_StartsWith extends System_Libraries_Twig_Node_Expression_Binary
{

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$left = $compiler->getVarName();
		$right = $compiler->getVarName();
		$compiler
				->raw(sprintf('(is_string($%s = ', $left))
				->subcompile($this->getNode('left'))
				->raw(sprintf(') && is_string($%s = ', $right))
				->subcompile($this->getNode('right'))
				->raw(sprintf(') && (\'\' === $%2$s || 0 === strpos($%1$s, $%2$s)))', $left, $right))
		;
	}

	public function operator(System_Libraries_Twig_Compiler $compiler)
	{
		return $compiler->raw('');
	}

}