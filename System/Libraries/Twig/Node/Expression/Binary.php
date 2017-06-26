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

abstract class System_Libraries_Twig_Node_Expression_Binary extends System_Libraries_Twig_Node_Expression
{

	public function __construct(System_Libraries_Twig_NodeInterface $left, System_Libraries_Twig_NodeInterface $right, $lineno)
	{
		parent::__construct(array('left' => $left, 'right' => $right), array(), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->raw('(')
				->subcompile($this->getNode('left'))
				->raw(' ')
		;
		$this->operator($compiler);
		$compiler
				->raw(' ')
				->subcompile($this->getNode('right'))
				->raw(')')
		;
	}

	abstract public function operator(System_Libraries_Twig_Compiler $compiler);
}
