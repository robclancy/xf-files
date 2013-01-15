<?php namespace BigElephant\XfFiles;

use BigElephant\XfConsole\CommanderInterface;
use BigElephant\XfConsole\Application as ConsoleApp;

class FilesCommander implements CommanderInterface {

	public function build(ConsoleApp $consoleApp)
	{
		$commands = array('WriteFilesCommand', 'SyncCommand', 'SetupCommand');

		foreach ($commands AS $command)
		{
			$consoleApp->resolve('BigElephant\XfFiles\Console\\'.$command);
		}
	}
}