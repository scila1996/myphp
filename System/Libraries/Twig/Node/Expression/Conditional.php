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

class System_Libraries_Twig_Node_Expression_Conditional extends System_Libraries_Twig_Node_Expression
{

	public function __construct(System_Libraries_Twig_Node_Expression $expr1, System_Libraries_Twig_Node_Expression $expr2, System_Libraries_Twig_Node_Expression $expr3, $lineno)
	{
		parent::__construct(array('expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3), array(), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->raw('((')
				->subcompile($this->getNode('expr1'))
				->raw(') ? (')
				->subcompile($this->getNode('expr2'))
				->raw(') : (')
				->subcompile($this->getNode('expr3'))
				->raw('))')
		;
	}

}
