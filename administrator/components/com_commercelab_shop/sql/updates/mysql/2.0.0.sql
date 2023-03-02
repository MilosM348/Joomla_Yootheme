
CREATE TABLE IF NOT EXISTS `#__commercelab_shop_product_variant` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `product_id` int(11) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `#__commercelab_shop_product_variant_data` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `product_id` int(11) DEFAULT NULL,
     `label_ids` varchar(255) DEFAULT NULL,
     `price` int(11) DEFAULT NULL,
     `stock` int(11) DEFAULT NULL,
     `sku` varchar(255) DEFAULT NULL,
     `active` tinyint(4) DEFAULT NULL,
     `default` tinyint(4) DEFAULT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `#__commercelab_shop_product_variant_label` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `variant_id` int(11) DEFAULT NULL,
    `product_id` int(11) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `#__commercelab_shop_cart_item`
(
    `id`              int(11) unsigned NOT NULL AUTO_INCREMENT,
    `cart_id`         int(11)          NOT NULL,
    `joomla_item_id`  int(11)                   DEFAULT NULL,
    `variant_id`      int(11)                   DEFAULT NULL,
    `item_options`    text,
    `bought_at_price` int(11)                   DEFAULT NULL,
    `added`           datetime         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `order_id`        int(11)                   DEFAULT NULL,
    `cookie_id`       int(11)                   DEFAULT NULL,
    `user_id`         int(11)                   DEFAULT NULL,
    `amount`          int(11)                   DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  ROW_FORMAT = DYNAMIC;