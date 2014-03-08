<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Renderer;

use Joomla\View\RendererInterface;

/**
 * Rendering class for rendering Mustache layouts
 *
 * @since  __DEPLOY_VERSION__
 */
class Mustache extends \Mustache_Engine implements RendererInterface
{
	/**
	 * The renderer default configuration parameters.
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $config = array(
		'templates_base_dir' => '/templates',
		'partials_base_dir'  => '/partials'
	);

	/**
	 * The data for the renderer.
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $data;

	/**
	 * Current template name.
	 *
	 * @var    string
	 * @since  __DEPLOY_VERSION__
	 */
	private $template;

	/**
	 * Instantiate the renderer.
	 *
	 * @param   array  $config  The array of configuration parameters.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function __construct($config = array())
	{
		// Merge the config.
		$this->config = array_merge($this->config, $config);

		parent::__construct(
			array(
				'loader'          => new \Mustache_Loader_FilesystemLoader($this->config['templates_base_dir']),
				'partials_loader' => new \Mustache_Loader_FilesystemLoader($this->config['partials_base_dir'])
			)
		);
	}

	/**
	 * Set the data for the renderer.
	 *
	 * @param   mixed  $key    The variable name or an array of variable names with values.
	 * @param   mixed  $value  The value.
	 *
	 * @return  $this  Method supports chaining
	 *
	 * @since   __DEPLOY_VERSION__
	 * @throws  \InvalidArgumentException
	 */
	public function set($key, $value = null)
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->set($k, $v);
			}
		}
		else
		{
			if (!isset($value))
			{
				throw new \InvalidArgumentException('No value defined.');
			}

			$this->data[$key] = $value;
		}

		return $this;
	}

	/**
	 * Set the template.
	 *
	 * @param   string  $name  The name of the template file.
	 *
	 * @return  $this  Method supports chaining
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setTemplate($name)
	{
		$this->template = $name;

		return $this;
	}

	/**
	 * Render and return compiled HTML.
	 *
	 * @param   string  $template  The template file name.
	 * @param   array   $data      The data to pass to the template.
	 *
	 * @return  string  Compiled HTML
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function render($template = '', array $data = '')
	{
		if (!empty($template))
		{
			$this->template = $template;
		}

		if (!empty($data))
		{
			$this->data = $data;
		}

		return $this->load()->render($this->data);
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
		return 'mustache';
	}

	/**
	 * Get the current template name.
	 *
	 * @return  string  The name of the currently loaded template file (without the extension).
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * Load the template and return an output object.
	 *
	 * @return  object  Output object.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	private function load()
	{
		return $this->loadTemplate($this->template);
	}

	/**
	 * Set the templates location paths.
	 *
	 * @param   string  $path  Templates location path.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   __DEPLOY_VERSION__
	 * @todo    Implement addPath() method.
	 */
	public function addPath($path)
	{
	}

	/**
	 * Sets the paths where templates are stored.
	 *
	 * @param   string|array  $paths            A path or an array of paths where to look for templates.
	 * @param   bool          $overrideBaseDir  If true a path can be outside themes base directory.
	 *
	 * @return  $this  Method allows chaining
	 *
	 * @since   __DEPLOY_VERSION__
	 * @todo    Implement setTemplatesPaths() method.
	 */
	public function setTemplatesPaths($paths, $overrideBaseDir = false)
	{
	}
}
