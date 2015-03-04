<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\View\BaseHtmlView;

/**
 * Test class for \Joomla\View\BaseHtmlView
 */
class BaseHtmlViewTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Mock ModelInterface
	 *
	 * @var  \Joomla\Model\AbstractModel
	 */
	private $mockModel;

	/**
	 * Mock RendererInterface
	 *
	 * @var  \BabDev\Renderer\AbstractRenderer
	 */
	private $mockRenderer;

	/**
	 * Test object
	 *
	 * @var  BaseHtmlView
	 */
	private $object;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->mockModel    = $this->getMockForAbstractClass('\\Joomla\\Model\\AbstractModel');
		$this->mockRenderer = $this->getMockForAbstractClass('\\BabDev\\Renderer\\AbstractRenderer');
		$this->object       = new BaseHtmlView($this->mockModel, $this->mockRenderer);
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::__construct
	 */
	public function testEnsureTheConstructorSetsTheValuesCorrectly()
	{
		$this->assertAttributeSame($this->mockRenderer, 'renderer', $this->object);
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::getLayout
	 */
	public function testEnsureGetLayoutReturnsTheCorrectLayout()
	{
		$this->assertSame('default', $this->object->getLayout());
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::getRenderer
	 */
	public function testEnsureGetRendererReturnsTheCorrectObject()
	{
		$this->assertSame($this->mockRenderer, $this->object->getRenderer());
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::render
	 */
	public function testEnsureRenderReturnsTheDataReceivedFromTheRenderer()
	{
		$this->assertNull($this->object->render());
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::setLayout
	 */
	public function testEnsureSetLayoutReturnsAnInstanceOfThisObject()
	{
		$this->assertSame($this->object, $this->object->setLayout('layout'));
	}

	/**
	 * @covers  Joomla\View\BaseHtmlView::setRenderer
	 */
	public function testEnsureSetRendererReturnsAnInstanceOfThisObject()
	{
		$this->assertSame($this->object, $this->object->setRenderer($this->mockRenderer));
	}
}
