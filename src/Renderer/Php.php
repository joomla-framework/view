<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Renderer;

use Joomla\Registry\Registry;
use Joomla\View\RendererInterface;

/**
 * Rendering class for rendering PHP based layouts
 *
 * @since  1.0
 */
class Php implements RendererInterface
{
	/**
	 * Global object.
	 *
	 * @var    Registry
	 * @since  1.0
	 */
	protected $globals;

	/**
	 * Template paths.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $templatePaths = array();

	/**
	 * Debug flag.
	 *
	 * @var    boolean
	 * @since  1.0
	 */
	protected $debug = false;

	/**
	 * Instantiate the renderer.
	 *
	 * @param   array  $config  The array of configuration parameters.
	 *
	 * @since   1.0
	 * @throws  \InvalidArgumentException
	 */
	public function __construct(array $config = array())
	{
		if (!isset($config['templates_base_dir']))
		{
			throw new \InvalidArgumentException('The "templates_base_dir" value must be set in the configuration array.');
		}

		$this->addPath($config['templates_base_dir']);

		$this->debug   = (isset($config['debug']) ? (bool) $config['debug'] : false);
		$this->globals = new Registry;
	}

	/**
	 * Get a global template var.
	 *
	 * @param   string  $key  The template var key.
	 *
	 * @return  mixed
	 *
	 * @since   1.0
	 */
	public function __get($key)
	{
		if ($this->globals->exists($key))
		{
			return $this->globals->get($key);
		}

		if ($this->debug)
		{
			trigger_error('No template var: ' . $key);
		}

		return '';
	}

	/**
	 * Render and return compiled HTML.
	 *
	 * @param   string  $template  The template file name
	 * @param   array   $data      The data to pass to the template
	 *
	 * @return  string  Compiled HTML
	 *
	 * @since   1.0
	 */
	public function render($template = '', array $data = array())
	{
		$defaultPath = $this->fetchLayoutPath('default');

		$templatePath = $this->fetchLayoutPath($template);

		ob_start();

		include $defaultPath;

		$bufferDefault = ob_get_clean();

		ob_start();

		include $templatePath;

		$bufferTemplate = ob_get_clean();

		$contents = $bufferDefault;

		$contents = str_replace('[[component]]', $bufferTemplate, $contents);

		return $contents;
	}

	/**
	 * Fetch a layout file.
	 *
	 * @param   string  $template  The layout file name
	 *
	 * @return  string  The valid file path
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	protected function fetchLayoutPath($template)
	{
		$fileName = $template . '.php';

		foreach ($this->templatePaths as $base)
		{
			$path = realpath($base . '/' . $fileName);

			if ($path)
			{
				return $path;
			}
		}

		$msg = '';

		$msg .= 'Template file not found: ' . $fileName;

		if ($this->debug)
		{
			$msg .= '<br />Registered paths:<br />' . implode('<br />', $this->templatePaths);
		}

		throw new \RuntimeException($msg);
	}

	/**
	 * Returns the name of the current rendering engine
	 *
	 * @return  string  Rendering engine name
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getEngine()
	{
		return 'php';
	}

	/**
	 * Set the template.
	 *
	 * @param   string  $name  The name of the template file.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   1.0
	 */
	public function setTemplate($name)
	{
		echo __METHOD__ . print_r($name, 1);

		// TODO: Implement setTemplate() method.
		return $this;
	}

	/**
	 * Set the data.
	 *
	 * @param   mixed  $key    The variable name or an array of variable names with values.
	 * @param   mixed  $value  The value.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   1.0
	 */
	public function set($key, $value)
	{
		$this->globals->set($key, $value);

		return $this;
	}

	/**
	 * Set the templates location paths.
	 *
	 * @param   string  $path  Templates location path.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   1.0
	 */
	public function addPath($path)
	{
		$this->templatePaths[] = $path;

		return $this;
	}


	/**
	 * Sets the paths where templates are stored.
	 *
	 * @param   string|array  $paths            A path or an array of paths where to look for templates.
	 * @param   bool          $overrideBaseDir  If true a path can be outside themes base directory.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   1.0
	 */
	public function setTemplatesPaths($paths, $overrideBaseDir = false)
	{
		$paths = is_array($paths) ? $paths : array($paths);

		foreach ($paths as $path)
		{
			if (false == in_array($path, $this->templatePaths))
			{
				$this->templatePaths[] = $path;
			}
		}

		return $this;
	}
}
