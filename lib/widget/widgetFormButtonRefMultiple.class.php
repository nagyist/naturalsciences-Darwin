<?php
/**
 * Created by PhpStorm.
 * User: Paul-André Duchesne
 * Date: 30/06/15
 * Time: 14:29
 */
/**
 * widgetFormButtonRefMultiple represents a button calling back a modal qtip
 * where it's possible to select multiple entries of a given catalogue passed as
 * a parameter
 *
 * @package    symfony
 * @subpackage widget
 * @author     Paul-André Duchesne <paul-andre.duchesne@naturalsciences.be>
 * @version    Git: $Id: widgetFormButtonRefMultiple.class.php 1 2015-06-30 14:29:00Z duchesne $
 */

class widgetFormButtonRefMultiple extends sfWidgetFormInputHidden
{

  public function ParentRender($name, $value = null, $attributes = array(), $errors = array()){
    return parent::render($name, $value, $attributes, $errors);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $class = array('class'=>'');
    if (isset($attributes['class']))
    {
      $class = array_merge($class, $attributes);
      $attributes['class'] .= ' hidden';
    }
    $class = ' '.$class['class'];
    $values = array_merge(array('text' => '', 'is_empty' => false), is_array($value) ? $value : array());
    $obj_name = $this->getName($value);

    if($this->getOption('default_name')) $obj_name = $this->getOption('default_name') ;

    $input = parent::render($name, $value, $attributes, $errors);

    if (strlen($this->getOption('button_class')) > 0)
    {
      $class .= ' '.$this->getOption('button_class');
    }

    if($this->getOption('button_is_hidden') && $value == 0)
    {
      $class .= ' hidden';
    }
    $input .= '<div title="'.$this->getOption('box_title').'" id="'.$this->generateId($name).'_button" class="ref_name' .$class. '">';
    $in_text = '<span class="on">'. __('Choose !').'</span>';

    $url_params = '';
    if(count($this->getOption('url_params')) != 0 ) {
      $url_params = '?';
      foreach($this->getOption('url_params') as $k=>$v){
        $url_params .= urlencode($k).'='.urlencode($v);
      }
    }

    $partial_url_params = '';
    if(count($this->getOption('partial_url_params')) != 0 ) {
      $partial_url_params = '?';
      foreach($this->getOption('partial_url_params') as $k=>$v){
        $partial_url_params .= urlencode($k).'='.urlencode($v);
      }
    }


    $input .= '<a href="'.url_for($this->getOption('link_url')).$url_params.'" class="but_text_multiple">'.$in_text.'</a>';

    $input .= '</div>';

    $input .= '<div id="'.$this->generateId($name).'_result_table" class="results_container but_ref_multiple hidden">
                 <table class="results">
                   <thead>
                     <tr>
                       <th>'.__('Name').'</th>
                       <th>'.__('Level').'</th>
                       <th></th>
                     </tr>
                   </thead>
                   <tbody>
                   </tbody>
                 </table>
               </div>
              ';

    $input .= '<script  type="text/javascript">
                 $(document).ready(function () {
                   $("#'.$this->generateId($name).'_button a.but_text_multiple").button_ref_multiple({
                     q_tip_text : "Choose a '.$this->getLabel().'",
                     update_row_fct: $.fn.button_ref_multiple.addEntry,
                     ids_list_target_input_id: "#'.$this->generateId($name).'",
                     names_list_target_table_id: "#'.$this->generateId($name).'_result_table",
                     partial_url:"'.url_for($this->getOption('partial_url')).$partial_url_params.'",
                     attached_field_id:"'.$this->generateId($name).'"
                   });
                   $("#'.$this->generateId($name).'_result_table").on(
                                                                      "click",
                                                                      "a.remove_catalogue_unit",
                                                                      $.fn.button_ref_multiple.removeEntry
                                                                    );
                 });
               </script>';

    return $input;
  }

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addRequiredOption('model');
    $this->addOption('method', '__toString');
    $this->addRequiredOption('link_url');
    $this->addOption('url_params', array());
    $this->addRequiredOption('partial_url');
    $this->addOption('partial_url_params', array());
    $this->addRequiredOption('box_title');
    $this->addOption('button_is_hidden', false);
    $this->addOption('button_class', 'button');
    $this->addOption('default_name', null);
    $this->addOption('on_change_attached_to', null);
    $this->addOption('on_change_url_for_widget_renew', null);
  }

  public function getJavaScripts()
  {
    return array('/js/button_ref_multiple.js');
  }

  public function getName($value, $default='')
  {
    if(is_numeric($value) && $value !=0)
      $object = Doctrine::getTable($this->getOption('model'))->find($value);
    else
      return $default;
    if(! $object)
      return $default;
    $method = $this->getOption('method');

    try {
      return  $object->$method();
    } catch (Exception $e) {
      throw $e;
    }
  }
}
