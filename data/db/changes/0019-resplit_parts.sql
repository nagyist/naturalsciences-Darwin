﻿begin;

ALTER TABLE specimen_parts DISABLE TRIGGER trg_cpy_specimensmaincode_specimenpartcode;

CREATE OR REPLACE FUNCTION convert_to_real(v_input varchar) RETURNS REAL IMMUTABLE
AS $$
DECLARE v_int_value REAL DEFAULT 0;
BEGIN
    BEGIN
        v_int_value := v_input::REAL;
    EXCEPTION WHEN OTHERS THEN
/*        RAISE NOTICE 'Invalid integer value: "%".  Returning NULL.', v_input;*/
        RETURN 0;
    END;
RETURN v_int_value;
END;
$$ LANGUAGE plpgsql;

CREATE TYPE recPartsDetail AS (
                                specimen_individual_ref integer,  
                                parts_id bigint, 
                                main_code varchar, 
                                rbins_code varchar, 
                                batch_main_code varchar, 
                                inventory_code varchar,
                                old_main_code varchar,
                                specimen_part varchar, 
                                building varchar, 
                                coalesced_building varchar, 
                                "floor" varchar, 
                                coalesced_floor varchar, 
                                room varchar, 
                                coalesced_room varchar,
                                "row" varchar, 
                                coalesced_row varchar,  
                                shelf varchar, 
                                coalesced_shelf varchar, 
                                container varchar, 
                                coalesced_container varchar, 
                                sub_container varchar, 
                                coalesced_sub_container varchar, 
                                container_and_sub_container_type varchar, 
                                container_type varchar, 
                                sub_container_type varchar,
                                container_and_sub_container_storage varchar, 
                                container_storage varchar, 
                                sub_container_storage varchar,
                                specimen_status varchar, 
                                part_count_min bigint,
                                specimen_part_count_min integer,
                                specimen_part_count_max integer,
                                complete boolean,
                                freshness_level varchar,
                                old_length_min varchar,
                                old_length_min_unified varchar,
                                old_length_max varchar,
                                old_length_max_unified varchar,
                                old_length_unit varchar,
                                old_height_min varchar,
                                old_height_min_unified varchar,
                                old_height_max varchar,
                                old_height_max_unified varchar,
                                old_height_unit varchar,
                                old_depth_min varchar,
                                old_depth_min_unified varchar,
                                old_depth_max varchar,
                                old_depth_max_unified varchar,
                                old_depth_unit varchar,
                                old_weight_min varchar,
                                old_weight_min_unified varchar,
                                old_weight_max varchar,
                                old_weight_max_unified varchar,
                                old_weight_unit varchar
                              );

create or replace function decrementCount(IN partId specimen_parts.id%TYPE, IN decrementVal bigint) RETURNS boolean language plpgsql AS
$$
declare
  result boolean := true;
begin
  UPDATE specimen_parts
  SET specimen_part_count_min = case when specimen_part_count_min = 1 then specimen_part_count_min else specimen_part_count_min - decrementVal end,
      specimen_part_count_max = case when specimen_part_count_max = 1 then specimen_part_count_max else specimen_part_count_max - decrementVal end
  WHERE id = partId;
  return result;
exception when others then
  RAISE WARNING 'Error in decrementCount: %', SQLERRM;
  return false;
end;
$$;

create or replace function createCodes(IN new_part_id specimen_parts.id%TYPE, IN codeToSplit varchar) returns integer language plpgsql AS
$$
declare
  codes_prefix varchar;
  codes_prefix_separator varchar;
  code_to_insert varchar;
  codes_suffix_separator varchar;
  codes_suffix varchar;
  response integer := 0;
