<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

abstract class System_Libraries_Twig_Test_NodeTestCase extends TestCase
{

	abstract public function getTests();

	/**
	 * @dataProvider getTests
	 */
	public function testCompile($node, $source, $environment = null, $isPattern = false)
	{
		$this->assertNodeCompilation($source, $node, $environment, $isPattern);
	}

	public function assertNodeCompilation($source, System_Libraries_Twig_Node $node, System_Libraries_Twig_Environment $environment = null, $isPattern = false)
	{
		$compiler = $this->getCompiler($environment);
		$compiler->compile($node);

		if ($isPattern)
		{
			$this->assertStringMatchesFormat($source, trim($compiler->getSource()));
		}
		else
		{
			$this->assertEquals($source, trim($compiler->getSource()));
		}
	}

	protected function getCompiler(System_Libraries_Twig_Environment $environment = null)
	{
		return new System_Libraries_Twig_Compiler(null === $environment ? $this->getEnvironment() : $environment);
	}

	protected function getEnvironment()
	{
		return new System_Libraries_Twig_Environment(new System_Libraries_Twig_Loader_Array(array()));
	}

	protected function getVariableGetter($name, $line = false)
	{
		$line = $line > 0 ? "// line {$line}\n" : '';

		if (PHP_VERSION_ID >= 70000)
		{
			return sprintf('%s($context["%s"] ?? null)', $line, $name, $name);
		}

		if (PHP_VERSION_ID >= 50400)
		{
			return sprintf('%s(isset($context["%s"]) ? $context["%s"] : null)', $line, $name, $name);
		}

		return sprintf('%s$this->getContext($context, "%s")', $line, $name);
	}

	protected function getAttributeGetter()
	{
		if (function_exists('twig_template_get_attributes'))
		{
			return 'twig_template_get_attributes($this, ';
		}

		return '$this->getAttribute(';
	}

}
