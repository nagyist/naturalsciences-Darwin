\unset ECHO
\i unit_launch.sql
SELECT plan(3);

SELECT diag('Check institution_ref is a institution');
SELECT throws_ok('insert into collections (id, code, name, institution_ref, main_manager_ref, parent_ref, path, code_auto_increment, code_part_code_auto_copy) VALUES ( 4, ''test'', ''test'', 2, 1, 1, ''1'', true, true)');
SELECT lives_ok('insert into collections (id, code, name, institution_ref, main_manager_ref, parent_ref, path, code_auto_increment, code_part_code_auto_copy) VALUES ( 5, ''tests'', ''tests'', 1, 1, 1, ''1'', true, true)','Add collection with good institution');
SELECT ok(1 = (SELECT count(*) FROM collections_admin WHERE user_ref = 1 AND collection_ref = 5));
SELECT * FROM finish();
ROLLBACK;
