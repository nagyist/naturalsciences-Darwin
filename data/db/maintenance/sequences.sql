 select setval('staging_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.staging));
 select setval('catalogue_levels_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.catalogue_levels));
 select setval('catalogue_people_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.catalogue_people));
 select setval('catalogue_relationships_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.catalogue_relationships));
 select setval('associated_multimedia_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.associated_multimedia));
 select setval('class_vernacular_names_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.class_vernacular_names));
 select setval('classification_keywords_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.classification_keywords));
 select setval('classification_synonymies_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.classification_synonymies));
 select setval('collecting_methods_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.collecting_methods));
 select setval('collecting_tools_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.collecting_tools));
 select setval('collections_rights_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.collections_rights));
 select setval('collections_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.collections));
 select setval('classification_synonymies_group_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.classification_synonymies_group));
 select setval('comments_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.comments));
 select setval('chronostratigraphy_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.chronostratigraphy));
 select setval('flat_dict_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.flat_dict));
 select setval('habitats_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.habitats));
 select setval('igs_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.igs));
 select setval('imports_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.imports));
 select setval('insurances_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.insurances));
 select setval('gtu_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.gtu));
 select setval('identifications_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.identifications));
 select setval('lithology_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.lithology));
 select setval('lithostratigraphy_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.lithostratigraphy));
 select setval('ext_links_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.ext_links));
 select setval('expeditions_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.expeditions));
 select setval('multimedia_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.multimedia));
 select setval('my_saved_searches_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.my_saved_searches));
 select setval('people_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.people));
 select setval('people_addresses_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.people_addresses));
 select setval('my_widgets_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.my_widgets));
 select setval('people_comm_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.people_comm));
 select setval('mineralogy_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.mineralogy));
 select setval('properties_values_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.properties_values));
 select setval('specimen_collecting_methods_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimen_collecting_methods));
 select setval('people_relationships_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.people_relationships));
 select setval('specimen_collecting_tools_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimen_collecting_tools));
 select setval('specimen_individuals_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimen_individuals));
 select setval('preferences_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.preferences));
 select setval('specimens_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimens));
 select setval('specimens_accompanying_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimens_accompanying));
 select setval('staging_tag_groups_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.staging_tag_groups));
 select setval('users_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users));
 select setval('tag_groups_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.tag_groups));
 select setval('taxonomy_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.taxonomy));
 select setval('users_languages_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users_languages));
 select setval('users_addresses_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users_addresses));
 select setval('users_tracking_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users_tracking));
 select setval('users_comm_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users_comm));
 select setval('staging_people_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.staging_people));
 select setval('vernacular_names_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.vernacular_names));
 select setval('informative_workflow_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.informative_workflow));
 select setval('users_login_info_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.users_login_info));
 select setval('loans_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.loans));
 select setval('loan_items_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.loan_items));
 select setval('loan_status_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.loan_status));
 select setval('loan_rights_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.loan_rights));
 select setval('bibliography_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.bibliography));
 select setval('catalogue_bibliography_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.catalogue_bibliography));
 select setval('loan_history_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.loan_history));
 select setval('catalogue_properties_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.catalogue_properties));
 select setval('codes_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.codes));
 select setval('collection_maintenance_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.collection_maintenance));
 select setval('people_languages_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.people_languages));
 select setval('specimen_parts_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.specimen_parts));
 select setval('darwin_flat_id_seq'::regclass, (select case when max(id) = 0 then 1 else max(id) end from only darwin2.darwin_flat));

