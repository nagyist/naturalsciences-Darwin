<?php 
class ImportABCDXml implements IImportModels
{
  private $tag, $staging, $object, $people,$import_id, $path="", $name, $errors_reported='';
  private $unit_id_ref = array() ; // to keep the original unid_id per staging for Associations
  private $object_to_save = array(), $staging_tags = array() , $data, $inside_data;
  /**
  * @function parseFile() read a 'to_be_loaded' xml file and import it, if possible in staging table
  * @var $file : the xml file to parse
  * @var $id : is the reference to the record in import table
  **/
  public function parseFile($file,$id)
  {
    $this->import_id = $id ;
    $xml_parser = xml_parser_create();
    xml_set_object($xml_parser, $this) ;
    xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
    xml_set_element_handler($xml_parser, "startElement", "endElement");
    xml_set_character_data_handler($xml_parser, "characterData");
    if (!($fp = fopen($file, "r"))) {
        return("could not open XML input");
    }
    while ($this->data = fread($fp, 4096)) {
        if (!xml_parse($xml_parser, $this->data, feof($fp))) {
            return (sprintf("XML error: %s at line %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
        }
    }
    xml_parser_free($xml_parser);
    return $this->errors_reported ;
  }

  private function startElement($parser, $name, $attrs)
  {
    $this->tag = $name ;
    $this->path .= "/$name" ;
    $this->cdata = '' ;
    $this->inside_data = false ;
    switch ($name) {
      case "Accessions" : $this->object = new parsingTag() ; break ;;
      case "Biotope" : /*@TODO ;*/ break ;;
      case "efg:ChronostratigraphicAttributions" :
      case "ChronostratigraphicAttributions" : $this->object = new ParsingCatalogue('chronostratigraphy') ; break ;;
      case "Country" : $this->object->tag_group_name="country" ; break ;;
      case "dna:DNASample" : $this->object = new ParsingMaintenance('Dna extraction') ; break ;;
      case "RockPhysicalCharacteristics" :
      case "efg:RockPhysicalCharacteristics" : $this->object = new ParsingTag("lithology") ; break ;;
      case "LithostratigraphicAttribution" :
      case "efg:LithostratigraphicAttribution" : $this->object = new ParsingCatalogue('lithostratigraphy') ; break ;;
      case "Gathering" : $this->object = new ParsingTag("gtu") ; $this->comment_notion = 'general comments'  ; break ;;
      case "efg:MineralRockIdentified" :
      case "HigherTaxa" : $this->object->catalogue_parent = new Hstore() ;break ;;
      case "Identification" : $this->object = new ParsingIdentifications() ; break ;;
      case "MeasurementOrFactAtomised" : $this->property = new ParsingProperties($this->getPreviousTag()) ; break ;;
      case "MultiMediaObject" : $this->object = new ParsingMultimedia() ; break ;;
      case "PersonName" : $this->people = new StagingPeople() ; break ;;
      case "Person" : $this->people = new StagingPeople() ; break ;;
      case "Petrology" : $this->object = new ParsingTag("lithology") ; break ;;
      case "efg:RockUnit" :
      case "RockUnit" : $this->object = new ParsingCatalogue('lithology') ; break ;;
      case "Sequence" : $this->object = new ParsingMaintenance('Sequencing') ; break ;;
      case "SpecimenUnit" : $this->object = new ParsingTag("unit") ; break ;;
      case "Unit" : $this->staging = new Staging(); $this->name = ""; $this->staging->setId($this->getStagingId()); break ;;
      case "UnitAssociation" : $this->object = new stagingRelationship() ; break ;;
      case "UnitID" : $this->code = new Codes() ; break ;;
    }
  }

  private function endElement($parser, $name)
  {
    $this->inside_data = false ;
    if (in_array($this->getPreviousTag(),array('Bacterial','Zoological','Botanical','Viral'))) $this->object->handleKeyword($this->tag,$this->cdata,$this->staging) ;
    elseif($this->getPreviousTag() == "efg:LithostratigraphicAttribution") $this->object->handleParent($name, $this->cdata,$this->staging) ;
    else {
    switch ($name) {
      case "AccessionCatalogue" : $this->object->addAccession($this->cdata) ; break ;;
      case "AccessionDate" : if (date('Y-m-d H:i:s', strtotime($this->cdata)) == $this->cdata) $this->object->InitAccessionVar($this->cdata) ; break ;;
      case "AccessionNumber" :  $this->object->accession_num = $this->cdata ; $this->object->HandleAccession($this->staging,$this->object_to_save) ; break ;;
      case "Accuracy" : $this->getPreviousTag()=='Altitude'?$this->staging['gtu_elevation_accuracy']=$this->cdata:$this->property->property->property_accuracy=$this->cdata ; break ;;
      case "AcquisitionDate" : $this->staging['acquisition_date'] = FuzzyDateTime::getValidDate($this->cdata) ; $this->staging['acquisition_date_mask'] = 56;  break ;;
      case "AcquisitionType" : $this->staging['acquisition_category'] = $this->cdata=='gift'?'donation':$this->cdata ; break ;;
      case "AppliesTo" : $this->property->setAppliesTo($this->cdata); break ;;
      case "AreaClass" : $this->object->tag_group_name = $this->cdata ; break ;;
      case "AreaName" : $this->object->tag_value = $this->cdata ; break ;;
      case "AssociatedUnitID" : if(in_array($this->cdata, array_keys($this->unit_id_ref))) $this->object->setStagingRelatedRef($this->unit_id_ref[$this->cdata]); else $this->object->setSourceId($this->cdata) ; break ;;
      case "AssociatedUnitSourceInstitutionCode" : $this->object->setInstitutionName($this->cdata) ; break ;;
      case "AssociatedUnitSourceName" : $this->object->setSourceName($this->cdata) ; break ;;
      case "AssociationType" : $this->object->setRelationshipType($this->cdata) ; break ;;
      case "efg:ChronostratigraphicAttribution" : $this->cdata = $this->object->setChronoParent() ; if(!$this->cdata) $this->addComment(true) ; break ;;
      case "efg:ChronoStratigraphicDivision" : $this->object->getChronoLevel($this->cdata) ; break ;;
      case "efg:ChronostratigraphicAttributions" : $this->object->saveChrono($this->staging) ; break ;;
      case "efg:ChronostratigraphicName" : $this->object->name = $this->cdata ; break ;;
      case "Code" : $this->staging['gtu_code'] = $this->cdata ; break ;;
      case "CoordinateErrorDistanceInMeters" : $this->staging['gtu_lat_long_accuracy'] = $this->cdata ; break ;;
      case "Context" : $this->object->multimedia_data['sub_type'] = $this->cdata ; break ;;
      case "CreatedDate" : $this->object->multimedia_data['creation_date'] = $this->cdata ; break ;; 
    //  case "efg:ClassifiedName" : $this->object->setRockName($this->staging) ; break ;;
      case "Comment" : $this->object->multimedia_data['description'] = $this->cdata ; break ;;
      case "Country" : $this->staging_tags[] = $this->object->addTagGroups() ;break;;
      case "Database" : $this->object->desc .= "Database ref :".$this->cdata.";"  ; break ;;
      case "DateText" : $this->object->getDateText($this->cdata) ; break ;;
      case "DateTime" : $this->staging["gtu_from_date"] = $this->object->getFromDate() ; $this->staging["gtu_to_date"] = $this->object->getToDate() ; 
                        $this->staging["gtu_from_date_mask"] = 56 ; $this->staging["gtu_to_date_mask"] = 56 ; break ;;
      case "dna:Concentration" : /* this->object->properties */ break ;;
      case "dna:DNASample" : $this->object->addMaintenance($this->staging) ; break ;;
      case "dna:ExtractionDate" : $this->object->maintenance->setModificationDateTime($this->cdata) ; break ;;
      case "dna:ExtractionMethod" : $this->object->maintenance->setDescription($this->cdata) ; break ;;
      case "dna:RatioOfAbsorbance260_280" : /* this->object->properties */ break ;;
      case "dna:Tissu" : $this->object->maintenance->setActionObservation($this->cdata) ; break ;;
      case "Duration" : $this->property->setDateTo($this->cdata) ; break ;;
      case "FileURI" : $this->object->getFile($this->cdata) ; break ;;
      case "Format" : $this->object->multimedia_data['type'] = $this->cdata ; break ;;
      case "FullName" : $this->people['formated_name'] = $this->cdata ; break ;;
      case "efg:FullScientificNameString":
      case "FullScientificNameString" : $this->object->fullname = $this->cdata ; break;;
      case "efg:InformalLithostratigraphicName" : $this->staging['litho_local'] = true ; break ;;
      case "Gathering" : if($this->object->staging_info!=null) $this->object_to_save[] = $this->object->staging_info; break ;;
      case "GivenNames" : $this->people['given_name'] = $this->cdata ; break ;;
      case "HigherTaxa" : $this->object->getCatalogueParent($this->staging) ; break ;;
      case "HigherTaxon" : $this->object->handleParent() ;break;;
      case "HigherTaxonName" : $this->object->higher_name = $this->cdata ; break;;
      case "HigherTaxonRank" : $this->object->higher_level = $this->cdata ; break;;
      case "efg:LithostratigraphicAttribution" : $this->staging["litho_parents"] = $this->object->getParent() ; break ;;
      case "Identification" : $this->object->save($this->staging) ; break ;;
      case "IdentificationHistory" : $this->object->determination_status = $this->cdata ; break ;;
      case "ID-in-Database" : $this->object->desc .= "id in database :".$this->cdata." ;" ; break ;;
      case "efg:InformalLithostratigraphicName" : $this->staging['litho_local'] = true ; break ;;
      case "efg:InformalNameString" : $this->object->informal = true ; break ;;
      case "InheritedName" : $this->people['family_name'] = $this->cdata ; break ;;
      case "ISODateTimeBegin" : $this->object->GTUdate['from'] = $this->cdata ; break ;;
      case "ISODateTimeEnd" : $this->object->GTUdate['to'] = $this->cdata ; break ;;
      case "IsQuantitative" : /*$this->property->property->setIsQuantitative($this->cdata) ; */ break ;;
      case "KindOfUnit" : $this->staging['part'] = $this->cdata ; break ;;
      case "LatitudeDecimal" : $this->staging['gtu_latitude'] = $this->cdata ; break ;;
      case "Length" : $this->object->desc .= "Length : ".$this->cdata." ;" ; break ;;
      case "efg:LithostratigraphicAttributions" : $this->object->setAttribution($this->staging) ; break ;;
      case "LocalityText" : if($this->staging['gtu_code']) $this->addComment() ; ELSE $this->staging['gtu_code'] = $this->cdata ; break ;; 
      case "LongitudeDecimal" : $this->staging['gtu_longitude'] = $this->cdata ; break ;;
      case "LowerValue" : $this->property->property->setLowerValue($this->cdata) ; break ;;
      case "MeasurementDateTime" : $this->property->getDateFrom($this->cdata, $this->getPreviousTag(),$this->staging) ; break ;;
      case "Method" : $this->object_to_save[] = $this->object->addMethod($this->cdata,$this->staging->getId()) ; break ;;
      case "efg:Petrology" :
      case "MeasurementsOrFacts" : if($this->object->staging_info) $this->object_to_save[] = $this->object->staging_info; break ;;
      case "MeasurementOrFactAtomised" : $this->addProperty(); break ;;
      case "MeasurementOrFactText" : $this->addComment() ; break ;;
      case "MineralColour" : $this->staging->setMineralColour($this->cdata) ; break ;;
      case "efg:MineralRockClassification" : $this->object->higher_level = $this->cdata ;break;;
      case "efg:MineralRockGroup" : $this->object->handleRockParent() ; break ;;
      case "efg:MineralRockGroupName" : $this->object->higher_name = $this->cdata ; break ;;
      case "efg:MineralRockIdentified" : $this->object->getCatalogueParent($this->staging) ; break ;;
      case "MultiMediaObject" : if($this->object->isFileOk()) $this->staging->addRelated($this->object->multimedia) ; else $this->errors_reported .= "Unit ".$this->name." : MultiMediaObject not saved (no or wrong FileURI);"; break ;;
      case "Name" : if($this->getPreviousTag() == "Country") $this->object->tag_value=$this->cdata ; break ;; //@TODO
      case "efg:NameComments" : $this->object->setNotion(strtolower($this->cdata)) ; break ;;
      case "NamedArea" : $this->staging_tags[] = $this->object->addTagGroups() ;break;;
      case "Notes" : $this->addComment() ; break ;
      case "Parameter" : $this->property->property->setPropertyType($this->cdata);break ;;
      case "PersonName" : /*if($this->object->notion == 'taxonomy') $this->object->notion = 'mineralogy' ;*/ $this->object->handlePeople($this->people) ; break ;;
      case "Person" : $this->object->handlePeople($this->people,$this->staging,true) ; break ;;
      case "efg:MineralDescriptionText" :
      case "PetrologyDescriptiveText" :
      case "efg:PetrologyDescriptiveText" : $this->addComment() ; break ;;
      case "PhaseOrStage" : $this->staging->setIndividualStage($this->cdata) ; break ;;
      case "Prefix" : $this->people['title'] = $this->cdata ; break ;;
      case "PreparationMaterials" : $this->staging['container_storage'] = $this->cdata ; break ;;
      case "ProjectTitle" : $this->staging['expedition_name'] = $this->cdata ; break ;;
      case "RecordURI" : $this->addExternalLink() ; break ;;
      //case "efg:RockType" :
      //case "RockType" : $this->staging->setLithologyName($this->cdata) ; break ;;
      case "ScientificName" : $this->staging["taxon_name"] = $this->object->getCatalogueName() ;
                              $this->staging["taxon_level_name"] = $this->object->level_name ;break ;;
      case "Sequence" : $this->object->addMaintenance($this->staging, true) ; break ;;
      case "Sex" : $this->staging->setIndividualSex($this->cdata) ; break ;;
      case "SortingName" : $this->object->people_order_by = $this->cdata ; break ;;
      case "storage:Institution" : $this->staging->setInstitutionName($this->cdata) ; break ;;
      case "storage:Building" : $this->staging->setBuilding($this->cdata) ; break ;;
      case "storage:Floor" : $this->staging->setFloor($this->cdata) ; break ;;
      case "storage:Room" : $this->staging->setRoom($this->cdata) ; break ;;
      case "storage:Row" : $this->staging->setRow($this->cdata) ; break ;;
      case "storage:Shelf" : $this->staging->setShelf($this->cdata) ; break ;;
      case "storage:Box" : $this->staging->setContainerType('box'); $this->staging->setContainer($this->cdata) ; break ;;
      case "storage:Tube" : $this->staging->setSubContainerType('tube'); $this->staging->setSubContainer($this->cdata) ; break ;;
      case "TitleCitation" : if(substr($this->cdata,0,7) == 'http://') $this->addExternalLink() ;  $this->addComment(true) ; break ;;
      case "TypeStatus" : $this->staging->setIndividualType($this->cdata) ; break ;;
      case "Unit" : $this->saveUnit(); break ;;
      case "UnitAssociation" : $this->staging->addRelated($this->object) ; break ;;
      case "UnitID" : $this->code['code'] = $this->cdata ; $this->name = $this->cdata ; 
                      if(substr($this->code['code'],0,4) != 'hash') $this->staging->addRelated($this->code) ; break ;;
      case "UnitOfMeasurement" : $this->property->property->setPropertyAccuracy($this->cdata);$this->property->property->setPropertyUnit($this->cdata); break ;;
      case "UpperValue" : $this->property->property->setUpperValue($this->cdata) ; break ;;
      case "efg:VarietalNameString" : $this->staging->setObjectName($this->cdata) ; break ;; //$this->object->level_name='variety' ; break ;;
      case "VerificationLevel" : $this->object->determination_status = $this->cdata ; break ;;
    } }
    $this->tag = "" ;
    $this->path = substr($this->path,0,strrpos($this->path,"/$name")) ;
  }

  private function characterData($parser, $data)
  {
//     if($this->tag == 'AcquisitionDate') echo(FuzzyDateTime::getValidDate($data)) ;
    if ($this->inside_data)
      $this->cdata .= strtolower($data) ;
    else
      $this->cdata = strtolower($data) ;
    $this->inside_data = true;
  }

  private function getPreviousTag($tag=null)
  {
    if(!$tag) $tag = $this->tag ;
    $part = substr($this->path,0,strrpos($this->path,"/$tag")) ;
    return (substr($part,strrpos($part,'/')+1,strlen($part))) ;
  }

  private function addComment($is_staging = false)
  {
    $comment = new Comments() ;
    $comment->setComment($this->cdata) ;
    if($is_staging || $this->getPreviousTag()=='Unit' || $this->getPreviousTag()=='Identification' || $this->getPreviousTag("MeasurementsOrFacts") == "Unit" || $this->getPreviousTag() == "efg:MineralogicalUnit")
    {
      $comment->setNotionConcerned("general") ;
      $this->staging->addRelated($comment) ;
    }
    else
    {
      $comment->setNotionConcerned("general comments") ;
      $this->object->addStagingInfo($comment,$this->staging->getId());
    }
  }

  private function addProperty()
  {
    if($this->getPreviousTag("MeasurementsOrFacts") == "Unit" || $this->getPreviousTag()=='Identification')
      $this->staging->addRelated($this->property->property) ;
    elseif (in_array($this->getPreviousTag(),array('efg:RockPhysicalCharacteristic','efg:MineralMeasurementOrFact')))
      $this->staging->addRelated($this->property->property) ;
    else $this->object->addStagingInfo($this->property->property, $this->staging->getId());
  }

  private function saveObjects()
  {
    foreach($this->object_to_save as $object) 
    {
      try { $object->save() ; }
      catch(Doctrine_Exception $ne)
      {
        $e = new DarwinPgErrorParser($ne);
        $this->errors_reported .= "Unit ".$this->name." : ".$object->getTable()->getTableName()." were not saved".$e->getMessage().";";
      }
    }
    foreach($this->staging_tags as $object) 
    {
      $object->setStagingRef($this->staging->getId()) ;
      try { $object->save() ; }
      catch(Doctrine_Exception $ne)
      {
        $e = new DarwinPgErrorParser($ne);
        $this->errors_reported .= "NamedArea ".$object->getSubGroupName()." were not saved".$e->getMessage().";";
      }
    }
    $this->staging_tags = array() ;
    $this->object_to_save = array() ;
  }

  private function addExternalLink()
  {
    $prefix = substr($this->cdata,0,strpos($this->cdata,"://")) ;
    if($prefix != "http" && $prefix != "https") $this->cdata = "http://".$this->cdata ;
    $ext = new ExtLinks();
    $ext->setUrl($this->cdata) ;
    $ext->setComment('Record web address') ;
    $this->staging->addRelated($ext) ;
  }

  private function saveUnit()
  {
    $ok = true ;
    $this->staging->fromArray(array("import_ref" => $this->import_id));
    try 
    {
      $this->staging->save() ;
    }
    catch(Doctrine_Exception $ne)
    {
      $e = new DarwinPgErrorParser($ne);
      $this->errors_reported .= "Unit ".$this->name." object were not saved:".$e->getMessage().";";
      $ok = false ;
    }
    if ($ok)
    {
      $this->saveObjects() ;
      $this->unit_id_ref[$this->name] = $this->staging->getId()  ;
    }
  }
  
  private function getStagingId()
  {
    $conn = Doctrine_Manager::connection();
    $conn->getDbh()->exec('BEGIN TRANSACTION;');
    return $conn->fetchOne("SELECT nextval('staging_id_seq');") ;
  }
}