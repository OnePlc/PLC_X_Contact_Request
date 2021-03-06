--
-- add Core Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Article', 'article_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/article/api/list/0', 0, 1, 0, 'article-single', 'OnePlace\\Article\\Model\\ArticleTable','add-OnePlace\\Article\\Controller\\ArticleController'),
(NULL, 'select', 'State', 'state_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/tag/api/list/contactrequest-single/state', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Request\\\\Controller\\StateController');

--
-- add State Entities
--
INSERT INTO `core_entity_tag` (`Entitytag_ID`, `entity_form_idfs`, `tag_idfs`, `tag_value`, `parent_tag_idfs`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'contactrequest-single', (select `Tag_ID` from `core_tag` where `tag_key`='state'), 'new', '0', '1', '2020-01-01 00:00:00', '1', '2020-01-01 00:00:00'),
(NULL, 'contactrequest-single',  (select `Tag_ID` from `core_tag` where `tag_key`='state'), 'closed', '0', '1', '2020-01-01 00:00:00', '1', '2020-01-01 00:00:00');

--
-- permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Request\\\\Controller\\StateController', 'Add Request', '', '', 0),
('list', 'OnePlace\\Contact\\Request\\Controller\\ApiController', 'List', '', '', 1);

--
-- quicksearch fix
--
INSERT INTO `settings` (`settings_key`, `settings_value`) VALUES ('quicksearch-contactrequest-customlabel', 'message');