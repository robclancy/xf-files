<?php namespace BigElephant\XfFiles\Console;

use BigElephant\XfConsole\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use BigElephant\XfFiles\XenForo\Template;

class WriteFilesCommand extends Command {

	protected $name = 'files:write';

	protected $description = 'Write Xenforo templates and phrases to the file system';

	protected $templateModel;

	public function fire()
	{
		$this->templateModel = new Template;

		$this->info('Writing admin templates...');

		$templates = $this->templateModel->getTemplates(-1);

		$progress = $this->getHelperSet()->get('progress');
		$progress->start($this->output, count($templates));
		$verbose = $this->output->getVerbosity();
		foreach ($templates AS $template)
		{
			if ($verbose > 1)
			{
				$this->output->write("  - Writing <info>$template[addon_id] $template[title]</info>...");
			}
			
			// write here
			usleep(30000);

			if ($verbose > 1)
			{
				$this->output->writeln(" done (<comment>full/long/path/name/here/$template[title].html</comment>)");
			}
			else
			{
				$progress->advance();
			}
		}

		$progress->finish();
	}
}