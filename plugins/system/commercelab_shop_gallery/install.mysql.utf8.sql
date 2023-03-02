CREATE TABLE IF NOT EXISTS `#__commercelab_shop_gallery` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`product_j_id` int(11) DEFAULT NULL,
	`path` text,
	`ordering` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
