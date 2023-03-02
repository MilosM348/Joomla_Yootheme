CREATE TABLE IF NOT EXISTS `#__commercelab_shop_shops` (
	`id` 				int(11) 		NOT NULL AUTO_INCREMENT,
	`joomla_item_id` 	int(11) 		,
	`published` 		tinyint(3)  	NOT NULL DEFAULT '1',
	`enablepickup` 		tinyint(3)  	NOT NULL DEFAULT '0',
	`enableordertime` 	tinyint(3)  	NOT NULL DEFAULT '0',
	`pickuptimes` 		text,
	`ordertimes` 		text,
	`workinghours` 		text,
	`timeframes` 		text,
	`products` 			text,
	`address` 			varchar(255) 	DEFAULT NULL,
	`city` 				varchar(255) 	DEFAULT NULL,
	`postalcode` 		varchar(255) 	DEFAULT NULL,
	`country` 			varchar(255) 	DEFAULT NULL,
	`zone` 				varchar(255) 	DEFAULT NULL,
	`image` 			text,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `#__commercelab_shop_product_preparation_time` (
	`product_id` 		int(11) DEFAULT NULL,
	`preparation_time` 	int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
