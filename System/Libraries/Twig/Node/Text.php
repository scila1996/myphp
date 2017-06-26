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

/**
 * Represents a text node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_Node_Text extends System_Libraries_Twig_Node implements System_Libraries_Twig_NodeOutputInterface
{

	public function __construct($data, $lineno)
	{
		parent::__construct(array(), array('data' => $data), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->addDebugInfo($this)
				->write('echo ')
				->string($this->getAttribute('data'))
				->raw(";\n")
		;
	}

}
