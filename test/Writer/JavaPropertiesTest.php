<?php

/**
 * @see       https://github.com/laminas/laminas-config for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Config\Writer;

use Laminas\Config\Config;
use Laminas\Config\Reader\JavaProperties as JavaPropertiesReader;
use Laminas\Config\Writer\JavaProperties as JavaPropertiesWriter;

class JavaPropertiesTest extends AbstractWriterTestCase
{
    public function setUp()
    {
        $this->reader = new JavaPropertiesReader();
        $this->writer = new JavaPropertiesWriter();
    }

    public function testNoSection()
    {
        $config = new Config(['test' => 'foo', 'test2.test3' => 'bar']);

        $this->writer->toFile($this->getTestAssetFileName(), $config);

        $config = $this->reader->fromFile($this->getTestAssetFileName());

        $this->assertEquals('foo', $config['test']);
        $this->assertEquals('bar', $config['test2.test3']);
    }

    public function testWriteAndRead()
    {
        $this->markTestSkipped('JavaProperties writer cannot handle multi-dimensional configuration');
    }

    public function testWriteAndReadOriginalFile()
    {
        $config = $this->reader->fromFile(__DIR__ . '/_files/allsections.properties');

        $this->writer->toFile($this->getTestAssetFileName(), $config);

        $config = $this->reader->fromFile($this->getTestAssetFileName());

        $this->assertEquals('multi', $config['one.two.three']);
    }

    public function testWriteAndReadOriginalFileWithCustomDelimiter()
    {
        $config = $this->reader->fromFile(__DIR__ . '/_files/allsections.properties');

        $writer = new JavaPropertiesWriter('=');
        $writer->toFile($this->getTestAssetFileName(), $config);

        $reader = new JavaPropertiesReader('=');
        $config = $reader->fromFile($this->getTestAssetFileName());

        $this->assertEquals('multi', $config['one.two.three']);
    }
}
