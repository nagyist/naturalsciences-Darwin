<?php

/**
 * PartSearch filter form base class.
 *
 * @package    darwin
 * @subpackage filter
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePartSearchFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                            => new sfWidgetFormFilterInput(),
      'category'                                      => new sfWidgetFormFilterInput(),
      'collection_ref'                                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collection'), 'add_empty' => true)),
      'collection_type'                               => new sfWidgetFormFilterInput(),
      'collection_code'                               => new sfWidgetFormFilterInput(),
      'collection_name'                               => new sfWidgetFormFilterInput(),
      'collection_is_public'                          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'collection_institution_ref'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CollectionInstitution'), 'add_empty' => true)),
      'collection_institution_formated_name'          => new sfWidgetFormFilterInput(),
      'collection_institution_formated_name_ts'       => new sfWidgetFormFilterInput(),
      'collection_institution_formated_name_indexed'  => new sfWidgetFormFilterInput(),
      'collection_institution_sub_type'               => new sfWidgetFormFilterInput(),
      'collection_main_manager_ref'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CollectionMainManager'), 'add_empty' => true)),
      'collection_main_manager_formated_name'         => new sfWidgetFormFilterInput(),
      'collection_main_manager_formated_name_ts'      => new sfWidgetFormFilterInput(),
      'collection_main_manager_formated_name_indexed' => new sfWidgetFormFilterInput(),
      'collection_parent_ref'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CollectionParent'), 'add_empty' => true)),
      'collection_path'                               => new sfWidgetFormFilterInput(),
      'expedition_ref'                                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Expedition'), 'add_empty' => true)),
      'expedition_name'                               => new sfWidgetFormFilterInput(),
      'expedition_name_ts'                            => new sfWidgetFormFilterInput(),
      'expedition_name_indexed'                       => new sfWidgetFormFilterInput(),
      'station_visible'                               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'gtu_ref'                                       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gtu'), 'add_empty' => true)),
      'gtu_code'                                      => new sfWidgetFormFilterInput(),
      'gtu_parent_ref'                                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GtuParent'), 'add_empty' => true)),
      'gtu_path'                                      => new sfWidgetFormFilterInput(),
      'gtu_from_date_mask'                            => new sfWidgetFormFilterInput(),
      'gtu_from_date'                                 => new sfWidgetFormFilterInput(),
      'gtu_to_date_mask'                              => new sfWidgetFormFilterInput(),
      'gtu_to_date'                                   => new sfWidgetFormFilterInput(),
      'gtu_tag_values_indexed'                        => new sfWidgetFormFilterInput(),
      'gtu_country_tag_value'                         => new sfWidgetFormFilterInput(),
      'taxon_ref'                                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Taxonomy'), 'add_empty' => true)),
      'taxon_name'                                    => new sfWidgetFormFilterInput(),
      'taxon_name_indexed'                            => new sfWidgetFormFilterInput(),
      'taxon_name_order_by'                           => new sfWidgetFormFilterInput(),
      'taxon_level_ref'                               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomyLevel'), 'add_empty' => true)),
      'taxon_level_name'                              => new sfWidgetFormFilterInput(),
      'taxon_status'                                  => new sfWidgetFormFilterInput(),
      'taxon_path'                                    => new sfWidgetFormFilterInput(),
      'taxon_parent_ref'                              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomyParent'), 'add_empty' => true)),
      'taxon_extinct'                                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'litho_ref'                                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lithostratigraphy'), 'add_empty' => true)),
      'litho_name'                                    => new sfWidgetFormFilterInput(),
      'litho_name_indexed'                            => new sfWidgetFormFilterInput(),
      'litho_name_order_by'                           => new sfWidgetFormFilterInput(),
      'litho_level_ref'                               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LithostratigraphyLevel'), 'add_empty' => true)),
      'litho_level_name'                              => new sfWidgetFormFilterInput(),
      'litho_status'                                  => new sfWidgetFormFilterInput(),
      'litho_path'                                    => new sfWidgetFormFilterInput(),
      'litho_parent_ref'                              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LithostratigraphyParent'), 'add_empty' => true)),
      'chrono_ref'                                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Chronostratigraphy'), 'add_empty' => true)),
      'chrono_name'                                   => new sfWidgetFormFilterInput(),
      'chrono_name_indexed'                           => new sfWidgetFormFilterInput(),
      'chrono_name_order_by'                          => new sfWidgetFormFilterInput(),
      'chrono_level_ref'                              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ChronostratigraphyLevel'), 'add_empty' => true)),
      'chrono_level_name'                             => new sfWidgetFormFilterInput(),
      'chrono_status'                                 => new sfWidgetFormFilterInput(),
      'chrono_path'                                   => new sfWidgetFormFilterInput(),
      'chrono_parent_ref'                             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ChronostratigraphyParent'), 'add_empty' => true)),
      'lithology_ref'                                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lithology'), 'add_empty' => true)),
      'lithology_name'                                => new sfWidgetFormFilterInput(),
      'lithology_name_indexed'                        => new sfWidgetFormFilterInput(),
      'lithology_name_order_by'                       => new sfWidgetFormFilterInput(),
      'lithology_level_ref'                           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LithologyLevel'), 'add_empty' => true)),
      'lithology_level_name'                          => new sfWidgetFormFilterInput(),
      'lithology_status'                              => new sfWidgetFormFilterInput(),
      'lithology_path'                                => new sfWidgetFormFilterInput(),
      'lithology_parent_ref'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LithologyParent'), 'add_empty' => true)),
      'mineral_ref'                                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mineralogy'), 'add_empty' => true)),
      'mineral_name'                                  => new sfWidgetFormFilterInput(),
      'mineral_name_indexed'                          => new sfWidgetFormFilterInput(),
      'mineral_name_order_by'                         => new sfWidgetFormFilterInput(),
      'mineral_level_ref'                             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MineralogyLevel'), 'add_empty' => true)),
      'mineral_level_name'                            => new sfWidgetFormFilterInput(),
      'mineral_status'                                => new sfWidgetFormFilterInput(),
      'mineral_path'                                  => new sfWidgetFormFilterInput(),
      'mineral_parent_ref'                            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MineralogyParent'), 'add_empty' => true)),
      'host_taxon_ref'                                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HostTaxon'), 'add_empty' => true)),
      'host_relationship'                             => new sfWidgetFormFilterInput(),
      'host_taxon_name'                               => new sfWidgetFormFilterInput(),
      'host_taxon_name_indexed'                       => new sfWidgetFormFilterInput(),
      'host_taxon_name_order_by'                      => new sfWidgetFormFilterInput(),
      'host_taxon_level_ref'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HostTaxonLevel'), 'add_empty' => true)),
      'host_taxon_level_name'                         => new sfWidgetFormFilterInput(),
      'host_taxon_status'                             => new sfWidgetFormFilterInput(),
      'host_taxon_path'                               => new sfWidgetFormFilterInput(),
      'host_taxon_parent_ref'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HostTaxonParent'), 'add_empty' => true)),
      'host_taxon_extinct'                            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ig_ref'                                        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ig'), 'add_empty' => true)),
      'ig_num'                                        => new sfWidgetFormFilterInput(),
      'ig_num_indexed'                                => new sfWidgetFormFilterInput(),
      'ig_date_mask'                                  => new sfWidgetFormFilterInput(),
      'ig_date'                                       => new sfWidgetFormFilterInput(),
      'acquisition_category'                          => new sfWidgetFormFilterInput(),
      'acquisition_date_mask'                         => new sfWidgetFormFilterInput(),
      'acquisition_date'                              => new sfWidgetFormFilterInput(),
      'specimen_count_min'                            => new sfWidgetFormFilterInput(),
      'specimen_count_max'                            => new sfWidgetFormFilterInput(),
      'individual_type'                               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_type_group'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_type_search'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_sex'                                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_state'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_stage'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_social_status'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_rock_form'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'individual_count_min'                          => new sfWidgetFormFilterInput(),
      'individual_count_max'                          => new sfWidgetFormFilterInput(),
      'part'                                          => new sfWidgetFormFilterInput(),
      'part_status'                                   => new sfWidgetFormFilterInput(),
      'building'                                      => new sfWidgetFormFilterInput(),
      'floor'                                         => new sfWidgetFormFilterInput(),
      'room'                                          => new sfWidgetFormFilterInput(),
      'row'                                           => new sfWidgetFormFilterInput(),
      'shelf'                                         => new sfWidgetFormFilterInput(),
      'container_type'                                => new sfWidgetFormFilterInput(),
      'container_storage'                             => new sfWidgetFormFilterInput(),
      'container'                                     => new sfWidgetFormFilterInput(),
      'sub_container_type'                            => new sfWidgetFormFilterInput(),
      'sub_container_storage'                         => new sfWidgetFormFilterInput(),
      'sub_container'                                 => new sfWidgetFormFilterInput(),
      'part_count_min'                                => new sfWidgetFormFilterInput(),
      'part_count_max'                                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id'                                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'category'                                      => new sfValidatorPass(array('required' => false)),
      'collection_ref'                                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Collection'), 'column' => 'id')),
      'collection_type'                               => new sfValidatorPass(array('required' => false)),
      'collection_code'                               => new sfValidatorPass(array('required' => false)),
      'collection_name'                               => new sfValidatorPass(array('required' => false)),
      'collection_is_public'                          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'collection_institution_ref'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CollectionInstitution'), 'column' => 'id')),
      'collection_institution_formated_name'          => new sfValidatorPass(array('required' => false)),
      'collection_institution_formated_name_ts'       => new sfValidatorPass(array('required' => false)),
      'collection_institution_formated_name_indexed'  => new sfValidatorPass(array('required' => false)),
      'collection_institution_sub_type'               => new sfValidatorPass(array('required' => false)),
      'collection_main_manager_ref'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CollectionMainManager'), 'column' => 'id')),
      'collection_main_manager_formated_name'         => new sfValidatorPass(array('required' => false)),
      'collection_main_manager_formated_name_ts'      => new sfValidatorPass(array('required' => false)),
      'collection_main_manager_formated_name_indexed' => new sfValidatorPass(array('required' => false)),
      'collection_parent_ref'                         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CollectionParent'), 'column' => 'id')),
      'collection_path'                               => new sfValidatorPass(array('required' => false)),
      'expedition_ref'                                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Expedition'), 'column' => 'id')),
      'expedition_name'                               => new sfValidatorPass(array('required' => false)),
      'expedition_name_ts'                            => new sfValidatorPass(array('required' => false)),
      'expedition_name_indexed'                       => new sfValidatorPass(array('required' => false)),
      'station_visible'                               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'gtu_ref'                                       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gtu'), 'column' => 'id')),
      'gtu_code'                                      => new sfValidatorPass(array('required' => false)),
      'gtu_parent_ref'                                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('GtuParent'), 'column' => 'id')),
      'gtu_path'                                      => new sfValidatorPass(array('required' => false)),
      'gtu_from_date_mask'                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gtu_from_date'                                 => new sfValidatorPass(array('required' => false)),
      'gtu_to_date_mask'                              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gtu_to_date'                                   => new sfValidatorPass(array('required' => false)),
      'gtu_tag_values_indexed'                        => new sfValidatorPass(array('required' => false)),
      'gtu_country_tag_value'                         => new sfValidatorPass(array('required' => false)),
      'taxon_ref'                                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Taxonomy'), 'column' => 'id')),
      'taxon_name'                                    => new sfValidatorPass(array('required' => false)),
      'taxon_name_indexed'                            => new sfValidatorPass(array('required' => false)),
      'taxon_name_order_by'                           => new sfValidatorPass(array('required' => false)),
      'taxon_level_ref'                               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomyLevel'), 'column' => 'id')),
      'taxon_level_name'                              => new sfValidatorPass(array('required' => false)),
      'taxon_status'                                  => new sfValidatorPass(array('required' => false)),
      'taxon_path'                                    => new sfValidatorPass(array('required' => false)),
      'taxon_parent_ref'                              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomyParent'), 'column' => 'id')),
      'taxon_extinct'                                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'litho_ref'                                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lithostratigraphy'), 'column' => 'id')),
      'litho_name'                                    => new sfValidatorPass(array('required' => false)),
      'litho_name_indexed'                            => new sfValidatorPass(array('required' => false)),
      'litho_name_order_by'                           => new sfValidatorPass(array('required' => false)),
      'litho_level_ref'                               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LithostratigraphyLevel'), 'column' => 'id')),
      'litho_level_name'                              => new sfValidatorPass(array('required' => false)),
      'litho_status'                                  => new sfValidatorPass(array('required' => false)),
      'litho_path'                                    => new sfValidatorPass(array('required' => false)),
      'litho_parent_ref'                              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LithostratigraphyParent'), 'column' => 'id')),
      'chrono_ref'                                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Chronostratigraphy'), 'column' => 'id')),
      'chrono_name'                                   => new sfValidatorPass(array('required' => false)),
      'chrono_name_indexed'                           => new sfValidatorPass(array('required' => false)),
      'chrono_name_order_by'                          => new sfValidatorPass(array('required' => false)),
      'chrono_level_ref'                              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ChronostratigraphyLevel'), 'column' => 'id')),
      'chrono_level_name'                             => new sfValidatorPass(array('required' => false)),
      'chrono_status'                                 => new sfValidatorPass(array('required' => false)),
      'chrono_path'                                   => new sfValidatorPass(array('required' => false)),
      'chrono_parent_ref'                             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ChronostratigraphyParent'), 'column' => 'id')),
      'lithology_ref'                                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lithology'), 'column' => 'id')),
      'lithology_name'                                => new sfValidatorPass(array('required' => false)),
      'lithology_name_indexed'                        => new sfValidatorPass(array('required' => false)),
      'lithology_name_order_by'                       => new sfValidatorPass(array('required' => false)),
      'lithology_level_ref'                           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LithologyLevel'), 'column' => 'id')),
      'lithology_level_name'                          => new sfValidatorPass(array('required' => false)),
      'lithology_status'                              => new sfValidatorPass(array('required' => false)),
      'lithology_path'                                => new sfValidatorPass(array('required' => false)),
      'lithology_parent_ref'                          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LithologyParent'), 'column' => 'id')),
      'mineral_ref'                                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mineralogy'), 'column' => 'id')),
      'mineral_name'                                  => new sfValidatorPass(array('required' => false)),
      'mineral_name_indexed'                          => new sfValidatorPass(array('required' => false)),
      'mineral_name_order_by'                         => new sfValidatorPass(array('required' => false)),
      'mineral_level_ref'                             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MineralogyLevel'), 'column' => 'id')),
      'mineral_level_name'                            => new sfValidatorPass(array('required' => false)),
      'mineral_status'                                => new sfValidatorPass(array('required' => false)),
      'mineral_path'                                  => new sfValidatorPass(array('required' => false)),
      'mineral_parent_ref'                            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MineralogyParent'), 'column' => 'id')),
      'host_taxon_ref'                                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HostTaxon'), 'column' => 'id')),
      'host_relationship'                             => new sfValidatorPass(array('required' => false)),
      'host_taxon_name'                               => new sfValidatorPass(array('required' => false)),
      'host_taxon_name_indexed'                       => new sfValidatorPass(array('required' => false)),
      'host_taxon_name_order_by'                      => new sfValidatorPass(array('required' => false)),
      'host_taxon_level_ref'                          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HostTaxonLevel'), 'column' => 'id')),
      'host_taxon_level_name'                         => new sfValidatorPass(array('required' => false)),
      'host_taxon_status'                             => new sfValidatorPass(array('required' => false)),
      'host_taxon_path'                               => new sfValidatorPass(array('required' => false)),
      'host_taxon_parent_ref'                         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HostTaxonParent'), 'column' => 'id')),
      'host_taxon_extinct'                            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ig_ref'                                        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ig'), 'column' => 'id')),
      'ig_num'                                        => new sfValidatorPass(array('required' => false)),
      'ig_num_indexed'                                => new sfValidatorPass(array('required' => false)),
      'ig_date_mask'                                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ig_date'                                       => new sfValidatorPass(array('required' => false)),
      'acquisition_category'                          => new sfValidatorPass(array('required' => false)),
      'acquisition_date_mask'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'acquisition_date'                              => new sfValidatorPass(array('required' => false)),
      'specimen_count_min'                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'specimen_count_max'                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'individual_type'                               => new sfValidatorPass(array('required' => false)),
      'individual_type_group'                         => new sfValidatorPass(array('required' => false)),
      'individual_type_search'                        => new sfValidatorPass(array('required' => false)),
      'individual_sex'                                => new sfValidatorPass(array('required' => false)),
      'individual_state'                              => new sfValidatorPass(array('required' => false)),
      'individual_stage'                              => new sfValidatorPass(array('required' => false)),
      'individual_social_status'                      => new sfValidatorPass(array('required' => false)),
      'individual_rock_form'                          => new sfValidatorPass(array('required' => false)),
      'individual_count_min'                          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'individual_count_max'                          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'part'                                          => new sfValidatorPass(array('required' => false)),
      'part_status'                                   => new sfValidatorPass(array('required' => false)),
      'building'                                      => new sfValidatorPass(array('required' => false)),
      'floor'                                         => new sfValidatorPass(array('required' => false)),
      'room'                                          => new sfValidatorPass(array('required' => false)),
      'row'                                           => new sfValidatorPass(array('required' => false)),
      'shelf'                                         => new sfValidatorPass(array('required' => false)),
      'container_type'                                => new sfValidatorPass(array('required' => false)),
      'container_storage'                             => new sfValidatorPass(array('required' => false)),
      'container'                                     => new sfValidatorPass(array('required' => false)),
      'sub_container_type'                            => new sfValidatorPass(array('required' => false)),
      'sub_container_storage'                         => new sfValidatorPass(array('required' => false)),
      'sub_container'                                 => new sfValidatorPass(array('required' => false)),
      'part_count_min'                                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'part_count_max'                                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('part_search_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartSearch';
  }

  public function getFields()
  {
    return array(
      'id'                                            => 'Number',
      'spec_ref'                                      => 'Number',
      'category'                                      => 'Text',
      'collection_ref'                                => 'ForeignKey',
      'collection_type'                               => 'Text',
      'collection_code'                               => 'Text',
      'collection_name'                               => 'Text',
      'collection_is_public'                          => 'Boolean',
      'collection_institution_ref'                    => 'ForeignKey',
      'collection_institution_formated_name'          => 'Text',
      'collection_institution_formated_name_ts'       => 'Text',
      'collection_institution_formated_name_indexed'  => 'Text',
      'collection_institution_sub_type'               => 'Text',
      'collection_main_manager_ref'                   => 'ForeignKey',
      'collection_main_manager_formated_name'         => 'Text',
      'collection_main_manager_formated_name_ts'      => 'Text',
      'collection_main_manager_formated_name_indexed' => 'Text',
      'collection_parent_ref'                         => 'ForeignKey',
      'collection_path'                               => 'Text',
      'expedition_ref'                                => 'ForeignKey',
      'expedition_name'                               => 'Text',
      'expedition_name_ts'                            => 'Text',
      'expedition_name_indexed'                       => 'Text',
      'station_visible'                               => 'Boolean',
      'gtu_ref'                                       => 'ForeignKey',
      'gtu_code'                                      => 'Text',
      'gtu_parent_ref'                                => 'ForeignKey',
      'gtu_path'                                      => 'Text',
      'gtu_from_date_mask'                            => 'Number',
      'gtu_from_date'                                 => 'Text',
      'gtu_to_date_mask'                              => 'Number',
      'gtu_to_date'                                   => 'Text',
      'gtu_tag_values_indexed'                        => 'Text',
      'gtu_country_tag_value'                         => 'Text',
      'taxon_ref'                                     => 'ForeignKey',
      'taxon_name'                                    => 'Text',
      'taxon_name_indexed'                            => 'Text',
      'taxon_name_order_by'                           => 'Text',
      'taxon_level_ref'                               => 'ForeignKey',
      'taxon_level_name'                              => 'Text',
      'taxon_status'                                  => 'Text',
      'taxon_path'                                    => 'Text',
      'taxon_parent_ref'                              => 'ForeignKey',
      'taxon_extinct'                                 => 'Boolean',
      'litho_ref'                                     => 'ForeignKey',
      'litho_name'                                    => 'Text',
      'litho_name_indexed'                            => 'Text',
      'litho_name_order_by'                           => 'Text',
      'litho_level_ref'                               => 'ForeignKey',
      'litho_level_name'                              => 'Text',
      'litho_status'                                  => 'Text',
      'litho_path'                                    => 'Text',
      'litho_parent_ref'                              => 'ForeignKey',
      'chrono_ref'                                    => 'ForeignKey',
      'chrono_name'                                   => 'Text',
      'chrono_name_indexed'                           => 'Text',
      'chrono_name_order_by'                          => 'Text',
      'chrono_level_ref'                              => 'ForeignKey',
      'chrono_level_name'                             => 'Text',
      'chrono_status'                                 => 'Text',
      'chrono_path'                                   => 'Text',
      'chrono_parent_ref'                             => 'ForeignKey',
      'lithology_ref'                                 => 'ForeignKey',
      'lithology_name'                                => 'Text',
      'lithology_name_indexed'                        => 'Text',
      'lithology_name_order_by'                       => 'Text',
      'lithology_level_ref'                           => 'ForeignKey',
      'lithology_level_name'                          => 'Text',
      'lithology_status'                              => 'Text',
      'lithology_path'                                => 'Text',
      'lithology_parent_ref'                          => 'ForeignKey',
      'mineral_ref'                                   => 'ForeignKey',
      'mineral_name'                                  => 'Text',
      'mineral_name_indexed'                          => 'Text',
      'mineral_name_order_by'                         => 'Text',
      'mineral_level_ref'                             => 'ForeignKey',
      'mineral_level_name'                            => 'Text',
      'mineral_status'                                => 'Text',
      'mineral_path'                                  => 'Text',
      'mineral_parent_ref'                            => 'ForeignKey',
      'host_taxon_ref'                                => 'ForeignKey',
      'host_relationship'                             => 'Text',
      'host_taxon_name'                               => 'Text',
      'host_taxon_name_indexed'                       => 'Text',
      'host_taxon_name_order_by'                      => 'Text',
      'host_taxon_level_ref'                          => 'ForeignKey',
      'host_taxon_level_name'                         => 'Text',
      'host_taxon_status'                             => 'Text',
      'host_taxon_path'                               => 'Text',
      'host_taxon_parent_ref'                         => 'ForeignKey',
      'host_taxon_extinct'                            => 'Boolean',
      'ig_ref'                                        => 'ForeignKey',
      'ig_num'                                        => 'Text',
      'ig_num_indexed'                                => 'Text',
      'ig_date_mask'                                  => 'Number',
      'ig_date'                                       => 'Text',
      'acquisition_category'                          => 'Text',
      'acquisition_date_mask'                         => 'Number',
      'acquisition_date'                              => 'Text',
      'specimen_count_min'                            => 'Number',
      'specimen_count_max'                            => 'Number',
      'individual_ref'                                => 'Number',
      'individual_type'                               => 'Text',
      'individual_type_group'                         => 'Text',
      'individual_type_search'                        => 'Text',
      'individual_sex'                                => 'Text',
      'individual_state'                              => 'Text',
      'individual_stage'                              => 'Text',
      'individual_social_status'                      => 'Text',
      'individual_rock_form'                          => 'Text',
      'individual_count_min'                          => 'Number',
      'individual_count_max'                          => 'Number',
      'part_ref'                                      => 'Number',
      'part'                                          => 'Text',
      'part_status'                                   => 'Text',
      'building'                                      => 'Text',
      'floor'                                         => 'Text',
      'room'                                          => 'Text',
      'row'                                           => 'Text',
      'shelf'                                         => 'Text',
      'container_type'                                => 'Text',
      'container_storage'                             => 'Text',
      'container'                                     => 'Text',
      'sub_container_type'                            => 'Text',
      'sub_container_storage'                         => 'Text',
      'sub_container'                                 => 'Text',
      'part_count_min'                                => 'Number',
      'part_count_max'                                => 'Number',
    );
  }
}
