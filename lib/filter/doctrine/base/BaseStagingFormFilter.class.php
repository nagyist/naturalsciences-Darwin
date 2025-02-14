<?php

/**
 * Staging filter form base class.
 *
 * @package    darwin
 * @subpackage filter
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStagingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'import_ref'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Import'), 'add_empty' => true)),
      'category'                  => new sfWidgetFormFilterInput(),
      'expedition_ref'            => new sfWidgetFormFilterInput(),
      'expedition_name'           => new sfWidgetFormFilterInput(),
      'expedition_from_date'      => new sfWidgetFormFilterInput(),
      'expedition_from_date_mask' => new sfWidgetFormFilterInput(),
      'expedition_to_date'        => new sfWidgetFormFilterInput(),
      'expedition_to_date_mask'   => new sfWidgetFormFilterInput(),
      'station_visible'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'gtu_ref'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gtu_code'                  => new sfWidgetFormFilterInput(),
      'gtu_from_date_mask'        => new sfWidgetFormFilterInput(),
      'gtu_from_date'             => new sfWidgetFormFilterInput(),
      'gtu_to_date_mask'          => new sfWidgetFormFilterInput(),
      'gtu_to_date'               => new sfWidgetFormFilterInput(),
      'gtu_latitude'              => new sfWidgetFormFilterInput(),
      'gtu_longitude'             => new sfWidgetFormFilterInput(),
      'gtu_lat_long_accuracy'     => new sfWidgetFormFilterInput(),
      'gtu_elevation'             => new sfWidgetFormFilterInput(),
      'gtu_elevation_accuracy'    => new sfWidgetFormFilterInput(),
      'taxon_ref'                 => new sfWidgetFormFilterInput(),
      'taxon_name'                => new sfWidgetFormFilterInput(),
      'taxon_level_ref'           => new sfWidgetFormFilterInput(),
      'taxon_level_name'          => new sfWidgetFormFilterInput(),
      'taxon_status'              => new sfWidgetFormFilterInput(),
      'taxon_extinct'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'taxon_parents'             => new sfWidgetFormFilterInput(),
      'litho_ref'                 => new sfWidgetFormFilterInput(),
      'litho_name'                => new sfWidgetFormFilterInput(),
      'litho_level_ref'           => new sfWidgetFormFilterInput(),
      'litho_level_name'          => new sfWidgetFormFilterInput(),
      'litho_status'              => new sfWidgetFormFilterInput(),
      'litho_local'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'litho_color'               => new sfWidgetFormFilterInput(),
      'litho_parents'             => new sfWidgetFormFilterInput(),
      'chrono_ref'                => new sfWidgetFormFilterInput(),
      'chrono_name'               => new sfWidgetFormFilterInput(),
      'chrono_level_ref'          => new sfWidgetFormFilterInput(),
      'chrono_level_name'         => new sfWidgetFormFilterInput(),
      'chrono_status'             => new sfWidgetFormFilterInput(),
      'chrono_local'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'chrono_color'              => new sfWidgetFormFilterInput(),
      'chrono_lower_bound'        => new sfWidgetFormFilterInput(),
      'chrono_upper_bound'        => new sfWidgetFormFilterInput(),
      'chrono_parents'            => new sfWidgetFormFilterInput(),
      'lithology_ref'             => new sfWidgetFormFilterInput(),
      'lithology_name'            => new sfWidgetFormFilterInput(),
      'lithology_level_ref'       => new sfWidgetFormFilterInput(),
      'lithology_level_name'      => new sfWidgetFormFilterInput(),
      'lithology_status'          => new sfWidgetFormFilterInput(),
      'lithology_local'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lithology_color'           => new sfWidgetFormFilterInput(),
      'lithology_parents'         => new sfWidgetFormFilterInput(),
      'mineral_ref'               => new sfWidgetFormFilterInput(),
      'mineral_name'              => new sfWidgetFormFilterInput(),
      'mineral_level_ref'         => new sfWidgetFormFilterInput(),
      'mineral_level_name'        => new sfWidgetFormFilterInput(),
      'mineral_status'            => new sfWidgetFormFilterInput(),
      'mineral_local'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mineral_color'             => new sfWidgetFormFilterInput(),
      'mineral_parents'           => new sfWidgetFormFilterInput(),
      'mineral_classification'    => new sfWidgetFormFilterInput(),
      'ig_ref'                    => new sfWidgetFormFilterInput(),
      'ig_num'                    => new sfWidgetFormFilterInput(),
      'ig_date_mask'              => new sfWidgetFormFilterInput(),
      'ig_date'                   => new sfWidgetFormFilterInput(),
      'acquisition_category'      => new sfWidgetFormFilterInput(),
      'acquisition_date_mask'     => new sfWidgetFormFilterInput(),
      'acquisition_date'          => new sfWidgetFormFilterInput(),
      'individual_type'           => new sfWidgetFormFilterInput(),
      'individual_sex'            => new sfWidgetFormFilterInput(),
      'individual_state'          => new sfWidgetFormFilterInput(),
      'individual_stage'          => new sfWidgetFormFilterInput(),
      'individual_social_status'  => new sfWidgetFormFilterInput(),
      'individual_rock_form'      => new sfWidgetFormFilterInput(),
      'individual_count_min'      => new sfWidgetFormFilterInput(),
      'individual_count_max'      => new sfWidgetFormFilterInput(),
      'part'                      => new sfWidgetFormFilterInput(),
      'institution_ref'           => new sfWidgetFormFilterInput(),
      'institution_name'          => new sfWidgetFormFilterInput(),
      'building'                  => new sfWidgetFormFilterInput(),
      'floor'                     => new sfWidgetFormFilterInput(),
      'room'                      => new sfWidgetFormFilterInput(),
      'row'                       => new sfWidgetFormFilterInput(),
      'col'                       => new sfWidgetFormFilterInput(),
      'shelf'                     => new sfWidgetFormFilterInput(),
      'container_type'            => new sfWidgetFormFilterInput(),
      'container_storage'         => new sfWidgetFormFilterInput(),
      'container'                 => new sfWidgetFormFilterInput(),
      'sub_container_type'        => new sfWidgetFormFilterInput(),
      'sub_container_storage'     => new sfWidgetFormFilterInput(),
      'sub_container'             => new sfWidgetFormFilterInput(),
      'part_count_min'            => new sfWidgetFormFilterInput(),
      'part_count_max'            => new sfWidgetFormFilterInput(),
      'object_name'               => new sfWidgetFormFilterInput(),
      'specimen_status'           => new sfWidgetFormFilterInput(),
      'status'                    => new sfWidgetFormFilterInput(),
      'complete'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'surnumerary'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'import_ref'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Import'), 'column' => 'id')),
      'category'                  => new sfValidatorPass(array('required' => false)),
      'expedition_ref'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'expedition_name'           => new sfValidatorPass(array('required' => false)),
      'expedition_from_date'      => new sfValidatorPass(array('required' => false)),
      'expedition_from_date_mask' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'expedition_to_date'        => new sfValidatorPass(array('required' => false)),
      'expedition_to_date_mask'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'station_visible'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'gtu_ref'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gtu_code'                  => new sfValidatorPass(array('required' => false)),
      'gtu_from_date_mask'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gtu_from_date'             => new sfValidatorPass(array('required' => false)),
      'gtu_to_date_mask'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gtu_to_date'               => new sfValidatorPass(array('required' => false)),
      'gtu_latitude'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'gtu_longitude'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'gtu_lat_long_accuracy'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'gtu_elevation'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'gtu_elevation_accuracy'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'taxon_ref'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'taxon_name'                => new sfValidatorPass(array('required' => false)),
      'taxon_level_ref'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'taxon_level_name'          => new sfValidatorPass(array('required' => false)),
      'taxon_status'              => new sfValidatorPass(array('required' => false)),
      'taxon_extinct'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'taxon_parents'             => new sfValidatorPass(array('required' => false)),
      'litho_ref'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'litho_name'                => new sfValidatorPass(array('required' => false)),
      'litho_level_ref'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'litho_level_name'          => new sfValidatorPass(array('required' => false)),
      'litho_status'              => new sfValidatorPass(array('required' => false)),
      'litho_local'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'litho_color'               => new sfValidatorPass(array('required' => false)),
      'litho_parents'             => new sfValidatorPass(array('required' => false)),
      'chrono_ref'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'chrono_name'               => new sfValidatorPass(array('required' => false)),
      'chrono_level_ref'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'chrono_level_name'         => new sfValidatorPass(array('required' => false)),
      'chrono_status'             => new sfValidatorPass(array('required' => false)),
      'chrono_local'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'chrono_color'              => new sfValidatorPass(array('required' => false)),
      'chrono_lower_bound'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'chrono_upper_bound'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'chrono_parents'            => new sfValidatorPass(array('required' => false)),
      'lithology_ref'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lithology_name'            => new sfValidatorPass(array('required' => false)),
      'lithology_level_ref'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lithology_level_name'      => new sfValidatorPass(array('required' => false)),
      'lithology_status'          => new sfValidatorPass(array('required' => false)),
      'lithology_local'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lithology_color'           => new sfValidatorPass(array('required' => false)),
      'lithology_parents'         => new sfValidatorPass(array('required' => false)),
      'mineral_ref'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mineral_name'              => new sfValidatorPass(array('required' => false)),
      'mineral_level_ref'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mineral_level_name'        => new sfValidatorPass(array('required' => false)),
      'mineral_status'            => new sfValidatorPass(array('required' => false)),
      'mineral_local'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mineral_color'             => new sfValidatorPass(array('required' => false)),
      'mineral_parents'           => new sfValidatorPass(array('required' => false)),
      'mineral_classification'    => new sfValidatorPass(array('required' => false)),
      'ig_ref'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ig_num'                    => new sfValidatorPass(array('required' => false)),
      'ig_date_mask'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ig_date'                   => new sfValidatorPass(array('required' => false)),
      'acquisition_category'      => new sfValidatorPass(array('required' => false)),
      'acquisition_date_mask'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'acquisition_date'          => new sfValidatorPass(array('required' => false)),
      'individual_type'           => new sfValidatorPass(array('required' => false)),
      'individual_sex'            => new sfValidatorPass(array('required' => false)),
      'individual_state'          => new sfValidatorPass(array('required' => false)),
      'individual_stage'          => new sfValidatorPass(array('required' => false)),
      'individual_social_status'  => new sfValidatorPass(array('required' => false)),
      'individual_rock_form'      => new sfValidatorPass(array('required' => false)),
      'individual_count_min'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'individual_count_max'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'part'                      => new sfValidatorPass(array('required' => false)),
      'institution_ref'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'institution_name'          => new sfValidatorPass(array('required' => false)),
      'building'                  => new sfValidatorPass(array('required' => false)),
      'floor'                     => new sfValidatorPass(array('required' => false)),
      'room'                      => new sfValidatorPass(array('required' => false)),
      'row'                       => new sfValidatorPass(array('required' => false)),
      'col'                       => new sfValidatorPass(array('required' => false)),
      'shelf'                     => new sfValidatorPass(array('required' => false)),
      'container_type'            => new sfValidatorPass(array('required' => false)),
      'container_storage'         => new sfValidatorPass(array('required' => false)),
      'container'                 => new sfValidatorPass(array('required' => false)),
      'sub_container_type'        => new sfValidatorPass(array('required' => false)),
      'sub_container_storage'     => new sfValidatorPass(array('required' => false)),
      'sub_container'             => new sfValidatorPass(array('required' => false)),
      'part_count_min'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'part_count_max'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_name'               => new sfValidatorPass(array('required' => false)),
      'specimen_status'           => new sfValidatorPass(array('required' => false)),
      'status'                    => new sfValidatorPass(array('required' => false)),
      'complete'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'surnumerary'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('staging_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Staging';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'import_ref'                => 'ForeignKey',
      'category'                  => 'Text',
      'expedition_ref'            => 'Number',
      'expedition_name'           => 'Text',
      'expedition_from_date'      => 'Text',
      'expedition_from_date_mask' => 'Number',
      'expedition_to_date'        => 'Text',
      'expedition_to_date_mask'   => 'Number',
      'station_visible'           => 'Boolean',
      'gtu_ref'                   => 'Number',
      'gtu_code'                  => 'Text',
      'gtu_from_date_mask'        => 'Number',
      'gtu_from_date'             => 'Text',
      'gtu_to_date_mask'          => 'Number',
      'gtu_to_date'               => 'Text',
      'gtu_latitude'              => 'Number',
      'gtu_longitude'             => 'Number',
      'gtu_lat_long_accuracy'     => 'Number',
      'gtu_elevation'             => 'Number',
      'gtu_elevation_accuracy'    => 'Number',
      'taxon_ref'                 => 'Number',
      'taxon_name'                => 'Text',
      'taxon_level_ref'           => 'Number',
      'taxon_level_name'          => 'Text',
      'taxon_status'              => 'Text',
      'taxon_extinct'             => 'Boolean',
      'taxon_parents'             => 'Text',
      'litho_ref'                 => 'Number',
      'litho_name'                => 'Text',
      'litho_level_ref'           => 'Number',
      'litho_level_name'          => 'Text',
      'litho_status'              => 'Text',
      'litho_local'               => 'Boolean',
      'litho_color'               => 'Text',
      'litho_parents'             => 'Text',
      'chrono_ref'                => 'Number',
      'chrono_name'               => 'Text',
      'chrono_level_ref'          => 'Number',
      'chrono_level_name'         => 'Text',
      'chrono_status'             => 'Text',
      'chrono_local'              => 'Boolean',
      'chrono_color'              => 'Text',
      'chrono_lower_bound'        => 'Number',
      'chrono_upper_bound'        => 'Number',
      'chrono_parents'            => 'Text',
      'lithology_ref'             => 'Number',
      'lithology_name'            => 'Text',
      'lithology_level_ref'       => 'Number',
      'lithology_level_name'      => 'Text',
      'lithology_status'          => 'Text',
      'lithology_local'           => 'Boolean',
      'lithology_color'           => 'Text',
      'lithology_parents'         => 'Text',
      'mineral_ref'               => 'Number',
      'mineral_name'              => 'Text',
      'mineral_level_ref'         => 'Number',
      'mineral_level_name'        => 'Text',
      'mineral_status'            => 'Text',
      'mineral_local'             => 'Boolean',
      'mineral_color'             => 'Text',
      'mineral_parents'           => 'Text',
      'mineral_classification'    => 'Text',
      'ig_ref'                    => 'Number',
      'ig_num'                    => 'Text',
      'ig_date_mask'              => 'Number',
      'ig_date'                   => 'Text',
      'acquisition_category'      => 'Text',
      'acquisition_date_mask'     => 'Number',
      'acquisition_date'          => 'Text',
      'individual_type'           => 'Text',
      'individual_sex'            => 'Text',
      'individual_state'          => 'Text',
      'individual_stage'          => 'Text',
      'individual_social_status'  => 'Text',
      'individual_rock_form'      => 'Text',
      'individual_count_min'      => 'Number',
      'individual_count_max'      => 'Number',
      'part'                      => 'Text',
      'institution_ref'           => 'Number',
      'institution_name'          => 'Text',
      'building'                  => 'Text',
      'floor'                     => 'Text',
      'room'                      => 'Text',
      'row'                       => 'Text',
      'col'                       => 'Text',
      'shelf'                     => 'Text',
      'container_type'            => 'Text',
      'container_storage'         => 'Text',
      'container'                 => 'Text',
      'sub_container_type'        => 'Text',
      'sub_container_storage'     => 'Text',
      'sub_container'             => 'Text',
      'part_count_min'            => 'Number',
      'part_count_max'            => 'Number',
      'object_name'               => 'Text',
      'specimen_status'           => 'Text',
      'status'                    => 'Text',
      'complete'                  => 'Boolean',
      'surnumerary'               => 'Boolean',
    );
  }
}
