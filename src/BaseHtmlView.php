<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

use Joomla\Renderer\RendererInterface;

/**
 * Joomla Framework HTML View Class
 *
 * @since  __DEPLOY_VERSION__
 */
class BaseHtmlView extends AbstractView
{
	/**
	 * The view layout.
	 *
	 * @var    string
	 * @since  __DEPLOY_VERSION__
	 */
	protected $layout = 'default';

	/**
	 * The renderer object
	 *
	 * @var    RendererInterface
	 * @since  __DEPLOY_VERSION__
	 */
	private $renderer;

	/**
	 * Method to instantiate the view.
	 *
	 * @param   RendererInterface  $renderer  The renderer object.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function __construct(RendererInterface $renderer)
	{
		$this->setRenderer($renderer);
	}

	/**
	 * Magic toString method that is a proxy for the render method.
	 *
	 * @return  string
	 *
	 * @since   __DEPLOY_VERSION__
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
	 * Method to get the view layout.
	 *
	 * @return  string  The layout name.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getLayout(): string
	{
		return $this->layout;
	}

	/**
	 * Retrieves the renderer object
	 *
	 * @return  RendererInterface
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getRenderer(): RendererInterface
	{
		return $this->renderer;
	}

	/**
	 * Method to render the view.
	 *
	 * @return  string  The rendered view.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function render()
	{
		return $this->getRenderer()->render($this->getLayout(), $this->getData());
	}

	/**
	 * Method to set the view layout.
	 *
	 * @param   string  $layout  The layout name.
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setLayout(string $layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * Sets the renderer object
	 *
	 * @param   RendererInterface  $renderer  The renderer object.
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setRenderer(RendererInterface $renderer)
	{
		$this->renderer = $renderer;

		return $this;
	}
}
