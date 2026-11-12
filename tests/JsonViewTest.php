<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\View\JsonView;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\View\JsonView
 */
class JsonViewTest extends TestCase
{
    /**
     * Test object
     *
     * @var  JsonView
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new JsonView();
    }

    public function testEnsureRenderReturnsTheDataInJsonFormat()
    {
        $this->object->setData(['test' => 'value']);

        $this->assertSame(json_encode($this->object->getData()), $this->object->render());
    }

    public function testRenderThrowsAnExceptionWhenTheDataCannotBeEncoded()
    {
        $this->object->setData(['test' => "\xB1\x31"]);

        $this->expectException(\RuntimeException::class);

        $this->object->render();
    }

    public function testTheEncodingFlagsDefaultToNone()
    {
        $this->assertSame(0, $this->object->getFlags());

        $this->object->setData(['test' => '<a href="x">x</a>']);

        $this->assertSame('{"test":"<a href=\"x\">x<\/a>"}', $this->object->render());
    }

    public function testTheEncodingFlagsCanBeSetInTheConstructor()
    {
        $view = new JsonView(JSON_HEX_TAG | JSON_UNESCAPED_SLASHES);
        $view->setData(['test' => '</script>']);

        $this->assertSame(JSON_HEX_TAG | JSON_UNESCAPED_SLASHES, $view->getFlags());
        $this->assertSame('{"test":"\u003C/script\u003E"}', $view->render());
    }

    public function testTheEncodingFlagsCanBeManaged()
    {
        $this->assertSame($this->object, $this->object->setFlags(JSON_PRETTY_PRINT), 'setFlags supports chaining');
        $this->assertSame(JSON_PRETTY_PRINT, $this->object->getFlags());

        $this->object->setData(['test' => 'value']);

        $this->assertSame("{\n    \"test\": \"value\"\n}", $this->object->render());
    }
}
