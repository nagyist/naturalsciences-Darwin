<?php

/**
 * Insurances
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Insurances extends BaseInsurances
{
  /**
  * Get the formated Insurance value
  * @return string the value formated with currency
  */
  public function getFormatedInsuranceValue()
  {
    $insuranceValue = $this->_get('insurance_value').' '.$this->_get('insurance_currency');
    return $insuranceValue;
  }

  /**
  * Set DateFrom field and mask if a fuzzyDateTime is passed
  * @param string|fuzzyDateTime $fd a fuzzyDateTime object or a string to pass to postgres
  * @return $this
  */
  public function setDateFrom($fd)
  {
     if(is_string($fd))
     {
        $this->_set('date_from',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
       $this->_set('date_from', $fd->format('Y/m/d') );
       $this->_set('date_from_mask', $fd->getMask() );    
     }     
     else
     {
       if(empty($fd['day']) && empty($fd['month']) && empty($fd['year'])) return ;
       $dateTime = new FuzzyDateTime($fd, 56, false); 
       $this->_set('date_from', $dateTime->format('Y/m/d'));
       $this->_set('date_from_mask', $dateTime->getMask());
     }
     return $this;
  }

  /**
  * Set DateTo field and mask if a fuzzyDateTime is passed
  * @param string|fuzzyDateTime $fd a fuzzyDateTime object or a string to pass to postgres
  * @return $this
  */
  public function setDateTo($fd)
  {
     if(is_string($fd))
     {
        $this->_set('date_to',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
      $this->_set('date_to', $fd->format('Y/m/d') );
      $this->_set('date_to_mask', $fd->getMask() );
     }
     else
     {
       if(empty($fd['day']) && empty($fd['month']) && empty($fd['year'])) return ;
       $dateTime = new FuzzyDateTime($fd, 56, false); 
       $this->_set('date_to', $dateTime->format('Y/m/d'));
       $this->_set('date_to_mask', $dateTime->getMask());
     }     
     return $this;
  }
  
  /**
  * Get the From date masked with tag $tag depending on the mask value
  * @param string $tag Tag wich will be arround fuzzy values (default < em >)
  * @return string the Date masked
  */
  public function getDateFromMasked($tag='em')
  {
    $dateTime = new FuzzyDateTime($this->_get('date_from'), $this->_get('date_from_mask'),true,true);
    return $dateTime->getDateMasked($tag);
  }
 
  /**
  * Get the From date masked with tag $tag depending on the mask value
  * @param string $tag Tag wich will be arround fuzzy values (default < em >)
  * @return string the Date masked
  */
  public function getDateToMasked($tag='em')
  {
    $dateTime = new FuzzyDateTime($this->_get('date_to'), $this->_get('date_to_mask'),false,true);
    return $dateTime->getDateMasked($tag);
  }

  /** 
  * Get date To as array with masked values
  * @return array an array of masked elements with key year,month,day,hour,minute,second
  * @see FuzzyDateTime::getDateTimeMaskedAsArray
  */
  public function getDateTo()
  {
    $date = new FuzzyDateTime($this->_get('date_to'),$this->_get('date_to_mask'),true, true);
    return $date->getDateTimeMaskedAsArray();
  }

  /** 
  * Get date From as array with masked values
  * @return array an array of masked elements with key year,month,day,hour,minute,second
  * @see FuzzyDateTime::getDateTimeMaskedAsArray
  */
  public function getDateFrom()
  {
    $date = new FuzzyDateTime($this->_get('date_from'),$this->_get('date_from_mask'),false, true);
    return $date->getDateTimeMaskedAsArray();
  }
}
