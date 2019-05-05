-- Setting Tabelle erstellen
CREATE TABLE IF NOT EXISTS `goesi_pic_seller_config` (
  `id` int(11) NOT NULL auto_increment,
  `option` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `goesi_pic_seller_config`
--

INSERT IGNORE INTO `goesi_pic_seller_config` (`id`, `option`, `value`) VALUES
(1, 'upload_group', '2'),
(2, 'auto_accept', 'true'),
(3, 'boonex_photos', 'true'),
(4, 'art_photos', 'false'),
(5, 'boonex_shop', 'true');

-- settings
SET @iMaxOrder = (SELECT `menu_order` + 1 FROM `sys_options_cats` ORDER BY `menu_order` DESC LIMIT 1);
INSERT INTO `sys_options_cats` (`name`, `menu_order`) VALUES ('Picture Seller', @iMaxOrder);

-- permalinks
INSERT INTO `sys_permalinks` VALUES (NULL, 'modules/?r=picture_seller/', 'm/picture_seller/', 'goesi_picture_seller_permalinks');

-- admin menu
SET @iMax = (SELECT MAX(`order`) FROM `sys_menu_admin` WHERE `parent_id` = '2');
INSERT IGNORE INTO `sys_menu_admin` (`parent_id`, `name`, `title`, `url`, `description`, `icon`, `order`) VALUES
(2, 'goesi_pic_seller', '_goesi_pic_seller', '{siteUrl}modules/?r=picture_seller/administration/', 'Picture Seller', 'modules/goesi/picture_seller/|icon.png', @iMax+1);

-- Add Top Menu
INSERT IGNORE INTO `sys_menu_top` (`Parent`, `Name`, `Caption`, `Link`, `Order`, `Visible`, `Target`, `Onclick`, `Check`, `Movable`, `Clonable`, `Editable`, `Deletable`, `Active`, `Type`, `Picture`, `Icon`, `BQuickLink`, `Statistics`) VALUES
(0, 'Sell Pictures', '_goesi_pic_seller_menu', 'm/picture_seller/', 1, 'non,memb', '', '', '', 3, 1, 1, 1, 1, 'top', 'modules/goesi/picture_seller/|sell_pictures.png', 'modules/goesi/picture_seller/|sell_pictures.png', 0, ''),
(0, 'Sell Pictures', '_goesi_pic_seller_menu', 'm/picture_seller/', 1, 'non,memb', '', '', '', 3, 1, 1, 1, 1, 'custom', 'modules/goesi/picture_seller/|sell_pictures.png', 'modules/goesi/picture_seller/|sell_pictures.png', 0, '');

-- Add Member Menu
INSERT IGNORE INTO `sys_menu_member` (`Caption`, `Name`, `Icon`, `Link`, `Script`, `Eval`, `PopupMenu`, `Order`, `Active`, `Movable`, `Clonable`, `Editable`, `Deletable`, `Target`, `Position`, `Type`, `Parent`, `Bubble`, `Description`) VALUES
('_goesi_pic_seller_member_menu', 'PicSellerMember', 'modules/goesi/picture_seller/|sell_pictures.png', 'm/store/home/', '', '', '', 0, '1', 3, 1, 1, 1, '', 'top', 'linked_item', 1, '', '_goesi_pic_seller_member_menu');
