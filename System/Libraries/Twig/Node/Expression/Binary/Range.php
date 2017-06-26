<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class System_Libraries_Twig_Node_Expression_Binary_Range extends System_Libraries_Twig_Node_Expression_Binary
{

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->raw('range(')
				->subcompile($this->getNode('left'))
				->raw(', ')
				->subcompile($this->getNode('right'))
				->raw(')')
		;
	}

	public function operator(System_Libraries_Twig_Compiler $compiler)
	{
		return $compiler->raw('..');
	}

}
