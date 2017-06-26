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
 * System_Libraries_Twig_BaseNodeVisitor can be used to make node visitors compatible with Twig 1.x and 2.x.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class System_Libraries_Twig_BaseNodeVisitor implements System_Libraries_Twig_NodeVisitorInterface
{

	final public function enterNode(System_Libraries_Twig_NodeInterface $node, System_Libraries_Twig_Environment $env)
	{
		if (!$node instanceof System_Libraries_Twig_Node)
		{
			throw new LogicException('System_Libraries_Twig_BaseNodeVisitor only supports System_Libraries_Twig_Node instances.');
		}

		return $this->doEnterNode($node, $env);
	}

	final public function leaveNode(System_Libraries_Twig_NodeInterface $node, System_Libraries_Twig_Environment $env)
	{
		if (!$node instanceof System_Libraries_Twig_Node)
		{
			throw new LogicException('System_Libraries_Twig_BaseNodeVisitor only supports System_Libraries_Twig_Node instances.');
		}

		return $this->doLeaveNode($node, $env);
	}

	/**
	 * Called before child nodes are visited.
	 *
	 * @return System_Libraries_Twig_Node The modified node
	 */
	abstract protected function doEnterNode(System_Libraries_Twig_Node $node, System_Libraries_Twig_Environment $env);

	/**
	 * Called after child nodes are visited.
	 *
	 * @return System_Libraries_Twig_Node|false The modified node or false if the node must be removed
	 */
	abstract protected function doLeaveNode(System_Libraries_Twig_Node $node, System_Libraries_Twig_Environment $env);
}
