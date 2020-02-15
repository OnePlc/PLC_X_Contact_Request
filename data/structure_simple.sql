ALTER TABLE `contact_request` ADD `article_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `contact_idfs`,
ADD `state_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `article_idfs`,
ADD `extra_fields` TEXT NOT NULL DEFAULT '' AFTER `state_idfs`;

