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

class System_Libraries_Twig_Node_Expression_AssignName extends System_Libraries_Twig_Node_Expression_Name
{

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->raw('$context[')
				->string($this->getAttribute('name'))
				->raw(']')
		;
	}

}
