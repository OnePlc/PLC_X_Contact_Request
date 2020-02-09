--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-request', 'contact-single', 'Request', 'Recent Contact', 'fas fa-request', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Request', 'contact_request', 'contact-request', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- add button
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Add Request', 'fas fa-request', 'Add Request', '/contact/request/add/##ID##', 'primary', '', 'contact-view', 'link', '', ''),
(NULL, 'Save Request', 'fas fa-save', 'Save Request', '#', 'primary saveForm', '', 'contactrequest-single', 'link', '', '');

--
-- create request table
--
CREATE TABLE `contact_request` (
  `Request_ID` int(11) NOT NULL,
  `contact_idfs` int(11) NOT NULL,
  `comment` TEXT NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `contact_request`
  ADD PRIMARY KEY (`Request_ID`);

ALTER TABLE `contact_request`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- add request form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contactrequest-single', 'Contact Request', 'OnePlace\\Contact\\Request\\Model\\Request', 'OnePlace\\Contact\\Request\\Model\\RequestTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('request-base', 'contactrequest-single', 'Request', 'Recent Contact', 'fas fa-request', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Comment', 'comment', 'request-base', 'contactrequest-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Contact', 'contact_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');

--
-- permission add request
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Request\\Controller\\RequestController', 'Add Request', '', '', '0');