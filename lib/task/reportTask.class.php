<?php

class darwinReportTask extends sfBaseTask
{

  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', "backend"),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      ));
    $this->namespace        = 'darwin';
    $this->name             = 'report';
    $this->briefDescription = 'check report table to see if report as been asked, if so this task will get the file for the user';
    $this->detailedDescription = <<<EOF
Nothing
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // Initialize the connection to DB and get the environment (prod, dev,...) this task is runing on
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $conn = Doctrine_Manager::connection();

    // get the list of report to execute
    $reports = Doctrine::getTable('Reports')->getTaskReports();
    foreach ($reports as $report) {
      $content = file_get_contents($report->getUrlReport());
      $uri = '/report/'.sha1($report->getName().rand());
      file_put_contents(sfConfig::get('sf_upload_dir').$uri, $content);
      Doctrine::getTable('Reports')->updateUri($report->getId(),$uri);
    }
  }
}
