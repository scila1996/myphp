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
 * Represents a sandbox node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_Node_Sandbox extends System_Libraries_Twig_Node
{

	public function __construct(System_Libraries_Twig_NodeInterface $body, $lineno, $tag = null)
	{
		parent::__construct(array('body' => $body), array(), $lineno, $tag);
	}

	public function compile(System_Libraries_Twig_Compiler $compiler)
	{
		$compiler
				->addDebugInfo($this)
				->write("\$sandbox = \$this->env->getExtension('System_Libraries_Twig_Extension_Sandbox');\n")
				->write("if (!\$alreadySandboxed = \$sandbox->isSandboxed()) {\n")
				->indent()
				->write("\$sandbox->enableSandbox();\n")
				->outdent()
				->write("}\n")
				->subcompile($this->getNode('body'))
				->write("if (!\$alreadySandboxed) {\n")
				->indent()
				->write("\$sandbox->disableSandbox();\n")
				->outdent()
				->write("}\n")
		;
	}

}
