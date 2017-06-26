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
 * Represents a spaceless node.
 *
 * It removes spaces between HTML tags.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_Node_Spaceless extends System_Libraries_Twig_Node
{

	public function __construct(System_Libraries_Twig_NodeInterface $body, $lineno, $tag = 'spaceless')
	{
		parent::__construct(array('body' => $body), array(), $lineno, $tag);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->addDebugInfo($this)
				->write("ob_start();\n")
				->subcompile($this->getNode('body'))
				->write("echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));\n")
		;
	}

}
