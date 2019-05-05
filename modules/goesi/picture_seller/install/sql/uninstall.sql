--liste
DROP TABLE `goesi_pic_seller_config`;

-- settings
SET @iCategId = (SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'Picture Seller' LIMIT 1);
--DELETE FROM `sys_options` WHERE `kateg` = @iCategId;
DELETE FROM `sys_options_cats` WHERE `ID` = @iCategId;
DELETE FROM `sys_options` WHERE `Name` = 'goesi_picture_seller_permalinks';

-- permalinks
DELETE FROM `sys_permalinks` WHERE `standard` = 'modules/?r=picture_seller/';

-- admin menu
DELETE FROM `sys_menu_admin` WHERE `name` = 'goesi_pic_seller';

-- top menu
DELETE FROM `sys_menu_top`WHERE `Link`='m/picture_seller/';

-- user menu
DELETE FROM `sys_menu_member` WHERE `Name`='PicSellerMember';