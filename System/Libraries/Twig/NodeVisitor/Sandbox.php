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
 * System_Libraries_Twig_NodeVisitor_Sandbox implements sandboxing.
 *
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class System_Libraries_Twig_NodeVisitor_Sandbox extends System_Libraries_Twig_BaseNodeVisitor
{

	protected $inAModule = false;
	protected $tags;
	protected $filters;
	protected $functions;

	protected function doEnterNode(System_Libraries_Twig_Node $node, System_Libraries_Twig_Environment $env)
	{
		if ($node instanceof System_Libraries_Twig_Node_Module)
		{
			$this->inAModule = true;
			$this->tags = array();
			$this->filters = array();
			$this->functions = array();

			return $node;
		}
		elseif ($this->inAModule)
		{
			// look for tags
			if ($node->getNodeTag() && !isset($this->tags[$node->getNodeTag()]))
			{
				$this->tags[$node->getNodeTag()] = $node;
			}

			// look for filters
			if ($node instanceof System_Libraries_Twig_Node_Expression_Filter && !isset($this->filters[$node->getNode('filter')->getAttribute('value')]))
			{
				$this->filters[$node->getNode('filter')->getAttribute('value')] = $node;
			}

			// look for functions
			if ($node instanceof System_Libraries_Twig_Node_Expression_Function && !isset($this->functions[$node->getAttribute('name')]))
			{
				$this->functions[$node->getAttribute('name')] = $node;
			}

			// wrap print to check __toString() calls
			if ($node instanceof System_Libraries_Twig_Node_Print)
			{
				return new System_Libraries_Twig_Node_SandboxedPrint($node->getNode('expr'), $node->getTemplateLine(), $node->getNodeTag());
			}
		}

		return $node;
	}

	protected function doLeaveNode(System_Libraries_Twig_Node $node, System_Libraries_Twig_Environment $env)
	{
		if ($node instanceof System_Libraries_Twig_Node_Module)
		{
			$this->inAModule = false;

			$node->setNode('display_start', new System_Libraries_Twig_Node(array(new System_Libraries_Twig_Node_CheckSecurity($this->filters, $this->tags, $this->functions), $node->getNode('display_start'))));
		}

		return $node;
	}

	public function getPriority()
	{
		return 0;
	}

}
