<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\View\AbstractView;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\View\AbstractView
 */
class AbstractViewTest extends TestCase
{
    /**
     * Test object
     *
     * @var  TestView|AbstractView
     */
    private $instance;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new TestView();
    }

    public function testViewDataCanBeManaged()
    {
        $this->assertSame($this->instance, $this->instance->addData('test', 'value'), 'addData supports chaining');

        $this->assertSame(['test' => 'value'], $this->instance->getData());

        $this->assertSame($this->instance, $this->instance->clearData(), 'clearData supports chaining');

        $this->assertEmpty($this->instance->getData());

        $this->instance->addData('test', 'value');

        $this->assertSame($this->instance, $this->instance->removeData('test'), 'removeData supports chaining');

        $this->assertEmpty($this->instance->getData());

        $this->assertSame($this->instance, $this->instance->setData(['test' => 'value']), 'setData supports chaining');
        $this->assertSame(['test' => 'value'], $this->instance->getData());

        // Add some extra data
        $this->instance->setData(['joomla' => 'rocks']);

        $this->assertSame(
            [
                'test'   => 'value',
                'joomla' => 'rocks',
            ],
            $this->instance->getData(),
            'Data is merged when calling setData()'
        );
    }
}


/**
 * Class TestView
 *
 * To have an instance of the class to test
 *
 * @package  Joomla\View\Tests
 * @since    1.0
 */
class TestView extends AbstractView {
    public function render()
    {
        // TODO: Implement render() method.
    }
}
