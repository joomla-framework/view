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
 * Rendering class for rendering Twig layouts
 *
 * @since  __DEPLOY_VERSION__
 */
class Twig extends \Twig_Environment implements RendererInterface
{
	/**
	 * The renderer default configuration parameters.
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $config = array(
		'templates_base_dir' => 'templates/',
		'template_file_ext'  => '.twig',
		'twig_cache_dir'     => 'cache/twig/',
		'delimiters'         => array(
			'tag_comment'    => array('{#', '#}'),
			'tag_block'      => array('{%', '%}'),
			'tag_variable'   => array('{{', '}}')
		),
		'environment'        => array()
	);

	/**
	 * The data for the renderer.
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $data = array();

	/**
	 * The templates location paths.
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $templatesPaths = array();

	/**
	 * Current template name.
	 *
	 * @var    string
	 * @since  __DEPLOY_VERSION__
	 */
	private $template;

	/**
	 * Loads template from the filesystem.
	 *
	 * @var    \Twig_Loader_Filesystem
	 * @since  __DEPLOY_VERSION__
	 */
	private $twigLoader;

	/**
	 * Instantiate the renderer.
	 *
	 * @param   array  $config  The array of configuration parameters.
	 *
	 * @since   __DEPLOY_VERSION__
	 * @throws  \RuntimeException
	 */
	public function __construct($config = array())
	{
		// Merge the config.
		$this->config = array_merge($this->config, $config);

		// Set the templates location path.
		$this->setTemplatesPaths($this->config['templates_base_dir'], true);

		if ($this->config['environment']['debug'])
		{
			$this->addExtension(new \Twig_Extension_Debug);
		}

		try
		{
			$this->twigLoader = new \Twig_Loader_Filesystem($this->templatesPaths);
		}
		catch (\Twig_Error_Loader $e)
		{
			throw new \RuntimeException($e->getRawMessage());
		}

		parent::__construct($this->twigLoader, $this->config['environment']);
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
		return 'twig';
	}

	/**
	 * Get the Lexer instance.
	 *
	 * @return  \Twig_LexerInterface  A Twig_LexerInterface instance.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getLexer()
	{
		if (null === $this->lexer)
		{
			$this->lexer = new \Twig_Lexer($this, $this->config['delimiters']);
		}

		return $this->lexer;
	}

	/**
	 * Set the data for the renderer.
	 *
	 * @param   mixed    $key     The variable name or an array of variable names with values.
	 * @param   mixed    $value   The value.
	 * @param   boolean  $global  Is this a global variable?
	 *
	 * @return  Twig  Method supports chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 * @throws  \InvalidArgumentException
	 */
	public function set($key, $value = null, $global = false)
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->set($k, $v, $global);
			}
		}
		else
		{
			if (!isset($value))
			{
				throw new \InvalidArgumentException('No value defined.');
			}

			if ($global)
			{
				$this->addGlobal($key, $value);
			}
			else
			{
				$this->data[$key] = $value;
			}
		}

		return $this;
	}

	/**
	 * Render and return compiled HTML.
	 *
	 * @param   string  $template  The template file name.
	 * @param   array   $data      An array of data to pass to the template.
	 *
	 * @return  string  Compiled HTML.
	 *
	 * @since   __DEPLOY_VERSION__
	 * @throws  \RuntimeException
	 */
	public function render($template = '', array $data = array())
	{
		if (!empty($template))
		{
			$this->setTemplate($template);
		}

		if (!empty($data))
		{
			$this->set($data);
		}

		try
		{
			return $this->load()->render($this->data);
		}
		catch (\Twig_Error_Loader $e)
		{
			throw new \RuntimeException($e->getRawMessage());
		}
	}

	/**
	 * Display the compiled HTML content.
	 *
	 * @param   string  $template  The template file name.
	 * @param   array   $data      An array of data to pass to the template.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function display($template = '', array $data = array())
	{
		if (!empty($template))
		{
			$this->setTemplate($template);
		}

		if (!empty($data))
		{
			$this->set($data);
		}

		try
		{
			$this->load()->display($this->data);
		}
		catch (\Twig_Error_Loader $e)
		{
			echo $e->getRawMessage();
		}
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
	 * Add a path to the templates location array.
	 *
	 * @param   string  $path  Templates location path.
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function addPath($path)
	{
		return $this->setTemplatesPaths($path, true);
	}

	/**
	 * Set the template.
	 *
	 * @param   string  $name  The name of the template file.
	 *
	 * @return  Twig  Method supports chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setTemplate($name)
	{
		$this->template = $name;

		return $this;
	}

	/**
	 * Sets the paths where templates are stored.
	 *
	 * @param   string|array  $paths            A path or an array of paths where to look for templates.
	 * @param   bool          $overrideBaseDir  If true a path can be outside themes base directory.
	 *
	 * @return  Twig
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setTemplatesPaths($paths, $overrideBaseDir = false)
	{
		if (!is_array($paths))
		{
			$paths = array($paths);
		}

		foreach ($paths as $path)
		{
			if ($overrideBaseDir)
			{
				$this->templatesPaths[] = $path;
			}
			else
			{
				$this->templatesPaths[] = $this->config['templates_base_dir'] . $path;
			}
		}

		// Reset the paths if needed.
		if (is_object($this->twigLoader))
		{
			try
			{
				$this->twigLoader->setPaths($this->templatesPaths);
			}
			catch (\Twig_Error_Loader $e)
			{
				echo $e->getRawMessage();
			}
		}

		return $this;
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
		return $this->loadTemplate($this->getTemplate() . $this->config['template_file_ext']);
	}
}
