<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

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
	private $data = [];

	/**
	 * Adds an object to the data array
	 *
	 * @param   string  $key    The array key
	 * @param   mixed   $value  The data value to add
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function addData(string $key, $value)
	{
		$this->data[$key] = $value;

		return $this;
	}

	/**
	 * Resets the internal data array
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function clearData()
	{
		$this->data = array();

		return $this;
	}

	/**
	 * Retrieves the data array
	 *
	 * @return  array
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * Removes an object to the data array
	 *
	 * @param   string  $key  The array key to remove
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function removeData(string $key)
	{
		unset($this->data[$key]);

		return $this;
	}

	/**
	 * Sets additional data to the data array
	 *
	 * @param   array  $data  Data to merge into the existing data array
	 *
	 * @return  $this
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function setData(array $data)
	{
		$this->data = array_merge($this->data, $data);

		return $this;
	}
}
