<?php

/**
 * report actions.
 *
 * @package    darwin
 * @subpackage report
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends DarwinActions
{
  private $widgets;
  private $widgets_options;
  private $widgets_second_line_count = 0;
  public $i18n;
  public $info_message;

  /**
   * Sets the different variables in charge of storing the different dynamic
   * fields to be rendered on the report builder page
   * @param string $name the report name
   */
  private function setWidgetsOptions($name) {
    // Get the list of dynamicaly rendered fields depending the report targeted
    $this->widgets = Reports::getRequiredFieldForReport($name) ;
    // Get the list of options for these dynamicaly rendered fields
    $this->widgets_options = Reports::getRequiredFieldForReportOptions($name);
    // Count the ones that are dedicated to be set on a second line
    $this->widgets_second_line_count = 0;
    foreach(array_keys($this->widgets) as $widget_name){
      if(isset($this->widgets_options[$widget_name]) &&
         !empty($this->widgets_options[$widget_name]['second_line'])
         && $this->widgets_options[$widget_name]['second_line']) {
        $this->widgets_second_line_count += 1;
      }
    }
  }

  public function preExecute()
  {
    if(! $this->getUser()->isAtLeast(Users::MANAGER))
    {
      $this->forwardToSecureAction();
    }
  }

  /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->report_list = Reports::getGlobalReports() ;
  }

  public function executeGetAskedReport(sfWebRequest $request)
  {
    if($request->isXmlHttpRequest())
    {
      //  retrieve all reports already asked by this user
      $user_report = Doctrine::getTable('Reports')->getUserReport($this->getUser()->isAtLeast(Users::ADMIN)?'all':$this->getUser()->getId());
      return $this->renderPartial("user_report_list", array('reports' => $user_report)) ;      
    }
  }

  public function executeGetReport(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('name'));
    $name = $request->getParameter('name');
    $ids_list = array();
    foreach($request->getRequestParameters() as $rp_key=>$rp_value) {
      if (strpos($rp_key, 'ids_list[') !== false && strpos($rp_key, ']') !== false && (strpos($rp_key, ']')-strpos($rp_key, '[')>1)) {
        $ids_list[substr($rp_key, strpos($rp_key, '[')+1, strpos($rp_key, ']')-strpos($rp_key, '[')-1)] = $rp_value;
      }
    }
    if($request->isXmlHttpRequest() && $request->isMethod('post'))
    {
      $this->setWidgetsOptions($name);
      $this->form = new ReportsForm(null,array('fields'=>$this->widgets,
                                               'name' => $name,
                                               'model_name' => $request->getParameter('catalogue','taxonomy'),
                                               'with_js' => $request->getParameter('with_js',false),
                                               'ids_list' => $ids_list
                                              )
      ) ;
      if($request->getParameter('widgetButtonRefMultipleRefresh', '')=='1') {
        return $this->renderPartial("report_form_widget_button_ref_multiple_only",
                                    array('form' => $this->form,
                                          'fields'=> $this->widgets,
                                          'fields_options'=>$this->widgets_options,
                                          'fields_at_second_line'=>$this->widgets_second_line_count,
                                          'model_name'=> $request->getParameter('catalogue','taxonomy'),
                                          'fast' => Reports::getIsFast($name)
                                         )
        );
      }
      return $this->renderPartial("report_form",
                                  array('form' => $this->form,
                                        'fields'=> $this->widgets,
                                        'fields_options'=>$this->widgets_options,
                                        'fields_at_second_line'=>$this->widgets_second_line_count,
                                        'model_name'=> $request->getParameter('catalogue','taxonomy'),
                                        'fast' => Reports::getIsFast($name)
                                       )
      );
    }
    return false ;
  }

  public function executeAdd(sfWebRequest $request)
  {
    if($request->isMethod('post'))
    {
      $name = $request->getParameter('reports')['name'] ;
      if(!$name)  $this->forwardToSecureAction();
      $this->setWidgetsOptions($name);
      $this->form = new ReportsForm(null,array('fields'=>$this->widgets,
                                               'name' => $name,
                                               'model_name' => $request->getParameter('catalogue','taxonomy'),
                                               'with_js' => $request->getParameter('with_js',false)
                                        )
      );
      $this->form->bind($request->getParameter($this->form->getName()));
      if($this->form->isValid())
      {
        $this->i18n = $this->getContext()->getI18N();
        $this->info_message = $this->i18n->__("Your report has been saved. It will be availlable tomorrow");
        $report = new Reports() ;
        $report->fromArray(array(
          'name' => $name,
          'user_ref'=>$this->getUser()->getId(),
          'lang'=>$this->getUser()->getCulture(),
          'format'=>$request->getParameter('reports')['format'],
          'comment'=>$request->getParameter('reports')['comment'],
          ));
        $report->setParameters($request->getParameter('reports')) ;
        // Save the report whatever it's a fast or a non fast one
        $report->save() ;
        //if it's a fast report, it can be downloaded directly
        if(Reports::getIsFast($name)) {
          $response = $this->processDownload($report);
          if($response != 0) {
            $message = json_encode($this->getPartial("info_msg", array("info_message"=>$this->info_message)));
            return $this->renderText('{ "report_url" : "'.
                                     $this->generateUrl("default", array("module"=>"report", "action"=>"downloadFile", "id"=>$response), true).
                                     '", "message": '.$message.' }');
          }
        }
        return $this->renderPartial("info_msg", array("info_message"=>$this->info_message)) ;
      }
      $val = $this->renderPartial("report_form",
                                  array('form' => $this->form,
                                        'fields'=> $this->widgets,
                                        'fields_options'=>$this->widgets_options,
                                        'fields_at_second_line'=>$this->widgets_second_line_count,
                                        'model_name'=> $request->getParameter('catalogue','taxonomy'),
                                        'fast' => Reports::getIsFast($name)
                                  )
      );
      return $val;
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('id'));
    $this->report = Doctrine::getTable('Reports')->find($request->getParameter('id'));
    $uri = $this->report->getUri()?sfConfig::get('sf_upload_dir').$this->report->getUri():null ;
    $this->report->delete() ;
    @unlink($uri) ;
    if($request->isXmlHttpRequest())
    {
      return $this->renderText('ok');
    }
    return $this->redirect('report/index');
  }

  public function executeDownloadFile(sfWebRequest $request)
  {
    $this->setLayout(false);
    $report = Doctrine::getTable('Reports')->find($request->getParameter('id'));  
    $this->forward404Unless(file_exists($uri = sfConfig::get('sf_upload_dir').$report->getUri()),sprintf('This file does not exist') );

    $response = $this->getResponse();
    // First clear HTTP headers
    $response->clearHttpHeaders();
    // Then define the necessary headers
    $response->setContentType(Multimedia::getMimeTypeFor($report->getFormat()));
    $response->setHttpHeader(
      'Content-Disposition',
      'attachment; filename="' .
      $report->getName() . "." . $report->getFormat() . '"'
    );
    $response->setHttpHeader('Content-Description', 'File Transfer');
    $response->setHttpHeader('Content-Transfer-Encoding', 'binary');
    $response->setHttpHeader('Content-Length', filesize($uri));
    $response->setHttpHeader('Cache-Control', 'public, must-revalidate');
    // if https then always give a Pragma header like this  to overwrite the "pragma: no-cache" header which
    // will hint IE8 from caching the file during download and leads to a download error!!!
    $response->setHttpHeader('Pragma', 'public');
    $response->sendHttpHeaders();
    ob_end_flush();
    return $this->renderText(readfile($uri));
  }

  public function processDownload( &$report ) {
    $return_val = 0;
    try {
      // Define Context params
      $ctx = stream_context_create(array('http'=>
                                           array(
                                             'timeout' => 30, // 1 200 Seconds = 20 Minutes
                                           )
                                   ));
      set_time_limit(0) ;
      ignore_user_abort(1);
      // First write in a file, on the uri specified, the stream coming from report asked
      $file_name = sha1($report->getName() . rand());
      $uri = sfConfig::get('sf_upload_dir') . '/report/' . $file_name;
      // Try to write the file
      if(file_put_contents($uri, file_get_contents($report->getUrlReport(), FALSE, $ctx),null,$ctx)) {
        // Write the reference of that file into db for concerned report
        $report->setUri('/report/'.$file_name);
        $report->save();
        $this->info_message = $this->i18n->__("Your report has been saved and is available right above");
        $return_val = $report->getId();
      }
      else {
        $this->info_message = $this->i18n->__("File has not been well written. Please contact your application administrator");
      }
    }
    catch (Exception $e) {
      $this->info_message = $this->i18n->__("An error occured while trying to retrieve the file.\nError message: %1%",array('%1%'=>$e->getMessage()));
    }
    return $return_val;
  }
}
