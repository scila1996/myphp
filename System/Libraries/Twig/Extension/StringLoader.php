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
 * @final
 */
class System_Libraries_Twig_Extension_StringLoader extends System_Libraries_Twig_Extension
{

	public function getFunctions()
	{
		return array(
			new System_Libraries_Twig_SimpleFunction('template_from_string', 'twig_template_from_string', array('needs_environment' => true)),
		);
	}

	public function getName()
	{
		return 'string_loader';
	}

}

/**
 * Loads a template from a string.
 *
 * <pre>
 * {{ include(template_from_string("Hello {{ name }}")) }}
 * </pre>
 *
 * @param System_Libraries_Twig_Environment $env      A System_Libraries_Twig_Environment instance
 * @param string           $template A template as a string or object implementing __toString()
 *
 * @return System_Libraries_Twig_Template
 */
function twig_template_from_string(System_Libraries_Twig_Environment $env, $template)
{
	return $env->createTemplate((string) $template);
}