begin
  IF codeToSplit = 'A.193' THEN
    codes_prefix := 'A';
    codes_prefix_separator := '.';
    code_to_insert:= '193';
  ELSIF codeToSplit = 'A/G/26' THEN
    codes_prefix := 'A/G';
    codes_prefix_separator := '/';
    code_to_insert:= '26';
  ELSIF codeToSplit = 'A.G306' THEN
    codes_prefix := 'A';
    codes_prefix_separator := '.';
    code_to_insert:= 'G306';
  ELSIF codeToSplit = 'HIOL.1054' THEN
    codes_prefix := 'HOL';
    codes_prefix_separator := '.';
    code_to_insert:= '1054';
  ELSIF codeToSplit = 'IINV.62442' THEN
    codes_prefix := 'INV';
    codes_prefix_separator := '.';
    code_to_insert:= '62442';
  ELSIF codeToSplit = 'IN16124' THEN
    codes_prefix := 'INV';
    codes_prefix_separator := '.';
    code_to_insert:= '16124';
  ELSIF codeToSplit = 'IV.17792' THEN
    codes_prefix := 'INV';
    codes_prefix_separator := '.';
    code_to_insert:= '17792';
  ELSIF codeToSplit = 'IV.84836' THEN
    codes_prefix := 'INV';
    codes_prefix_separator := '.';
    code_to_insert:= '84836';
  ELSIF codeToSplit = 'T1987' THEN
    codes_prefix := 'T';
    codes_prefix_separator := '.';
    code_to_insert:= '1987';
  ELSIF codeToSplit = 'V.78427' THEN
    codes_prefix := 'V';
    codes_prefix_separator := '.';
    code_to_insert:= '78427';
  ELSIF substr(codeToSplit, 1, 4) IN ('AST.', 'CRI.', 'HOL.', 'INV.', 'NIV.', 'OPH.', 'POP.') THEN
    codes_prefix := substr(codeToSplit, 1, 3);
    codes_prefix_separator := '.';
    IF length(codeToSplit) > 4 THEN
      code_to_insert:= substr(codeToSplit, 5);
    END IF;
  ELSIF substr(codeToSplit, 1, 3) ='IN.' THEN
    codes_prefix := 'INV';
    codes_prefix_separator := '.';
    IF length(codeToSplit) > 3 THEN
      code_to_insert:= substr(codeToSplit, 4);
    END IF;
  ELSIF substr(codeToSplit, 1, 5) = 'HIST.' THEN
    codes_prefix := 'HIST';
    codes_prefix_separator := '.';
    IF length(codeToSplit) > 5 THEN
      code_to_insert:= substr(codeToSplit, 6);
    END IF;
  ELSIF substr(codeToSplit, 1, 6) = 'KREPS.' THEN
    codes_prefix := 'KREPS';
    codes_prefix_separator := '.';
    IF length(codeToSplit) > 6 THEN
      code_to_insert:= substr(codeToSplit, 7);
    END IF;
  ELSIF codeToSplit ~ E'^[PRT]\\s{1,2}\\d+\\s{1}\\w+\\W+\\w+$' THEN
    codes_prefix := substr(codeToSplit, 1, 1);
    codes_prefix_separator := ' ';
    code_to_insert:= trim(substring(trim(substr(codeToSplit, 2)) from E'^\\d+\\s{1}'));
    codes_suffix_separator := ' ';
    codes_suffix := substring(codeToSplit from E'\\w+\\W+\\w+$');
  ELSIF codeToSplit Like 'ALEX %' THEN
    code_to_insert:= codeToSplit;
  ELSE
    return response;
  END IF;
  INSERT INTO codes
  (referenced_relation, record_id, code_category, "code_prefix", "code_prefix_separator", "code", "code_suffix", "code_suffix_separator")
  VALUES
  ('specimen_parts', new_part_id, 'main', codes_prefix, codes_prefix_separator, code_to_insert, codes_suffix, codes_suffix_separator);
  GET DIAGNOSTICS response := ROW_COUNT;
  return response;
exception
  when others then
    RAISE WARNING 'Error in createCodes: %', SQLERRM;
    return -1;
end;
$$;

create or replace function checkAndCreateProperties(IN part_id specimen_parts.id%TYPE, IN new_part_id specimen_parts.id%TYPE, IN recPartsDetails recPartsDetail) RETURNS  integer language plpgsql
AS
$$
declare
begin
  return 1;
EXCEPTION
  WHEN OTHERS THEN
    RAISE WARNING 'Error in checkAndCreateProperties: %', SQLERRM;
    return -1;
end;
$$;

create or replace function createNewPart(IN part_id specimen_parts.id%TYPE, IN recPartsDetails recPartsDetail) RETURNS specimen_parts.id%TYPE language plpgsql AS
$$
DECLARE  
  new_part_id specimen_parts.id%TYPE;
  recProperties RECORD;
  code_count integer;
