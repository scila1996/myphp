<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class System_Libraries_Twig_Node_Expression_Test extends System_Libraries_Twig_Node_Expression_Call
{

	public function __construct(System_Libraries_Twig_NodeInterface $node, $name, System_Libraries_Twig_NodeInterface $arguments = null, $lineno)
	{
		$nodes = array('node' => $node);
		if (null !== $arguments)
		{
			$nodes['arguments'] = $arguments;
		}

		parent::__construct($nodes, array('name' => $name), $lineno);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$name = $this->getAttribute('name');
		$test = $compiler->getEnvironment()->getTest($name);

		$this->setAttribute('name', $name);
		$this->setAttribute('type', 'test');
		$this->setAttribute('thing', $test);
		if ($test instanceof System_Libraries_Twig_TestCallableInterface || $test instanceof System_Libraries_Twig_SimpleTest)
		{
			$this->setAttribute('callable', $test->getCallable());
		}
		if ($test instanceof System_Libraries_Twig_SimpleTest)
		{
			$this->setAttribute('is_variadic', $test->isVariadic());
		}

		$this->compileCallable($compiler);
	}

}
