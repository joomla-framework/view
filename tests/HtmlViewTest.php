<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View\Tests;

use Joomla\Renderer\RendererInterface;
use Joomla\View\HtmlView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\View\HtmlView
 */
class HtmlViewTest extends TestCase
{
    /**
     * Mock renderer
     *
     * @var  MockObject|RendererInterface
     */
    private $mockRenderer;

    /**
     * Test object
     *
     * @var  HtmlView
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRenderer = $this->createMock(RendererInterface::class);
        $this->object       = new HtmlView($this->mockRenderer);
    }

    public function testEnsureTheConstructorSetsTheValuesCorrectly()
    {
        $this->assertSame($this->mockRenderer, $this->object->getRenderer());
    }

    public function testEnsureMagicToStringMethodRendersTheView()
    {
        $this->mockRenderer->expects($this->any())
            ->method('render')
            ->willReturn('Rendered View');

        $this->assertSame('Rendered View', (string) $this->object);
    }

    public function testMagicToStringMethodDoesNotOutputTheExceptionMessageWhenRenderingFails()
    {
        $this->mockRenderer->expects($this->once())
            ->method('render')
            ->willThrowException(new \RuntimeException('Template <script>x</script> not found in /secret/path'));

        $errors = [];

        set_error_handler(
            static function (int $errno, string $errstr) use (&$errors): bool {
                $errors[] = [$errno, $errstr];

                return true;
            }
        );

        try {
            $rendered = (string) $this->object;
        } finally {
            restore_error_handler();
        }

        $this->assertSame('', $rendered, 'A failed render must not leak the exception message into the output');
        $this->assertCount(1, $errors, 'A failed render must be reported as a PHP warning');
        $this->assertSame(E_USER_WARNING, $errors[0][0]);
        $this->assertStringContainsString('not found in /secret/path', $errors[0][1]);
    }

    public function testEnsureRenderReturnsTheDataReceivedFromTheRenderer()
    {
        $this->assertEmpty($this->object->render());
    }

    public function testTheViewLayoutCanBeManaged()
    {
        $this->assertSame($this->object, $this->object->setLayout('layout'));
        $this->assertSame('layout', $this->object->getLayout());
    }

    public function testTheViewRendererCanBeManaged()
    {
        $renderer = $this->createMock(RendererInterface::class);

        $this->assertSame($this->object, $this->object->setRenderer($renderer));
        $this->assertSame($renderer, $this->object->getRenderer());
    }
}
