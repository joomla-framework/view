<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

use Joomla\Model\ModelInterface;

/**
 * Joomla Framework Abstract View Class
 *
 * @since  1.0
 */
abstract class AbstractView implements ViewInterface
{
	/**
	 * The data array to pass to the renderer
	 *
	 * @var    array
	 * @since  __DEPLOY_VERSION__
	 */
	private $data = array();

	/**
	 * The model object.
	 *
	 * @var    ModelInterface
	 * @since  1.0
	 */
	protected $model;

	/**
	 * Method to instantiate the view.
	 *
	 * @param   ModelInterface  $model  The model object.
	 *
	 * @since   1.0
	 */
	public function __construct(ModelInterface $model)
	{
		// Setup dependencies.
		$this->model = $model;
	}

	/**
	 * Adds an object to the data array
	 *
	 * @param   string  $key    The array key
	 * @param   mixed   $value  The data value to add
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function addData($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * Resets the internal data array
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function clearData()
	{
		$this->data = array();
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
		return $output;
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
	 * Removes an object to the data array
	 *
	 * @param   string  $key  The array key to remove
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function removeData($key)
	{
		if (isset($this->data[$key]))
		{
			unset($this->data[$key]);
		}
	}

	/**
	 * Sets the data array
	 *
	 * @param   array  $data  The data array.
	 *
	 * @return  AbstractView  Method allows chaining
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setData(array $data)
	{
		$this->data = $data;

		return $this;
	}
}