BEGIN
  INSERT INTO specimen_parts
  (parent_ref, path, specimen_individual_ref, specimen_part, complete,
    building, "floor", room, "row", shelf, "container", sub_container, container_type, sub_container_type, container_storage, sub_container_storage, 
    surnumerary, specimen_status, specimen_part_count_min, specimen_part_count_max, institution_ref
  )
  (
    SELECT parent_ref, path, specimen_individual_ref, specimen_part, complete, 
          building, "floor", room, "row", shelf, "container", sub_container, container_type, sub_container_type, container_storage, sub_container_storage,
          surnumerary, specimen_status, recPartsDetails.part_count_min, recPartsDetails.part_count_min, institution_ref
    FROM specimen_parts 
    WHERE id = part_id
  )
  RETURNING id INTO new_part_id;
  if decrementCount(part_id, recPartsDetails.part_count_min) then
  end if;
  SELECT count(full_code_order_by) INTO code_count
  FROM codes
  WHERE referenced_relation = 'specimen_parts'
    AND code_category = 'main'
    AND record_id = part_id;
  IF code_count > 1 THEN
    UPDATE codes
    SET record_id = new_part_id
    WHERE referenced_relation = 'specimen_parts'
      AND record_id = part_id
      AND code_category = 'main'
      AND full_code_order_by IN (recPartsDetails.main_code, recPartsDetails.rbins_code, recPartsDetails.inventory_code, recPartsDetails.batch_main_code);
    GET DIAGNOSTICS code_count = ROW_COUNT;
    IF code_count = 0 THEN
      IF createCodes (new_part_id, recPartsDetails.main_code) < 0 THEN
        return -1;
      END IF;
    END IF;
  ELSIF code_count = 1 THEN
    INSERT INTO codes
    (referenced_relation, record_id, code_category, code_prefix, code_prefix_separator, code, code_suffix, code_suffix_separator, code_date, code_date_mask)
    (SELECT 'specimen_parts', new_part_id, code_category, code_prefix, code_prefix_separator, code, code_suffix, code_suffix_separator, code_date, code_date_mask
     FROM codes
     WHERE referenced_relation = 'specimen_parts'
       AND record_id = part_id
       AND code_category = 'main'
       AND full_code_order_by IN (recPartsDetails.main_code, recPartsDetails.rbins_code, recPartsDetails.inventory_code, recPartsDetails.batch_main_code)
    );
    GET DIAGNOSTICS code_count = ROW_COUNT;
    IF code_count = 0 THEN
      IF createCodes (new_part_id, recPartsDetails.old_main_code) < 0 THEN
        return -1;
      END IF;
    END IF;
  ELSE
    IF createCodes (new_part_id, recPartsDetails.old_main_code) < 0 THEN
      return -1;
    END IF;
  END IF;
  /* Comments are not treated: only two are in identifiable corresponding old parts, but do not need to be splitted*/
  SELECT array_agg(property_value) 
  INTO recProperties
  FROM catalogue_properties inner join properties_values on catalogue_properties.id = property_ref
  WHERE referenced_relation = 'specimen_parts'
    AND record_id = part_id;
  RAISE NOTICE '+++ Properties before transfert: %', recProperties;
  IF checkAndCreateProperties(part_id, new_part_id, recPartsDetails) < 0 THEN
    return -1;
  END IF;
  SELECT array_agg(property_value) 
  INTO recProperties
  FROM catalogue_properties inner join properties_values on catalogue_properties.id = property_ref
  WHERE referenced_relation = 'specimen_parts'
    AND record_id = part_id;
  RAISE NOTICE '+++ Properties after transfert: %', recProperties;
  SELECT array_agg(property_value) 
  INTO recProperties
  FROM catalogue_properties inner join properties_values on catalogue_properties.id = property_ref
  WHERE referenced_relation = 'specimen_parts'
    AND record_id = new_part_id;
  RAISE NOTICE '+++ Properties after transfert for new part: %', recProperties;
  return new_part_id;
EXCEPTION
  WHEN OTHERS THEN
    RAISE WARNING 'Error: %', SQLERRM;
    return -1;
END;
$$;

create or replace function createProperties (IN part_id specimen_parts.id%TYPE, recPartsDetails recPartsDetail) returns integer language plpgsql AS
$$
declare
  prop_id integer;
