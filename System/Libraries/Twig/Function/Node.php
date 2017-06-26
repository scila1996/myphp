<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

@trigger_error('The System_Libraries_Twig_Function_Node class is deprecated since version 1.12 and will be removed in 2.0. Use System_Libraries_Twig_SimpleFunction instead.', E_USER_DEPRECATED);

/**
 * Represents a template function as a node.
 *
 * Use System_Libraries_Twig_SimpleFunction instead.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.12 (to be removed in 2.0)
 */
class System_Libraries_Twig_Function_Node extends System_Libraries_Twig_Function
{

	protected $class;

	public function __construct($class, array $options = array())
	{
		parent::__construct($options);

		$this->class = $class;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function compile()
	{
		
	}

}
