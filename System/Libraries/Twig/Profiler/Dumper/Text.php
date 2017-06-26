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
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class System_Libraries_Twig_Profiler_Dumper_Text extends System_Libraries_Twig_Profiler_Dumper_Base
{

	protected function formatTemplate(System_Libraries_Twig_Profiler_Profile $profile, $prefix)
	{
		return sprintf('%s└ %s', $prefix, $profile->getTemplate());
	}

	protected function formatNonTemplate(System_Libraries_Twig_Profiler_Profile $profile, $prefix)
	{
		return sprintf('%s└ %s::%s(%s)', $prefix, $profile->getTemplate(), $profile->getType(), $profile->getName());
	}

	protected function formatTime(System_Libraries_Twig_Profiler_Profile $profile, $percent)
	{
		return sprintf('%.2fms/%.0f%%', $profile->getDuration() * 1000, $percent);
	}

}