begin
  /*Freshness level*/
  IF recPartsDetails.freshness_level IS NOT NULL THEN
    insert into catalogue_properties (referenced_relation, record_id, property_type, property_sub_type)
    (
      select 'specimen_parts', part_id, 'part state', 'freshness level'
      where not exists (
                          select 1
                          from catalogue_properties
                          where referenced_relation = 'specimen_parts'
                            and record_id = part_id
                            and property_type = 'part state'
                            and property_sub_type = 'freshness level'
                        )
    );
    select id into prop_id from catalogue_properties where referenced_relation = 'specimen_parts' and record_id = part_id and property_type = 'part state' and property_sub_type = 'freshness level';
    insert into properties_values (property_ref, property_value)
    (
      select prop_id, recPartsDetails.freshness_level
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value = recPartsDetails.freshness_level
                        )
    );
  END IF;
  /*Length level*/
  IF coalesce(recPartsDetails.old_length_min,'') != '' OR coalesce(recPartsDetails.old_length_max,'') != '' THEN
    insert into catalogue_properties (referenced_relation, record_id, property_type, property_sub_type, property_qualifier, property_unit, property_accuracy_unit)
    (
      select 'specimen_parts', part_id, 'physical measurement', 'length', NULL, recPartsDetails.old_length_unit, recPartsDetails.old_length_unit
      where not exists (
                          select 1
                          from catalogue_properties
                          where referenced_relation = 'specimen_parts'
                            and record_id = part_id
                            and property_type = 'physical measurement'
                            and property_sub_type = 'length'
                            and coalesce(property_qualifier, '') = ''
                        )
    );
    select id into prop_id from catalogue_properties where referenced_relation = 'specimen_parts' and record_id = part_id and property_type = 'physical measurement' and property_sub_type = 'length' and coalesce(property_qualifier, '') = '';
    insert into properties_values (property_ref, property_value)
    (
      select prop_id, recPartsDetails.old_length_min
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_length_min_unified
                        )
        and coalesce(recPartsDetails.old_length_min, '') != ''
      union
      select prop_id, recPartsDetails.old_length_max
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_length_max_unified
                        )
        and coalesce(recPartsDetails.old_length_max, '') != ''
    );
  END IF;
  /*Height level*/
  IF coalesce(recPartsDetails.old_height_min,'') != '' OR coalesce(recPartsDetails.old_height_max,'') != '' THEN
    insert into catalogue_properties (referenced_relation, record_id, property_type, property_sub_type, property_qualifier, property_unit, property_accuracy_unit)
    (
      select 'specimen_parts', part_id, 'physical measurement', 'length', 'height', recPartsDetails.old_height_unit, recPartsDetails.old_height_unit
      where not exists (
                          select 1
                          from catalogue_properties
                          where referenced_relation = 'specimen_parts'
                            and record_id = part_id
                            and property_type = 'physical measurement'
                            and property_sub_type = 'length'
                            and property_qualifier = 'height'
                        )
    );
    select id into prop_id from catalogue_properties where referenced_relation = 'specimen_parts' and record_id = part_id and property_type = 'physical measurement' and property_sub_type = 'length' and property_qualifier = 'height';
    insert into properties_values (property_ref, property_value)
    (
      select prop_id, recPartsDetails.old_height_min
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_height_min_unified
                        )
        and coalesce(recPartsDetails.old_height_min, '') != ''
      union
      select prop_id, recPartsDetails.old_height_max
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_height_max_unified
                        )
        and coalesce(recPartsDetails.old_height_max, '') != ''
    );
  END IF;
  /*Depth level*/
  IF coalesce(recPartsDetails.old_depth_min,'') != '' OR coalesce(recPartsDetails.old_depth_max,'') != '' THEN
    insert into catalogue_properties (referenced_relation, record_id, property_type, property_sub_type, property_qualifier, property_unit, property_accuracy_unit)
    (
      select 'specimen_parts', part_id, 'physical measurement', 'length', 'depth', recPartsDetails.old_depth_unit, recPartsDetails.old_depth_unit
      where not exists (
                          select 1
                          from catalogue_properties
                          where referenced_relation = 'specimen_parts'
                            and record_id = part_id
                            and property_type = 'physical measurement'
                            and property_sub_type = 'length'
                            and property_qualifier = 'depth'
                        )
    );
    select id into prop_id from catalogue_properties where referenced_relation = 'specimen_parts' and record_id = part_id and property_type = 'physical measurement' and property_sub_type = 'length' and property_qualifier = 'depth';
    insert into properties_values (property_ref, property_value)
    (
      select prop_id, recPartsDetails.old_depth_min
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_depth_min_unified
                        )
        and coalesce(recPartsDetails.old_depth_min, '') != ''
      union
      select prop_id, recPartsDetails.old_depth_max
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_depth_max_unified
                        )
        and coalesce(recPartsDetails.old_depth_max, '') != ''
    );
  END IF;
  /*Weight level*/
  IF coalesce(recPartsDetails.old_weight_min,'') != '' OR coalesce(recPartsDetails.old_weight_max,'') != '' THEN
    insert into catalogue_properties (referenced_relation, record_id, property_type, property_sub_type, property_qualifier, property_unit, property_accuracy_unit)
    (
      select 'specimen_parts', part_id, 'physical measurement', 'weight', NULL, recPartsDetails.old_weight_unit, recPartsDetails.old_weight_unit
      where not exists (
                          select 1
                          from catalogue_properties
                          where referenced_relation = 'specimen_parts'
                            and record_id = part_id
                            and property_type = 'physical measurement'
                            and property_sub_type = 'weight'
                        )
    );
    select id into prop_id from catalogue_properties where referenced_relation = 'specimen_parts' and record_id = part_id and property_type = 'physical measurement' and property_sub_type = 'weight';
    insert into properties_values (property_ref, property_value)
    (
      select prop_id, recPartsDetails.old_weight_min
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_weight_min_unified
                        )
        and coalesce(recPartsDetails.old_weight_min, '') != ''
      union
      select prop_id, recPartsDetails.old_weight_max
      where not exists (
                          select 1
                          from properties_values
                          where property_ref = prop_id
                            and property_value_unified = recPartsDetails.old_weight_max_unified
                        )
        and coalesce(recPartsDetails.old_weight_max, '') != ''
    );
  END IF;
  return 1;
