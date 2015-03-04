<?php
/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

/**
 * Joomla Framework JSON View Class
 *
 * @since  __DEPLOY_VERSION__
 */
class BaseJsonView extends AbstractView
{
	/**
	 * Method to render the view.
	 *
	 * @return  string  The rendered view.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function render()
	{
		return json_encode($this->getData());
	}
}
