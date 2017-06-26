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

class System_Libraries_Twig_Node_Expression_Unary_Neg extends System_Libraries_Twig_Node_Expression_Unary
{

	public function operator(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler->raw('-');
	}

}