exception
  when others then
    RAISE WARNING 'Error in createProperties: %', SQLERRM;
    return -1;
end;
$$;

drop function if exists resplit_parts();
create or replace function resplit_parts () returns boolean language plpgsql as
$$
declare
  recPartsDetails recPartsDetail;
  part_id specimen_parts.id%TYPE := 0;
  new_part_id specimen_parts.id%TYPE;
  code_count integer;
  recActualCodes varchar[];
  recTransferedCodes varchar[];
  recPropertiesValues varchar[];
begin
  FOR recPartsDetails IN select specimen_individual_ref,  specimen_parts.id as parts_id, fullToIndex(sgr_code) as main_code, 
                                fullToIndex(bat_unique_rbins_code) as rbins_code, fullToIndex(bat_code) as batch_main_code, fullToIndex(bat_inventory_code) as inventory_code, sgr_code as old_main_code,
                                specimen_part, building, coalesce(building, '') as coalesced_building, 
                                "floor", coalesce("floor", '') as coalesced_floor, 
                                room, coalesce("room", '') as coalesced_room, 
                                specimen_parts.row as row, coalesce("row", '') as coalesced_row,  
                                specimen_parts.shelf as shelf, coalesce("shelf", '') as coalesced_shelf, 
                                specimen_parts.container as container, coalesce("container", '') as coalesced_container, 
                                specimen_parts.sub_container as sub_container, coalesce("sub_container", '') as coalesced_sub_container, 
                                lower(cty_type_short_descr) as container_and_sub_container_type, specimen_parts.container_type as container_type, specimen_parts.sub_container_type as sub_container_type,
                                lower(sto_storage) as container_and_sub_container_storage, specimen_parts.container_storage as container_storage, specimen_parts.sub_container_storage as sub_container_storage,
                                specimen_status, 
                                case when sgr_number_in_group < 1 or sgr_number_in_group is null then 1 else sgr_number_in_group end as part_count_min,
                                specimen_part_count_min,
                                specimen_part_count_max,
                                case 
                                  when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                                  else false 
                                end as complete,
                                case when sfl_description = 'Undefined' then null else sfl_description end as freshness_level,
                                sgr_length_min::varchar as old_length_min,
                                convert_to_unified(sgr_length_min::varchar, length_unit.uni_unit, 'length') as length_min_unified,
                                sgr_length_max::varchar as old_length_max,
                                convert_to_unified(sgr_length_max::varchar, length_unit.uni_unit, 'length') as length_max_unified,
                                length_unit.uni_unit as old_length_unit,
                                sgr_height_min::varchar as old_height_min,
                                convert_to_unified(sgr_height_min::varchar, height_unit.uni_unit, 'length') as height_min_unified,
                                sgr_height_max::varchar as old_height_max,
                                convert_to_unified(sgr_height_max::varchar, height_unit.uni_unit, 'length') as height_max_unified,
                                height_unit.uni_unit as old_height_unit,
                                sgr_depth_min::varchar as old_depth_min,
                                convert_to_unified(sgr_depth_min::varchar, depth_unit.uni_unit, 'length') as depth_min_unified,
                                sgr_depth_max::varchar as old_depth_max,
                                convert_to_unified(sgr_depth_max::varchar, depth_unit.uni_unit, 'length') as depth_max_unified,
                                depth_unit.uni_unit as old_depth_unit,
                                sgr_weight_min::varchar as old_weight_min,
                                convert_to_unified(sgr_weight_min::varchar, weight_unit.uni_unit, 'weight') as weight_min_unified,
                                sgr_weight_max::varchar as old_weight_max,
                                convert_to_unified(sgr_weight_max::varchar, weight_unit.uni_unit, 'weight') as weight_max_unified,
                                weight_unit.uni_unit as old_weight_unit
                          from darwin1.tbl_specimen_groups 
                          inner join darwin1.id_refs 
                          on sgr_id_ctn = old_id and system = 'individuals'
                          inner join (
                                        darwin1.tbl_rooms
                                        inner join (
                                                    darwin1.tbl_building_floors
                                                    inner join darwin1.tbl_buildings 
                                                    on bui_id_ctn = bfl_building_nr
                                                  )
                                        on bfl_id_ctn = rom_building_floor_nr
                                      )
                          on sgr_room_nr = rom_id_ctn
                          inner join darwin1.tbl_specimen_status 
                          on sst_id_ctn = sgr_status_nr
                          inner join darwin1.tbl_storage on sto_id_ctn = sgr_storage_nr
                          inner join darwin1.tbl_container_types on cty_id_ctn = sgr_container_type_nr
                          inner join darwin1.tbl_batches on sgr_batch_nr = bat_id_ctn
                          inner join darwin1.tbl_spec_freshness_levels on sfl_level = sgr_freshness_level_nr
                          inner join darwin1.tbl_units as length_unit on sgr_length_min_uni_nr = length_unit.uni_id_ctn
                          inner join darwin1.tbl_units as height_unit on sgr_height_min_uni_nr = height_unit.uni_id_ctn
                          inner join darwin1.tbl_units as depth_unit on sgr_depth_min_uni_nr = depth_unit.uni_id_ctn
                          inner join darwin1.tbl_units as weight_unit on sgr_weight_min_uni_nr = weight_unit.uni_id_ctn
                          inner join darwin1.tbl_units as vol_unit on sgr_vol_min_uni_nr = vol_unit.uni_id_ctn
                          inner join 
                          specimen_parts
                          on  specimen_individual_ref = new_id
                              and specimen_part = lower(replace(replace(replace(pit_item, 'Anat.', 'anatomic'), 'Microsc. prep.', 'microscopic preparation'), 'Microsc.prep.', 'microscopic preparation'))
                              and coalesce(specimen_parts.building,'') = 
                                  case 
                                    when sgr_room_nr = 0 then '' 
                                    else bui_name 
                                  end::varchar
                              and coalesce(specimen_parts.floor,'') = 
                                  case 
                                    when sgr_room_nr = 0 then '' 
                                    else bfl_floor 
                                  end::varchar
                              and coalesce(specimen_parts.room, '') = 
                                  case 
                                    when sgr_room_nr = 0 then '' 
                                    else rom_code 
                                  end::varchar
                              and coalesce(specimen_parts.row, '') = coalesce(sgr_row, '')
                              and coalesce(specimen_parts.shelf, '') = coalesce(sgr_shelf, '')
                              and coalesce(specimen_parts.container, '') = coalesce(sgr_container, '')
                              and coalesce(specimen_parts.sub_container, '') = coalesce(sgr_subcontainer, '')
                              and complete = 
                                  case 
                                    when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                                    else false 
                                  end
                          /*where bat_collection_id_nr between 1 and 8*/
                                /*where bat_collection_id_nr = 133*/
                          where sgr_length_min is not null or sgr_length_max is not null 
                          /*where sfl_description is not null and sfl_description != 'Undefined'*/
                                /*exists (select 1 from comments where comment is not null and referenced_relation = 'specimen_parts' and record_id = specimen_parts.id limit 1)*/
                          order by new_id desc, specimen_part, main_code 
                          limit 50
  LOOP
    IF part_id != recPartsDetails.parts_id THEN
      RAISE NOTICE 'Next part infos: %', recPartsDetails;
      part_id := recPartsDetails.parts_id;
      IF recPartsDetails.specimen_part_count_min = 0 AND recPartsDetails.part_count_min > 0 THEN
        IF recPartsDetails.specimen_part_count_max = recPartsDetails.specimen_part_count_min THEN
          UPDATE specimen_parts
          SET specimen_part_count_min = recPartsDetails.part_count_min,
              specimen_part_count_max = recPartsDetails.part_count_min
          WHERE id = part_id;
        ELSIF recPartsDetails.specimen_part_count_max >= recPartsDetails.part_count_min THEN
          UPDATE specimen_parts
          SET specimen_part_count_min = recPartsDetails.part_count_min
          WHERE id = part_id;
        END IF;
      END IF;
      SELECT count(full_code_order_by) INTO code_count
      FROM codes
      where referenced_relation = 'specimen_parts'
        and record_id = part_id
        and code_category = 'main';
      IF code_count != 0 then
        select count(full_code)
        into code_count
        from (
              select full_code_order_by as full_code
              from codes
              where referenced_relation = 'specimen_parts'
                and code_category = 'main'
                and record_id = part_id
              except
              (
                select fullToIndex(sgr_code) as full_code
                from darwin1.tbl_specimen_groups 
                inner join darwin1.id_refs on sgr_id_ctn = old_id and system = 'individuals'
                inner join (
                              darwin1.tbl_rooms
                              inner join (
                                          darwin1.tbl_building_floors
                                          inner join darwin1.tbl_buildings 
                                          on bui_id_ctn = bfl_building_nr
                                        )
                              on bfl_id_ctn = rom_building_floor_nr
                            )
                on sgr_room_nr = rom_id_ctn
                where new_id = recPartsDetails.specimen_individual_ref
                  and lower(replace(replace(replace(pit_item, 'Anat.', 'anatomic'), 'Microsc. prep.', 'microscopic preparation'), 'Microsc.prep.', 'microscopic preparation')) = recPartsDetails.specimen_part
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bui_name 
                      end::varchar = recPartsDetails.coalesced_building
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bfl_floor 
                      end::varchar = recPartsDetails.coalesced_floor
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else rom_code 
                      end::varchar = recPartsDetails.coalesced_room
                  and coalesce(sgr_row, '') = recPartsDetails.coalesced_row
                  and coalesce(sgr_shelf, '') = recPartsDetails.coalesced_shelf
                  and coalesce(sgr_container, '') = recPartsDetails.coalesced_container
                  and coalesce(sgr_subcontainer, '') = recPartsDetails.coalesced_sub_container
                  and case 
                        when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                        else false 
                      end = recPartsDetails.complete
                union
                select fullToIndex(bat_code) as full_code
                from darwin1.tbl_specimen_groups 
                inner join darwin1.id_refs on sgr_id_ctn = old_id and system = 'individuals'
                inner join (
                              darwin1.tbl_rooms
                              inner join (
                                          darwin1.tbl_building_floors
                                          inner join darwin1.tbl_buildings 
                                          on bui_id_ctn = bfl_building_nr
                                        )
                              on bfl_id_ctn = rom_building_floor_nr
                            )
                on sgr_room_nr = rom_id_ctn
                inner join darwin1.tbl_batches on sgr_batch_nr = bat_id_ctn
                where new_id = recPartsDetails.specimen_individual_ref
                  and lower(replace(replace(replace(pit_item, 'Anat.', 'anatomic'), 'Microsc. prep.', 'microscopic preparation'), 'Microsc.prep.', 'microscopic preparation')) = recPartsDetails.specimen_part
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bui_name 
                      end::varchar = recPartsDetails.coalesced_building
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bfl_floor 
                      end::varchar = recPartsDetails.coalesced_floor
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else rom_code 
                      end::varchar = recPartsDetails.coalesced_room
                  and coalesce(sgr_row, '') = recPartsDetails.coalesced_row
                  and coalesce(sgr_shelf, '') = recPartsDetails.coalesced_shelf
                  and coalesce(sgr_container, '') = recPartsDetails.coalesced_container
                  and coalesce(sgr_subcontainer, '') = recPartsDetails.coalesced_sub_container
                  and case 
                        when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                        else false 
                      end = recPartsDetails.complete
                union
                select fullToIndex(bat_unique_rbins_code) as full_code
                from darwin1.tbl_specimen_groups 
                inner join darwin1.id_refs on sgr_id_ctn = old_id and system = 'individuals'
                inner join (
                              darwin1.tbl_rooms
                              inner join (
                                          darwin1.tbl_building_floors
                                          inner join darwin1.tbl_buildings 
                                          on bui_id_ctn = bfl_building_nr
                                        )
                              on bfl_id_ctn = rom_building_floor_nr
                            )
                on sgr_room_nr = rom_id_ctn
                inner join darwin1.tbl_batches on sgr_batch_nr = bat_id_ctn
                where new_id = recPartsDetails.specimen_individual_ref
                  and lower(replace(replace(replace(pit_item, 'Anat.', 'anatomic'), 'Microsc. prep.', 'microscopic preparation'), 'Microsc.prep.', 'microscopic preparation')) = recPartsDetails.specimen_part
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bui_name 
                      end::varchar = recPartsDetails.coalesced_building
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bfl_floor 
                      end::varchar = recPartsDetails.coalesced_floor
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else rom_code 
                      end::varchar = recPartsDetails.coalesced_room
                  and coalesce(sgr_row, '') = recPartsDetails.coalesced_row
                  and coalesce(sgr_shelf, '') = recPartsDetails.coalesced_shelf
                  and coalesce(sgr_container, '') = recPartsDetails.coalesced_container
                  and coalesce(sgr_subcontainer, '') = recPartsDetails.coalesced_sub_container
                  and case 
                        when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                        else false 
                      end = recPartsDetails.complete
                union
                select fullToIndex(bat_inventory_code) as full_code
                from darwin1.tbl_specimen_groups 
                inner join darwin1.id_refs on sgr_id_ctn = old_id and system = 'individuals'
                inner join (
                              darwin1.tbl_rooms
                              inner join (
                                          darwin1.tbl_building_floors
                                          inner join darwin1.tbl_buildings 
                                          on bui_id_ctn = bfl_building_nr
                                        )
                              on bfl_id_ctn = rom_building_floor_nr
                            )
                on sgr_room_nr = rom_id_ctn
                inner join darwin1.tbl_batches on sgr_batch_nr = bat_id_ctn
                where new_id = recPartsDetails.specimen_individual_ref
                  and lower(replace(replace(replace(pit_item, 'Anat.', 'anatomic'), 'Microsc. prep.', 'microscopic preparation'), 'Microsc.prep.', 'microscopic preparation')) = recPartsDetails.specimen_part
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bui_name 
                      end::varchar = recPartsDetails.coalesced_building
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else bfl_floor 
                      end::varchar = recPartsDetails.coalesced_floor
                  and case 
                        when sgr_room_nr = 0 then '' 
                        else rom_code 
                      end::varchar = recPartsDetails.coalesced_room
                  and coalesce(sgr_row, '') = recPartsDetails.coalesced_row
                  and coalesce(sgr_shelf, '') = recPartsDetails.coalesced_shelf
                  and coalesce(sgr_container, '') = recPartsDetails.coalesced_container
                  and coalesce(sgr_subcontainer, '') = recPartsDetails.coalesced_sub_container
                  and case 
                        when sgr_item_concerned_nr in (20, 95, 136, 217, 218, 236, 336) then true 
                        else false 
                      end = recPartsDetails.complete
              ) 
            ) as x;
        IF code_count > 0 THEN
          RAISE NOTICE '+ Need of new part creation';
          SELECT createNewPart(part_id, recPartsDetails) INTO new_part_id;
          IF new_part_id < 0 THEN
            return false;
          END IF;
          select array_agg(coalesce(code_prefix, '') || case when code_prefix is null then '' else coalesce(code_prefix_separator, ' ') end || coalesce(code, '') || case when code_suffix is null then '' else coalesce(code_suffix_separator, ' ') end || coalesce(code_suffix, '')) into recActualCodes from codes where code_category = 'main' and referenced_relation = 'specimen_parts' and record_id = part_id;
          select array_agg(coalesce(code_prefix, '') || case when code_prefix is null then '' else coalesce(code_prefix_separator, ' ') end || coalesce(code, '') || case when code_suffix is null then '' else coalesce(code_suffix_separator, ' ') end || coalesce(code_suffix, '')) into recTransferedCodes from codes where code_category = 'main' and referenced_relation = 'specimen_parts' and record_id = new_part_id;
          RAISE NOTICE '++ Actual codes: %, Transfered codes: %', recActualCodes, recTransferedCodes;
        END IF;
      ELSE
        RAISE NOTICE '+ New code creation for next part';
        IF createCodes (part_id, recPartsDetails.old_main_code) < 0 THEN
          return false;
        END IF;
        select array_agg(coalesce(code_prefix, '') || case when code_prefix is null then '' else coalesce(code_prefix_separator, ' ') end || coalesce(code, '') || case when code_suffix is null then '' else coalesce(code_suffix_separator, ' ') end || coalesce(code_suffix, '')) into recActualCodes from codes where code_category = 'main' and referenced_relation = 'specimen_parts' and record_id = part_id;
        RAISE NOTICE '++ Actual codes: %', recActualCodes;
        IF createProperties (part_id, recPartsDetails) < 0 THEN
          return false;
        END IF;
        select array_agg(property_value)
        into recPropertiesValues
        from catalogue_properties inner join properties_values on catalogue_properties.id = properties_values.property_ref
        where referenced_relation = 'specimen_parts' and record_id = part_id;
        RAISE NOTICE '++ Actual properties: %', recPropertiesValues;
      END IF;
    ELSE
      RAISE NOTICE '- Same part id infos: %', recPartsDetails;
      SELECT createNewPart(part_id, recPartsDetails) INTO new_part_id;
      IF new_part_id < 0 THEN
        return false;
      END IF;
      select array_agg(coalesce(code_prefix, '') || case when code_prefix is null then '' else coalesce(code_prefix_separator, ' ') end || coalesce(code, '') || case when code_suffix is null then '' else coalesce(code_suffix_separator, ' ') end || coalesce(code_suffix, '')) into recActualCodes from codes where code_category = 'main' and referenced_relation = 'specimen_parts' and record_id = part_id;
      select array_agg(coalesce(code_prefix, '') || case when code_prefix is null then '' else coalesce(code_prefix_separator, ' ') end || coalesce(code, '') || case when code_suffix is null then '' else coalesce(code_suffix_separator, ' ') end || coalesce(code_suffix, '')) into recTransferedCodes from codes where code_category = 'main' and referenced_relation = 'specimen_parts' and record_id = new_part_id;
      RAISE NOTICE '-- Actual codes: %, Transfered codes: %', recActualCodes, recTransferedCodes;
    END IF;
  END LOOP;
  return true;
exception
  when others then
    RAISE WARNING 'Error in main function: %', SQLERRM;
end;
$$;

create or replace function split_parts() returns boolean language plpgsql
AS
$$
declare
  response boolean;
begin
  select resplit_parts() INTO response;
  IF NOT response THEN
    ROLLBACK;
  END IF;
  return response;
end;
$$;

SELECT split_parts();

DROP TYPE IF EXISTS recPartsDetail CASCADE;

ALTER TABLE specimen_parts ENABLE TRIGGER trg_cpy_specimensmaincode_specimenpartcode;

rollback;