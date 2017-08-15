<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\Renderer\RendererInterface;
use Joomla\View\BaseHtmlView;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\View\BaseHtmlView
 */
class BaseHtmlViewTest extends TestCase
{
	/**
	 * Mock renderer
	 *
	 * @var  RendererInterface
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

		$this->mockRenderer = $this->getMockBuilder(RendererInterface::class)->getMock();
		$this->object       = new BaseHtmlView($this->mockRenderer);
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
	 * @covers  Joomla\View\BaseHtmlView::__toString
	 */
	public function testEnsureMagicToStringMethodRendersTheView()
	{
		$this->mockRenderer->expects($this->any())
			->method('render')
			->willReturn('Rendered View');

		$this->assertSame('Rendered View', (string) $this->object);
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