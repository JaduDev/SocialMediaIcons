/*
  Create the Social Media Icons database table to store our links in
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `CustomSocialMedia`
-- ----------------------------
DROP TABLE IF EXISTS `CustomSocialMedia`;
CREATE TABLE `CustomSocialMedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `url_facebook` text,
  `url_twitter` text,
  `url_vimeo` text,
  `url_youtube` text,
  `url_googleplus` text,
  `url_linkedin` text,
  `url_wordpress` text,
  `url_blogspot` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
