<?php namespace BigElephant\XfFiles\Console;

use BigElephant\XfConsole\Command;

use Illuminate\Filesystem\Filesystem;
use BigElephant\XfFiles\XenForo\Template;

abstract class BaseCommand extends Command {

	protected $templateModel;

	protected $fileSystem;

	public function __construct(Template $template, Filesystem $fileSystem)
	{
		$this->templateModel = $template;

		$this->fileSystem = $fileSystem;

		parent::__construct();
	}
}