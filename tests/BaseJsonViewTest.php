<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\View\BaseJsonView;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\View\BaseJsonView
 */
class BaseJsonViewTest extends TestCase
{
	/**
	 * Test object
	 *
	 * @var  BaseJsonView
	 */
	private $object;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new BaseJsonView;
	}

	/**
	 * @covers  Joomla\View\BaseJsonView::render
	 */
	public function testEnsureRenderReturnsTheDataInJsonFormat()
	{
		$this->object->setData(array('test' => 'value'));

		$this->assertSame(json_encode($this->object->getData()), $this->object->render());
	}
}
