<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class System_Libraries_Twig_Node_Expression_TempName extends System_Libraries_Twig_Node_Expression
{

	public function __construct($name, $lineno)
	{
		parent::__construct(array(), array('name' => $name), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->raw('$_')
				->raw($this->getAttribute('name'))
				->raw('_')
		;
	}

}
