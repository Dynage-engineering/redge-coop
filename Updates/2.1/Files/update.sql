ALTER TABLE `general_settings` ADD `pn` tinyint(1) NOT NULL DEFAULT 0 AFTER `sn`;
ALTER TABLE `general_settings` ADD `push_configuration` text NULL AFTER `pn`;
ALTER TABLE `general_settings` CHANGE `percent_transfer_charge` `percent_transfer_charge` DECIMAL(5,2) NOT NULL DEFAULT '0';
ALTER TABLE `notification_templates` ADD `push_notification_body` text NULL AFTER `sms_body`;
ALTER TABLE `notification_templates` ADD `push_notification_status` tinyint(1) NOT NULL DEFAULT 1 AFTER `sms_status`;

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_app` tinyint(1) NOT NULL DEFAULT 0,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NULL,
  `remark` varchar(40) NULL,
  `click_value` varchar(255) NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;