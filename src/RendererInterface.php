<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

/**
 * Joomla Framework View Rendering Interface
 *
 * @since  __DEPLOY_VERSION__
 */
interface RendererInterface
{
	/**
	 * Render and return compiled HTML.
	 *
	 * @param   string  $template  The template file name
	 * @param   array   $data      The data to pass to the template
	 *
	 * @return  string  compiled HTML
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function render($template = '', array $data = array());

	/**
	 * Set the template.
	 *
	 * @param   string  $name  The name of the template file.
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setTemplate($name);

	/**
	 * Sets the paths where templates are stored.
	 *
	 * @param   string|array  $paths            A path or an array of paths where to look for templates.
	 * @param   bool          $overrideBaseDir  If true a path can be outside themes base directory.
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setTemplatesPaths($paths, $overrideBaseDir = false);

	/**
	 * Set the templates location paths.
	 *
	 * @param   string  $path  Templates location path.
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function addPath($path);

	/**
	 * Set the data.
	 *
	 * @param   mixed  $key    The variable name or an array of variable names with values.
	 * @param   mixed  $value  The value.
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function set($key, $value);

	/**
	 * Unset a particular variable.
	 *
	 * @param   mixed  $key  The variable name
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function unsetData($key);
}
