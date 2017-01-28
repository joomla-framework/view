<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

/**
 * Test class for \Joomla\View\AbstractView
 */
class AbstractViewTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test object
	 *
	 * @var  \Joomla\View\AbstractView
	 */
	private $instance;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->instance = $this->getMockForAbstractClass('\\Joomla\\View\\AbstractView');
	}

	/**
	 * @covers  Joomla\View\AbstractView::addData
	 */
	public function testEnsureAddDataCorrectlyAddsAValue()
	{
		$this->instance->addData('test', 'value');

		$this->assertAttributeSame(array('test' => 'value'), 'data', $this->instance);
	}

	/**
	 * @covers  Joomla\View\AbstractView::clearData
	 */
	public function testEnsureClearDataResetsTheDataArray()
	{
		$this->instance->clearData();

		$this->assertAttributeEmpty('data', $this->instance);
	}

	/**
	 * @covers  Joomla\View\AbstractView::getData
	 */
	public function testEnsureGetDataReturnsAnArray()
	{
		$this->assertSame(array(), $this->instance->getData());
	}

	/**
	 * @covers  Joomla\View\AbstractView::removeData
	 */
	public function testEnsureRemoveDataCorrectlyAddsAValue()
	{
		$this->instance->addData('test', 'value');
		$this->instance->removeData('test');

		$this->assertAttributeEmpty('data', $this->instance);
	}

	/**
	 * @covers  Joomla\View\AbstractView::setData
	 */
	public function testEnsureSetDataReturnsAnInstanceOfThisObject()
	{
		$this->assertSame($this->instance, $this->instance->setData(array()));
	}

	/**
	 * @covers  Joomla\View\AbstractView::setData
	 */
	public function testEnsureSetDataCorrectlyMergesDataArrays()
	{
		// Populate some base data
		$this->instance->setData(array('foo' => 'bar'));

		// Add some extra data
		$this->instance->setData(array('joomla' => 'rocks'));

		$this->assertAttributeSame(
			array(
				'foo' => 'bar',
				'joomla' => 'rocks'
			),
			'data',
			$this->instance
		);
	}
}
