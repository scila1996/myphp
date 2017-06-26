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
 * @internal
 */
class System_Libraries_Twig_Node_SetTemp extends System_Libraries_Twig_Node
{

	public function __construct($name, $lineno)
	{
		parent::__construct(array(), array('name' => $name), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$name = $this->getAttribute('name');
		$compiler
				->addDebugInfo($this)
				->write('if (isset($context[')
				->string($name)
				->raw('])) { $_')
				->raw($name)
				->raw('_ = $context[')
				->repr($name)
				->raw(']; } else { $_')
				->raw($name)
				->raw("_ = null; }\n")
		;
	}

}
