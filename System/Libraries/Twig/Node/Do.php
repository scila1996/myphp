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
 * Represents a do node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_Node_Do extends System_Libraries_Twig_Node
{

	public function __construct(System_Libraries_Twig_Node_Expression $expr, $lineno, $tag = null)
	{
		parent::__construct(array('expr' => $expr), array(), $lineno, $tag);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->addDebugInfo($this)
				->write('')
				->subcompile($this->getNode('expr'))
				->raw(";\n")
		;
	}

}
