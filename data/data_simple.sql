--
-- add type fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Article', 'article_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/article/api/list/0', 0, 1, 0, 'entitytag-single', 'OnePlace\\Article\\Model\\ArticleTable','add-OnePlace\\Article\\Controller\\ArticleController'),
(NULL, 'select', 'State', 'state_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/tag/api/list/task-single/state', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Request\\\\Controller\\StateController');


--
-- permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Request\\\\Controller\\StateController', 'Add State', '', '', 0);

