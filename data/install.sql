--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-request', 'contact-single', 'Requests', 'Recent Requests', 'fas fa-envelope', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Requests', 'contact_request', 'contact-request', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- create request table
--
CREATE TABLE `contact_request` (
  `Request_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_idfs` int(11) NOT NULL,
  `message` TEXT NOT NULL DEFAULT '',
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
('contactrequest-single', 'Contact Requests', 'OnePlace\\Contact\\Request\\Model\\Request', 'OnePlace\\Contact\\Request\\Model\\RequestTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('request-base', 'contactrequest-single', 'Requests', 'Recent Requests', 'fas fa-envelope', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Message', 'message', 'request-base', 'contactrequest-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Contact', 'contact_idfs', 'request-base', 'contactrequest-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');

--
-- permission add request
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Request\\Controller\\RequestController', 'Add Request', '', '', '0');