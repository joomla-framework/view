<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

use Joomla\Filesystem\Path;
use Joomla\Model\ModelInterface;
use BabDev\Renderer\RendererInterface;

/**
 * Joomla Framework HTML View Class
 *
 * @since  1.0
 */
abstract class AbstractHtmlView extends AbstractView
{
	/**
	 * The data array to pass to the renderer engine
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	protected $data = array();

	/**
	 * The view layout.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $layout = 'default';

	/**
	 * The paths queue.
	 *
	 * @var    \SplPriorityQueue
	 * @since  1.0
	 * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
	 */
	protected $paths;

	/**
	 * The renderer object
	 *
	 * @var    RendererInterface
	 * @since  __DEPLOY_VERSION__
	 */
	protected $renderer;

	/**
	 * Method to instantiate the view.
	 *
	 * @param   ModelInterface     $model     The model object.
	 * @param   RendererInterface  $renderer  The renderer object. [@note Will be typehinted and required at 3.0]
	 * @param   \SplPriorityQueue  $paths     The paths queue. [@deprecated In 2.0, a RendererInterface object will be required which will manage paths.]
	 *
	 * @since   1.0
	 */
	public function __construct(ModelInterface $model, $renderer = null, \SplPriorityQueue $paths = null)
	{
		parent::__construct($model);

		// Setup dependencies - B/C handling, check if $renderer is an instance of \SplPriorityQueue, remove at 3.0
		if ($renderer instanceof \SplPriorityQueue)
		{
			$paths = $renderer;
		}

		$this->paths = isset($paths) ? $paths : $this->loadPaths();

		// Set the renderer if we have it
		if ($renderer instanceof RendererInterface)
		{
			$this->setRenderer($renderer);
		}
	}

	/**
	 * Magic toString method that is a proxy for the render method.
	 *
	 * @return  string
	 *
	 * @since   1.0
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
		}
	}

	/**
	 * Method to escape output.
	 *
	 * @param   string  $output  The output to escape.
	 *
	 * @return  string  The escaped output.
	 *
	 * @see     ViewInterface::escape()
	 * @since   1.0
	 */
	public function escape($output)
	{
		// Escape the output.
		return htmlspecialchars($output, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Retrieves the data array
	 *
	 * @return  array
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Method to get the view layout.
	 *
	 * @return  string  The layout name.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function getLayout()
	{
		if (is_null($this->layout))
		{
			throw new \RuntimeException('The layout name is not set.');
		}

		return $this->layout;
	}

	/**
	 * Method to get the layout path.
	 *
	 * @param   string  $layout  The base name of the layout file (excluding extension).
	 * @param   string  $ext     The extension of the layout file (default: "php").
	 *
	 * @return  mixed  The layout file name if found, false otherwise.
	 *
	 * @since   1.0
	 * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
	 */
	public function getPath($layout, $ext = 'php')
	{
		// Get the layout file name.
		$file = Path::clean($layout . '.' . $ext);

		// Find the layout file path.
		$path = Path::find(clone($this->paths), $file);

		return $path;
	}

	/**
	 * Method to get the view paths.
	 *
	 * @return  \SplPriorityQueue  The paths queue.
	 *
	 * @since   1.0
	 * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
	 */
	public function getPaths()
	{
		return $this->paths;
	}

	/**
	 * Method to get the renderer object.
	 *
	 * @return  RendererInterface  The renderer object.
	 *
	 * @since   __DEPLOY_VERSION__
	 * @throws  \RuntimeException
	 */
	public function getRenderer()
	{
		if (is_null($this->renderer))
		{
			throw new \RuntimeException('The renderer object is not set.');
		}

		return $this->renderer;
	}

	/**
	 * Method to render the view.
	 *
	 * @return  string  The rendered view.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function render()
	{
		return $this->getRenderer()->render($this->getLayout(), $this->getData());
	}

	/**
	 * Sets the data array
	 *
	 * @param   array  $data  The data array.
	 *
	 * @return  AbstractHtmlView  Method supports chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setData(array $data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Method to set the view layout.
	 *
	 * @param   string  $layout  The layout name.
	 *
	 * @return  AbstractHtmlView  Method supports chaining.
	 *
	 * @since   1.0
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * Method to set the view paths.
	 *
	 * @param   \SplPriorityQueue  $paths  The paths queue.
	 *
	 * @return  AbstractHtmlView  Method supports chaining.
	 *
	 * @since   1.0
	 * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
	 */
	public function setPaths(\SplPriorityQueue $paths)
	{
		$this->paths = $paths;

		return $this;
	}

	/**
	 * Sets the renderer object
	 *
	 * @param   RendererInterface  $renderer  The renderer object.
	 *
	 * @return  AbstractHtmlView  Method supports chaining.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setRenderer(RendererInterface $renderer)
	{
		$this->renderer = $renderer;

		return $this;
	}

	/**
	 * Method to load the paths queue.
	 *
	 * @return  \SplPriorityQueue  The paths queue.
	 *
	 * @since   1.0
	 * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
	 */
	protected function loadPaths()
	{
		return new \SplPriorityQueue;
	}
}
