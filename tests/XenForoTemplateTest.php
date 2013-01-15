<?php

use Mockery as m;

use BigElephant\XfFiles\XenForo\Template;
use Illuminate\Filesystem\Filesystem;

class XenForoTemplateTest extends PHPUnit_Framework_TestCase {

	public function testDisplayPath()
	{
		$templateModel = new Template(new Filesystem);

		$path = $templateModel->displayPath('a/test/root/path/templates/master/addon/test.html');

		$this->assertEquals($path, '/templates/master/addon/test.html');
	}

	public function testGetStylePath()
	{
		$templateModel = new Template(new Filesystem);

		$this->assertEquals($templateModel->getStylePath(-1), 'a/test/root/path/templates/admin');
		$this->assertEquals($templateModel->getStylePath(0), 'a/test/root/path/templates/master');
		$this->assertEquals($templateModel->getStylePath(1), 'a/test/root/path/templates/style_1');
	}

	public function testGetTemplatePath()
	{
		$templateModel = new Template(new Filesystem);

		$template = array(
			'title' => 'admin_test',
			'style_id' => -1,
			'addon_id' => 'XenForo',
		);
		$this->assertEquals($templateModel->getTemplatePath($template), 'a/test/root/path/templates/admin/XenForo/admin_test.html');
		
		$template = array(
			'title' => 'master_test',
			'style_id' => 0,
			'addon_id' => 'Test',
		);
		$this->assertEquals($templateModel->getTemplatePath($template), 'a/test/root/path/templates/master/Test/master_test.html');

		$template = array(
			'title' => 'another.css',
			'style_id' => 5,
			'addon_id' => 'another_addon',
		);
		$this->assertEquals($templateModel->getTemplatePath($template), 'a/test/root/path/templates/style_5/another_addon/another.css');
	}

	public function testTemplateUpdated()
	{
		$templateModel = new Template($fileSystem = m::mock('Illuminate\Filesystem\Filesystem'));

		$fileSystem->shouldReceive('lastModified')->once()->andReturn(500);
		$this->assertTrue($templateModel->templateUpdated('', array('last_modified' => 400)));

		$fileSystem->shouldReceive('lastModified')->once()->andReturn(34756800);
		$this->assertFalse($templateModel->templateUpdated('', array('last_modified' => 34756801)));
	}

	public function testGetTemplateInfoFromFile()
	{
		$templateModel = new Template($fileSystem = m::mock('Illuminate\Filesystem\Filesystem'));

		$fileSystem->shouldReceive('get')->andReturn('test contents of template');

		$this->assertEquals($templateModel->getTemplateInfoFromFile('random/stuff/put/here/templates/admin/XenForo/test.html'), array(
			'title' => 'test',
			'addon_id' => 'XenForo',
			'style_id' => -1,
			'template' => 'test contents of template',
		));

		$this->assertEquals($templateModel->getTemplateInfoFromFile('random/stuff/put/here/templates/master/XenForo/another.css'), array(
			'title' => 'another.css',
			'addon_id' => 'XenForo',
			'style_id' => 0,
			'template' => 'test contents of template',
		));

		$this->assertEquals($templateModel->getTemplateInfoFromFile('random/stuff/put/here/templates/style_69/random_addon/test_stuff.html'), array(
			'title' => 'test_stuff',
			'addon_id' => 'random_addon',
			'style_id' => 69,
			'template' => 'test contents of template',
		));
	}
}

class XenForo_Application {

	public static function getInstance()
	{
		return new self;
	}

	public function getRootDir()
	{
		return 'a/test/root/path';
	}
}