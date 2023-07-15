-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2023 at 10:35 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `viserlab_viserbank_blank`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '635cd87f0fdb61667029119.png', '$2y$10$el35r0DVW8rbSEx0xm5xDu5IsbxmiaA1CZe3tfeub4iA4HxD1QSxq', 'iGGWs5rXL3E0yo5J5ylHJ2JJa2eUqMiVOCPuKl2Ot8hpg4uZpXasWqPOxT2t', NULL, '2022-10-29 07:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_branch_staff`
--

CREATE TABLE `assign_branch_staff` (
  `id` bigint(20) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `balance_transfers`
--

CREATE TABLE `balance_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `beneficiary_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `reject_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wire_transfer_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=Completed, 2= Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `beneficiary_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beneficiary_id` int(10) UNSIGNED DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routing_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `swift_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_staff`
--

CREATE TABLE `branch_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => Account Officer\r\n1 => Branch Manager',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_staff_password_resets`
--

CREATE TABLE `branch_staff_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `branch_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `branch_staff_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `method_code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amo` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int(10) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_app` tinyint(1) NOT NULL DEFAULT 0,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dps`
--

CREATE TABLE `dps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dps_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(10) UNSIGNED NOT NULL,
  `per_installment` decimal(28,8) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `installment_interval` int(11) NOT NULL COMMENT 'In Day',
  `delay_value` int(11) NOT NULL DEFAULT 1 COMMENT 'In Day',
  `charge_per_installment` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `delay_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `given_installment` int(11) NOT NULL DEFAULT 0,
  `total_installment` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 = Running, 2 = Matured, 0 = Closed',
  `withdrawn_at` date DEFAULT NULL,
  `due_notification_sent` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dps_plans`
--

CREATE TABLE `dps_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_installment` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `installment_interval` int(11) NOT NULL DEFAULT 0 COMMENT 'In Day',
  `total_installment` int(11) NOT NULL DEFAULT 0,
  `interest_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `delay_value` int(11) NOT NULL DEFAULT 1,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 23:16:05', '2022-08-25 05:56:44'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 23:16:05', '2022-12-04 14:05:42'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 23:16:05', '2022-12-04 14:05:37'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-04 10:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `fdrs`
--

CREATE TABLE `fdrs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fdr_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `per_installment` decimal(28,8) NOT NULL,
  `installment_interval` int(11) NOT NULL COMMENT 'In Day',
  `profit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 = Running, 2= Closed',
  `next_installment_date` date DEFAULT NULL,
  `locked_date` date DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fdr_plans`
--

CREATE TABLE `fdr_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `installment_interval` int(11) NOT NULL DEFAULT 0 COMMENT 'In Day',
  `interest_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `locked_days` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(1, 'wire_transfer', '{\"account_name\":{\"name\":\"Account Name\",\"label\":\"account_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_number\":{\"name\":\"Account Number\",\"label\":\"account_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2022-12-05 12:45:33', '2022-12-05 12:45:33'),
(2, 'kyc', '{\"name_of_father\":{\"name\":\"Name of Father\",\"label\":\"name_of_father\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"name_of_mother\":{\"name\":\"Name of Mother\",\"label\":\"name_of_mother\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"gender\":{\"name\":\"Gender\",\"label\":\"gender\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"Male\",\"Female\",\"Others\"],\"type\":\"radio\"}}', '2022-12-05 12:51:38', '2022-12-05 12:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"bank\",\"e-banking\",\"digital banking\",\"digital bank\",\"laon\",\"deposit\",\"fdr\",\"dps\"],\"description\":\"Viserbank is a complete e-Banking system. We have account-holders from almost all over the world. This is getting popular day by day. Our system is secure and robust. You may feel safe about your deposited funds.\",\"social_title\":\"Viserbank\",\"social_description\":\"Viserbank is a complete e-Banking system. We have account-holders from almost all over the world. This is getting popular day by day. Our system is secure and robust. You may feel safe about your deposited funds.\",\"image\":\"61127551e0e3f1628599633.jpg\"}', '2020-07-04 17:42:52', '2021-08-10 12:47:13'),
(24, 'about.content', '{\"has_image\":\"1\",\"title\":\"About Us\",\"heading\":\"We care about your money and safety.\",\"video_link\":\"https:\\/\\/www.youtube.com\\/embed\\/WOb4cj7izpE\",\"subheading\":\"Viserbank is a complete e-Banking system. We have account-holders from almost all over the world. This is getting popular day by day. Our system is secure and robust. You may feel safe about your deposited funds.\",\"image\":\"60c75675a19651623676533.jpg\"}', '2020-10-27 18:51:20', '2022-10-09 13:31:40'),
(25, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"Hic tenetur nihil ex. Doloremque ipsa velit, ea molestias expedita sed voluptatem ex voluptatibus temporibus sequi. sddd\"}', '2020-10-27 18:51:34', '2020-10-27 18:52:52'),
(26, 'blog.element', '{\"has_image\":[\"1\",\"1\"],\"title\":\"this is a test blog 2\",\"description\":\"aewf asdf\",\"description_nic\":\"asdf asdf\",\"blog_icon\":\"<i class=\\\"lab la-hornbill\\\"><\\/i>\",\"blog_image_1\":\"5f99164f1baec1603868239.jpg\",\"blog_image_2\":\"5ff2e146346d21609752902.jpg\"}', '2020-10-27 18:57:19', '2021-01-03 21:35:02'),
(27, 'contact_us.content', '{\"heading\":\"Feel free to contact us\",\"map_source\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d15248.978521521234!2d-73.75141171038925!3d40.67880542694389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1628170138354!5m2!1sen!2sbd\"}', '2020-10-27 18:59:19', '2021-08-05 13:29:21'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Register New Account\"}', '2020-10-27 19:04:02', '2020-10-27 19:04:02'),
(30, 'blog.element', '{\"has_image\":[\"1\",\"1\"],\"title\":\"This is test blog 1\",\"description\":\"asdfasdf ffffffffff\",\"description_nic\":\"asdfasdf asdd vvvvvvvvvvvvvvvvvv\",\"blog_icon\":\"<i class=\\\"las la-highlighter\\\"><\\/i>\",\"blog_image_1\":\"5f9d0689e022d1604126345.jpg\",\"blog_image_2\":\"5f9d068a341211604126346.jpg\"}', '2020-10-30 18:39:05', '2020-11-11 22:36:39'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"lab la-facebook\\\"><\\/i>\",\"url\":\"https:\\/\\/www.google.com\\/\"}', '2020-11-11 22:07:30', '2020-11-11 22:07:30'),
(33, 'feature.content', '{\"heading\":\"asdf\",\"subheading\":\"asdf\"}', '2021-01-03 17:40:54', '2021-01-03 17:40:55'),
(35, 'service.element', '{\"heading\":\"Withdraw Funds\",\"subheading\":\"Account-holders of Viserbank are able to withdraw money from their account. Without verification, any withdrawal won\'t be completed, so you can trust Viserbank.\",\"icon\":\"<i class=\\\"fas fa-money-check-alt\\\"><\\/i>\"}', '2021-03-05 19:12:10', '2021-07-27 10:07:56'),
(36, 'service.content', '{\"title\":\"Our Services\",\"heading\":\"We make your life comfortable with our services.\"}', '2021-03-05 19:27:34', '2021-07-10 05:54:05'),
(39, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Welcome to the Largest E-banking System\",\"subheading\":\"Viserbank is a safe, fast, easy, and efficient e-Banking system that enables you access to your bank account and to carry out online banking services, 24\\/7\",\"button_text\":\"Create an Account\",\"button_link\":\"user\\/register\",\"image\":\"60c756944f1271623676564.jpg\"}', '2021-05-02 00:09:30', '2022-10-09 09:42:25'),
(41, 'feature.element', '{\"heading\":\"Transfer Money\",\"subheading\":\"You are able to transfer your funds within the Viserbank or other banks we support by adding your beneficiaries\",\"icon\":\"<i class=\\\"fas fa-exchange-alt\\\"><\\/i>\"}', '2021-05-07 23:57:51', '2021-07-27 09:16:21'),
(42, 'feature.element', '{\"heading\":\"Deposit Schemes\",\"subheading\":\"We have two deposit schemes for you, one is Deposit Pension Scheme and another one is the Fixed Deposit Receipt.\",\"icon\":\"<i class=\\\"fas fa-wallet\\\"><\\/i>\"}', '2021-05-08 00:00:25', '2021-07-27 09:13:04'),
(43, 'feature.element', '{\"heading\":\"Take Loan\",\"subheading\":\"We have several plans to apply for a loan. You may apply to our loan plans by submitting some of your valid information.\",\"icon\":\"<i class=\\\"fas fa-coins\\\"><\\/i>\"}', '2021-05-08 00:03:20', '2021-07-27 09:08:43'),
(44, 'feature.element', '{\"heading\":\"Online Payment\",\"subheading\":\"We have online payment services like PayPal, Stripe, Paystack, Skrill, Flutterwave, Mollie, Payeer, RazorPay, etc.\",\"icon\":\"<i class=\\\"fas fa-file-invoice-dollar\\\"><\\/i>\"}', '2021-05-08 00:04:11', '2021-07-27 09:02:17'),
(45, 'about.element', '{\"heading\":\"Our Goal\",\"subheading\":\"Viserbank will serve their customers from all over the world and becomes the popular bank in this universe.\",\"icon\":\"<i class=\\\"las la-bullseye\\\"><\\/i>\"}', '2021-05-08 01:22:54', '2021-07-27 09:25:56'),
(46, 'about.element', '{\"heading\":\"Our Vision\",\"subheading\":\"Viserbank will serve all over the world and becomes the most popular Bank in this universe.\",\"icon\":\"<i class=\\\"far fa-eye\\\"><\\/i>\"}', '2021-05-08 01:23:32', '2021-07-29 19:27:28'),
(47, 'about.element', '{\"heading\":\"Our Mission\",\"subheading\":\"We are focused on building and sustaining long-term generational relationships with our customers\",\"icon\":\"<i class=\\\"las la-hourglass-start\\\"><\\/i>\"}', '2021-05-08 01:24:08', '2021-07-27 09:20:33'),
(48, 'service.element', '{\"heading\":\"Deposit Funds\",\"subheading\":\"Account-holders of Viserbank are able to deposit their money through our several payment systems. We have online payment services like PayPal, Stripe, Paystack, Skrill, Flutterwave, Mollie, Payeer, etc.\",\"icon\":\"<i class=\\\"fas fa-credit-card\\\"><\\/i>\"}', '2021-05-08 02:12:19', '2021-07-29 20:15:05'),
(49, 'service.element', '{\"heading\":\"Fast Transfer\",\"subheading\":\"Our Money transfer system is secure and easy. Send your funds to your beneficiaries within Viserbank or to other banks. Transfer within Viserbank is instant and to other banks may take 24 hours.\",\"icon\":\"<i class=\\\"las la-exchange-alt\\\"><\\/i>\"}', '2021-05-08 02:14:20', '2021-07-27 09:53:45'),
(50, 'why_choose.content', '{\"has_image\":\"1\",\"title\":\"Why Choose Us?\",\"heading\":\"We are giving you the best services\",\"btn_text\":\"Get Started\",\"btn_link\":\"register\",\"image\":\"60d497b25b98a1624545202.jpg\"}', '2021-05-08 02:28:54', '2021-07-27 10:12:20'),
(51, 'why_choose.element', '{\"heading\":\"Lowest Transaction Fee\",\"subheading\":\"Our transaction fee is much low comparing to other banks. You can deposit, transfer, and withdraw your funds with the lowest transaction charge. As our transfer system is secure and robust you can trust us.\",\"icon\":\"<i class=\\\"fas fa-file-invoice-dollar\\\"><\\/i>\"}', '2021-05-08 02:40:57', '2021-07-27 10:26:06'),
(52, 'why_choose.element', '{\"heading\":\"Secure Service\",\"subheading\":\"Every balance subtracting transactions need OTP verification so You can feel safe about your funds. Also, you can use the google authenticator app on your cellphone and enable 2FA security from the account menu.\",\"icon\":\"<i class=\\\"las la-user-shield\\\"><\\/i>\"}', '2021-05-08 02:41:23', '2021-07-27 10:20:23'),
(53, 'how_it_work.content', '{\"title\":\"How it works\",\"heading\":\"It\'s easy to join with Us\"}', '2021-05-08 02:49:36', '2021-07-08 12:46:04'),
(54, 'how_it_work.element', '{\"heading\":\"Open an Account\",\"subheading\":\"To be an account holder you have to open an account first.\"}', '2021-05-08 02:52:30', '2021-07-27 10:29:58'),
(55, 'how_it_work.element', '{\"heading\":\"Verification\",\"subheading\":\"After registration you need to verify your Email and Mobile Number.\"}', '2021-05-08 02:52:59', '2021-07-29 19:35:50'),
(56, 'how_it_work.element', '{\"heading\":\"Deposit\",\"subheading\":\"Deposit some funds before applying on any FDR or DPS plans.\"}', '2021-05-08 02:53:21', '2021-07-27 10:32:22'),
(57, 'how_it_work.element', '{\"heading\":\"Get Service\",\"subheading\":\"Now you can get any of our services as our registered account-holder\"}', '2021-05-08 02:53:54', '2021-07-27 10:37:35'),
(58, 'fdr.content', '{\"heading\":\"Our investment plan for your future plan.\"}', '2021-05-08 03:05:40', '2021-05-08 03:05:40'),
(59, 'loan_plans.content', '{\"title\":\"Our Loan Schemes\",\"heading\":\"We Have The Best Loan Plans\"}', '2021-05-08 03:11:23', '2022-10-10 13:05:47'),
(60, 'overview.content', '{\"heading\":\"We provide our banking services all over the world\",\"subheading\":\"Viser Bank is a secure and robust e-Banking system getting popular all over the world nowadays. We offer the best FDR, DPS &amp; Loan plans to our account holders\"}', '2021-05-08 03:33:10', '2021-07-27 11:32:26'),
(61, 'overview.element', '{\"heading\":\"24M\",\"subheading\":\"Account Holders\",\"icon\":\"<i class=\\\"las la-user-circle\\\"><\\/i>\"}', '2021-05-08 03:34:45', '2021-07-27 11:32:55'),
(62, 'overview.element', '{\"heading\":\"3B\",\"subheading\":\"Total Transaction\",\"icon\":\"<i class=\\\"las la-coins\\\"><\\/i>\"}', '2021-05-08 03:39:30', '2021-05-08 03:39:30'),
(63, 'overview.element', '{\"heading\":\"120\",\"subheading\":\"Total Branches\",\"icon\":\"<i class=\\\"las la-project-diagram\\\"><\\/i>\"}', '2021-05-08 03:39:58', '2021-05-08 03:39:58'),
(65, 'testimonial.content', '{\"quote\":\"Startup Institute is a career accelerator that allows professionals to learn new skills, take their careers in a different direction, and pursue a career they are passionate about.\",\"rating\":\"5\"}', '2021-05-08 04:01:15', '2021-05-08 04:01:15'),
(70, 'faq.content', '{\"heading\":\"Frequently Asked Questions\",\"subheading\":\"Though we have provided lots of information about us and how we serve what is our working process our terms and conditions our policies etc.\"}', '2021-05-08 04:25:30', '2021-08-10 07:08:42'),
(71, 'faq.element', '{\"question\":\"Is opening an account is free?\",\"answer\":\"Yes, we don\'t take any fees for opening an account.\"}', '2021-05-08 04:32:11', '2021-07-27 12:03:43'),
(72, 'faq.element', '{\"question\":\"Is it possible to send money from Viserbank to another bank?\",\"answer\":\"Yes, you can send money from Viserbank to another bank?\"}', '2021-05-08 04:33:29', '2021-07-29 19:50:38'),
(73, 'subscribe.content', '{\"has_image\":\"1\",\"heading\":\"Subscribe our newsletter and stay connected\",\"image\":\"610fce58d3ed41628425816.jpg\"}', '2021-05-08 04:53:45', '2021-08-08 12:30:17'),
(74, 'footer.content', '{\"text\":\"Copyright \\u00a9 2021  Viserbank All Right Reserved\"}', '2021-05-08 05:47:32', '2021-07-27 14:18:36'),
(75, 'footer.element', '{\"social_link\":\"https:\\/\\/www.facebook.com\\/\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\"}', '2021-05-08 05:55:42', '2021-05-08 05:55:42'),
(76, 'footer.element', '{\"social_link\":\"https:\\/\\/twitter.com\\/\",\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\"}', '2021-05-08 05:56:08', '2021-05-08 05:56:08'),
(77, 'footer.element', '{\"social_link\":\"https:\\/\\/www.instagram.com\\/\",\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\"}', '2021-05-08 05:56:24', '2021-05-08 05:56:24'),
(78, 'footer.element', '{\"social_link\":\"https:\\/\\/bd.linkedin.com\\/\",\"social_icon\":\"<i class=\\\"fab fa-linkedin-in\\\"><\\/i>\"}', '2021-05-08 05:56:46', '2021-05-08 05:56:46'),
(79, 'contact_us.element', '{\"address_type\":\"Mobile Number\",\"address\":\"+454512418544\",\"icon\":\"<i class=\\\"fas fa-phone\\\"><\\/i>\"}', '2021-05-08 21:15:24', '2022-08-24 10:56:24'),
(80, 'contact_us.element', '{\"address_type\":\"Email Address\",\"address\":\"demo@gmail.com\",\"icon\":\"<i class=\\\"fas fa-envelope\\\"><\\/i>\"}', '2021-05-08 21:15:49', '2021-05-08 21:15:49'),
(81, 'contact_us.element', '{\"address_type\":\"Office Address\",\"address\":\"Null Street, XYZ, Universe\",\"icon\":\"<i class=\\\"fas fa-map-marked\\\"><\\/i>\"}', '2021-05-08 21:16:13', '2021-07-27 12:41:59'),
(82, 'breadcumb.content', '{\"has_image\":\"1\",\"image\":\"60c7569dec4f01623676573.jpg\"}', '2021-05-08 21:56:53', '2021-06-14 06:46:14'),
(83, 'page.element', '{\"page_name\":\"Terms\",\"page_content\":\"<span style=\\\"color:rgb(0,0,0);font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;text-align:justify;\\\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<\\/span><br \\/>\"}', '2021-06-14 00:54:31', '2021-06-14 00:54:31'),
(88, 'faq.element', '{\"question\":\"How to open an account?\",\"answer\":\"Get the registration form by clicking on the Sing Up button on the top bar. Provide all information and click on the Sign Up button.\"}', '2021-06-24 08:06:28', '2021-07-27 12:11:02'),
(89, 'faq.element', '{\"question\":\"Does Viserbank share our information for advertisement?\",\"answer\":\"No, we don\'t provide our account holder\'s information to any third-party organization.\"}', '2021-06-24 08:06:46', '2021-07-27 12:16:25'),
(92, 'overview.element', '{\"heading\":\"240+\",\"subheading\":\"Countries We Serve\",\"icon\":\"<i class=\\\"las la-globe-africa\\\"><\\/i>\"}', '2021-06-29 04:46:02', '2021-07-27 11:33:52'),
(94, 'fdr_plans.content', '{\"heading\":\"Fixed Deposit Scheme\",\"subheading\":\"Efforts are our rewards are yours!\"}', '2021-07-16 14:29:06', '2021-07-17 20:09:34'),
(95, 'dps_plans.content', '{\"heading\":\"Deposit Pension Scheme\",\"subheading\":\"Grow your deposit with us.\"}', '2021-07-16 15:14:07', '2021-07-16 15:14:07'),
(96, 'partner_section.content', '{\"heading\":\"Our Partners\"}', '2021-07-17 13:40:53', '2021-07-17 13:40:53'),
(97, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"610007f09805f1627391984.png\"}', '2021-07-17 13:41:24', '2021-07-27 13:19:44'),
(98, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"6100084858a641627392072.png\"}', '2021-07-17 13:41:33', '2021-07-27 13:21:12'),
(99, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"6100088e88e2d1627392142.png\"}', '2021-07-17 13:41:39', '2021-07-27 13:22:22'),
(100, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"610008c8078b71627392200.png\"}', '2021-07-17 13:41:45', '2021-07-27 13:23:20'),
(101, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"61000905dec851627392261.png\"}', '2021-07-17 13:41:51', '2021-07-27 13:24:21'),
(102, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"610009d71ce7c1627392471.png\"}', '2021-07-17 13:41:57', '2021-07-27 13:27:51'),
(103, 'partner_section.element', '{\"has_image\":\"1\",\"image\":\"61000a7d441c71627392637.png\"}', '2021-07-17 13:42:06', '2021-07-27 13:30:37'),
(105, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience\",\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n gather data from you when you register on our site, submit a request, \\r\\nbuy any services, react to an overview, or round out a structure. At the\\r\\n point when requesting any assistance or enrolling on our site, as \\r\\nsuitable, you might be approached to enter your: name, email address, or\\r\\n telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br>After\\r\\n an exchange, your private data (credit cards, social security numbers, \\r\\nfinancials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n don\'t sell, exchange, or in any case move to outside gatherings by and \\r\\nby recognizable data. This does exclude confided in outsiders who help \\r\\nus in working our site, leading our business, or adjusting you, since \\r\\nthose gatherings consent to keep this data private. We may likewise \\r\\ndeliver your data when we accept discharge is suitable to follow the \\r\\nlaw, implement our site strategies, or ensure our own or others\' rights,\\r\\n property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n are consistent with the prerequisites of COPPA (Children\'s Online \\r\\nPrivacy Protection Act), we don\'t gather any data from anybody under 13 \\r\\nyears old. Our site, items, and administrations are completely \\r\\ncoordinated to individuals who are in any event 13 years of age or more \\r\\nestablished.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At\\r\\n the point when you register for our site, we cycle and keep your \\r\\ninformation we have about you however long you don\'t erase the record or\\r\\n withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n don\'t and will never share, unveil, sell, or in any case give your \\r\\ninformation to different organizations for the promoting of their items \\r\\nor administrations.<\\/p><\\/div>\",\"status\":1}', '2020-07-04 17:42:52', '2022-10-09 09:41:31'),
(107, 'testimonial.element', '{\"name\":\"John Smith\",\"designation\":\"CEO of CY\",\"quote\":\"Best quality service ever I had. The money transfer system is just awesome. The beneficiary listing system makes it quite efficient.\",\"rating\":\"5\"}', '2021-07-27 11:39:24', '2021-07-27 11:42:36'),
(108, 'testimonial.element', '{\"name\":\"Michel Johnson\",\"designation\":\"Founder of ZZ\",\"quote\":\"I had opened an account 3 years ago, I feel safe keeping my funds in Viserbank. Their Deposit schemes plans are really helpful\",\"rating\":\"5\"}', '2021-07-27 11:41:19', '2021-07-27 11:46:12'),
(109, 'testimonial.element', '{\"name\":\"Maria Ahsan\",\"designation\":\"Managing Director, YY\",\"quote\":\"The is just awesome,  best quality service ever I had. You can trust them and deposit your funds. Their Loan plans are really helpful\",\"rating\":\"5\"}', '2021-07-27 11:50:09', '2021-07-27 11:50:09'),
(110, 'testimonial.element', '{\"name\":\"Adam Gilly\",\"designation\":\"CTO, UYT\",\"quote\":\"I had opened an account 5 years ago, I feel safe keeping my funds in Viserbank. Their Deposit schemes plans are really helpful.\",\"rating\":\"5\"}', '2021-07-27 11:51:31', '2021-07-27 11:51:31'),
(111, 'policy_pages.element', '{\"title\":\"Company Policy\",\"content\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\"}', '2021-07-27 12:55:55', '2021-07-27 12:55:55'),
(112, 'login_bg.content', '{\"has_image\":\"1\",\"heading\":\"Welcome Back!\",\"subheading\":\"Provide your username and password and login into your account\",\"image\":\"6110c9ec14e281628490220.jpg\"}', '2021-08-09 06:23:40', '2022-10-09 12:36:00'),
(113, 'signup_bg.content', '{\"has_image\":\"1\",\"heading\":\"Create New Account\",\"subheading\":\"You have to provide all of your valid information as we want.\",\"image\":\"6110d5890dc201628493193.jpg\"}', '2021-08-09 07:00:36', '2022-10-09 12:34:45'),
(114, 'forget_pass.content', '{\"has_image\":\"1\",\"heading\":\"Reset Password\",\"subheading\":\"Nothing to get worried about. You can always set a new password as long you have the access to the email you registered with.\",\"image\":\"6110ecaeaa1c11628499118.jpg\"}', '2021-08-09 08:51:58', '2021-08-09 08:51:59'),
(115, 'faq.element', '{\"question\":\"How to take a loan?\",\"answer\":\"We have several loan plans. Choose the best plan suitable for you and just click on the Apply Now button and put the amount.\"}', '2021-08-11 12:11:45', '2021-08-11 12:13:13'),
(117, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"content\":\"<div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;color:rgb(111,111,111);font-family:Nunito, sans-serif;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;color:rgb(54,54,54);font-family:Exo, sans-serif;\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;padding:0px;font-size:18px;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\"}', '2021-06-09 02:50:42', '2022-08-25 05:47:13'),
(118, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"content\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n gather data from you when you register on our site, submit a request, \\r\\nbuy any services, react to an overview, or round out a structure. At the\\r\\n point when requesting any assistance or enrolling on our site, as \\r\\nsuitable, you might be approached to enter your: name, email address, or\\r\\n telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After\\r\\n an exchange, your private data (credit cards, social security numbers, \\r\\nfinancials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n don\'t sell, exchange, or in any case move to outside gatherings by and \\r\\nby recognizable data. This does exclude confided in outsiders who help \\r\\nus in working our site, leading our business, or adjusting you, since \\r\\nthose gatherings consent to keep this data private. We may likewise \\r\\ndeliver your data when we accept discharge is suitable to follow the \\r\\nlaw, implement our site strategies, or ensure our own or others\' rights,\\r\\n property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n are consistent with the prerequisites of COPPA (Children\'s Online \\r\\nPrivacy Protection Act), we don\'t gather any data from anybody under 13 \\r\\nyears old. Our site, items, and administrations are completely \\r\\ncoordinated to individuals who are in any event 13 years of age or more \\r\\nestablished.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At\\r\\n the point when you register for our site, we cycle and keep your \\r\\ninformation we have about you however long you don\'t erase the record or\\r\\n withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We\\r\\n don\'t and will never share, unveil, sell, or in any case give your \\r\\ninformation to different organizations for the promoting of their items \\r\\nor administrations.<\\/p><\\/div><\\/div>\"}', '2021-06-09 02:51:18', '2022-10-09 09:39:40'),
(120, 'kyc_content.content', '{\"unverified_content\":\"Dear User, we need your KYC Data for some action. Don\'t hesitate to provide KYC Data, It\'s so much potential for us too. Don\'t worry,  it\'s very much secure in our system.\",\"pending_content\":\"Dear user, Your submitted KYC Data is currently pending now. Please take us some time to review your Data. Thank you so much for your cooperation.\"}', '2022-08-08 05:29:15', '2022-08-08 05:32:16'),
(121, 'registration_disabled.content', '{\"heading\":\"Registration Disabled\",\"subheading\":\"currently disabled your registration process. Please get in touch with your nearby Branch\",\"button_text\":\"Browse Home Page\",\"button_link\":\"\\/\"}', '2022-08-17 11:08:18', '2022-08-17 11:14:14'),
(122, 'faq.element', '{\"question\":\"How to open a FDR\",\"answer\":\"e have several FDR plans. Choose the best plan suitable for you and just click on the Apply Now button and put the amount.\"}', '2022-08-24 10:45:32', '2022-08-24 10:47:39'),
(123, 'maintenance.data', '{\"heading\":\"THE SITE IS UNDER MAINTENANCE\",\"description\":\"<h2 style=\\\"text-align: center;\\\"><span style=\\\"color: var(--bs-body-color); text-align: var(--bs-body-text-align);\\\"><font size=\\\"6\\\">We\'re just tuning up a few things.<\\/font><\\/span><\\/h2><p>We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience.<br><\\/p>\"}', NULL, '2022-11-23 13:47:31'),
(124, 'banned.content', '{\"has_image\":\"1\",\"heading\":\"You Are Banned\",\"image\":\"637ef312270a61669264146.png\"}', '2022-11-24 04:29:06', '2022-11-24 04:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(10) DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:04:38'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:35:33'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:48:36'),
(4, 0, 104, 'Skrill', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:30:16'),
(5, 0, 105, 'PayTM', 'Paytm', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 03:00:44'),
(6, 0, 106, 'Payeer', 'Payeer', 0, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:58'),
(7, 0, 107, 'PayStack', 'Paystack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2021-05-21 01:49:51'),
(8, 0, 108, 'VoguePay', 'Voguepay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:22:38'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(10, 0, 110, 'RazorPay', 'Razorpay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:53:10'),
(12, 0, 112, 'Instamojo', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:56:20'),
(13, 0, 501, 'Blockchain', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2022-03-21 07:41:56'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:14'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:44'),
(17, 0, 505, 'Coingate', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-03-30 09:24:57'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 02:02:47'),
(19, 0, 113, 'Paypal Express', 'PaypalSdk', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-20 23:01:08'),
(20, 0, 114, 'Stripe Checkout', 'StripeV3', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 00:58:38'),
(21, 0, 115, 'Mollie', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:44:45'),
(22, 0, 116, 'Cashmaal', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2021-06-22 08:05:04'),
(23, 0, 119, 'Mercado Pago', 'MercadoPago', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"3Vee5S2F\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2021-07-17 09:44:29'),
(24, 0, 120, 'Authorize.net', 'Authorize', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"3Vee5S2F\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"3Vee5S2F\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2021-07-17 09:44:29'),
(25, 0, 121, 'NMI', 'NMI', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 10:12:37'),
(26, 0, 123, 'Advance Cash', 'AdvCash', 1, '{\"account_email\":{\"title\":\"Account Email\",\"global\":true,\"value\":\"----\"},\"api_name\":{\"title\":\"API Name\",\"global\":true,\"value\":\"----\"},\"api_password\":{\"title\":\"API Password\",\"global\":true,\"value\":\"----\"}}', '{\"USD\":\"USD\", \"EUR\":\"EUR\", \"GBP\":\"GBP\", \"RUB\":\"RUB\", \"BRL\":\"BRL\", \"TRY\":\"TRY\", \"UAH\":\"UAH\", \"KZT\":\"KZT\", \"VND\":\"VND\"}', 0, '', NULL, NULL, '2022-08-31 06:21:15'),
(27, 0, 120, 'Authorize.net', 'Authorize', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"3Vee5S2F\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"3Vee5S2F\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2021-07-17 09:44:29'),
(28, 0, 122, 'Two Checkout', 'TwoCheckout', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"----\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----\"}}', '{\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AZN\":\"AZN\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"GBP\":\"GBP\",\"GTQ\":\"GTQ\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LRD\":\"LRD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MMK\":\"MMK\",\"MOP\":\"MOP\",\"MRU\":\"MRU\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RUB\":\"RUB\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"THB\":\"THB\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"UAH\":\"UAH\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XCD\":\"XCD\",\"XOF\":\"XOF\",\"YER\":\"YER\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 10:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int(10) DEFAULT NULL,
  `gateway_alias` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `global_shortcodes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT 0,
  `push_configuration` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modules` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no_length` int(11) DEFAULT NULL,
  `account_no_prefix` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_time` int(11) NOT NULL DEFAULT 0,
  `daily_transfer_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `monthly_transfer_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `minimum_transfer_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_transfer_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_transfer_charge` decimal(5,2) NOT NULL DEFAULT 0,
  `referral_commission_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `last_dps_cron` datetime DEFAULT NULL,
  `last_fdr_cron` datetime DEFAULT NULL,
  `last_loan_cron` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_template`, `sms_body`, `sms_from`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `push_configuration`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `registration`, `active_template`, `system_info`, `modules`, `account_no_length`, `account_no_prefix`, `otp_time`, `daily_transfer_limit`, `monthly_transfer_limit`, `minimum_transfer_limit`, `fixed_transfer_charge`, `percent_transfer_charge`, `referral_commission_count`, `last_dps_cron`, `last_fdr_cron`, `last_loan_cron`, `created_at`, `updated_at`) VALUES
(1, 'ViserBank', 'USD', '$', 'info@viserlab.com', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/Z1qtvtV.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2021 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', 'ViserAdmin', '00a6f7', '14233c', '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 1, 1, 'basic', '[]', '{\"deposit\":1,\"withdraw\":1,\"dps\":1,\"fdr\":1,\"loan\":1,\"own_bank\":1,\"other_bank\":1,\"otp_email\":0,\"otp_sms\":0,\"branch_create_user\":0,\"wire_transfer\":1,\"referral_system\":0}', 15, 'VB', 120, '1000.00000000', '50000.00000000', '1.00000000', '0.00000000', '0', 2, '2022-11-07 17:53:46', '2022-11-07 18:34:59', '2022-11-10 19:35:08', NULL, '2022-12-05 12:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `installmentable_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installmentable_id` int(10) UNSIGNED NOT NULL,
  `delay_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `installment_date` date DEFAULT NULL,
  `given_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `per_installment` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `installment_interval` int(11) NOT NULL DEFAULT 0 COMMENT 'Days',
  `delay_value` int(11) NOT NULL DEFAULT 1,
  `charge_per_installment` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `delay_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `given_installment` int(11) NOT NULL DEFAULT 0,
  `total_installment` int(11) NOT NULL DEFAULT 0,
  `application_form` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Running, 2 = Paid, 3 = Rejected',
  `due_notification_sent` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_plans`
--

CREATE TABLE `loan_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `per_installment` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT '%',
  `installment_interval` int(11) NOT NULL DEFAULT 0 COMMENT 'In Day',
  `total_installment` int(11) NOT NULL DEFAULT 0,
  `instruction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delay_value` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_notification_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `push_notification_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `push_notification_body`, `shortcodes`, `email_status`, `sms_status`, `push_notification_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '<div><div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been added to your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}&nbsp;</span></font><br></div><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin note:&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap; text-align: var(--bs-body-text-align);\">{{remark}}</span></div>', '{{amount}} {{site_currency}} credited in your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin note is \"{{remark}}\"', NULL, '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 0, 1, '2021-11-03 06:00:00', '2022-04-02 20:18:28'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '<div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been subtracted from your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}</span></font><br><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin Note: {{remark}}</div>', '{{amount}} {{site_currency}} debited from your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin Note is {{remark}}', NULL, '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:24:11'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:25:43'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:26:07'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-04 21:45:27'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-02 20:29:19'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', NULL, '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, 1, '2021-11-03 06:00:00', '2022-03-20 14:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', NULL, '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-04-04 21:46:35'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', NULL, '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:47:51'),
(10, 'EVER_CODE', 'Verification - Email', 'Please verify your email address', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', NULL, '{\"code\":\"Email verification code\"}', 1, 0, 1, '2021-11-03 06:00:00', '2022-04-02 20:32:07'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', '---', 'Your phone verification code is: {{code}}', NULL, '{\"code\":\"SMS Verification Code\"}', 0, 1, 1, '2021-11-03 06:00:00', '2022-03-20 13:24:37'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Request has been Processed and your money is sent', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:50:16'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}} {{currency}} has been&nbsp;<span style=\"font-weight: bolder;\">refunded&nbsp;</span>to your account and your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}}</span><span style=\"font-weight: bolder;\">&nbsp;{{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-03-20 14:57:46'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', NULL, '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-03-20 22:39:03'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', NULL, '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 1, 1, '2019-09-14 07:14:22', '2021-11-04 03:38:55'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC has been approved', NULL, NULL, NULL, '[]', 1, 1, 1, NULL, NULL),
(17, 'KYC_REJECT', 'KYC Rejected Successfully', 'KYC has been rejected', NULL, NULL, NULL, '[]', 1, 1, 1, NULL, NULL),
(18, 'WITHDRAW_OTP', 'OTP for Withdraw', 'OTP for Withdraw', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your {{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"sitename\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-08-14 04:00:35'),
(19, 'FDR_OTP', 'OTP for FDR Apply', 'OTP for FDR Apply', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your{{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"site_name\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-08-03 23:27:02'),
(20, 'DPS_OTP', 'OTP for DPS Apply', 'OTP for DPS Apply', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your {{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"site_name\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-10 21:21:19'),
(21, 'OWN_BANK_TRANSFER_OTP', 'OTP for Own Bank Transfer', 'OTP for Own Bank Transfer', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your{{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"site_name\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-08-08 06:04:22'),
(22, 'OTHER_BANK_TRANSFER_OTP', 'OTP for Other Bank Transfer Request', 'OTP for Other Bank Transfer Request', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your {{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"site_name\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-10 21:21:19'),
(23, 'WIRE_TRANSFER_OTP', 'OTP for Wire Transfer Request', 'OTP for Wire Transfer Request', '<div>Your {{site_name}} OTP is {{otp}}</div>', 'Your {{site_name}} OTP is {{otp}}', NULL, '{\r\n    \"site_name\": \"Site Name\",\r\n    \"otp\": \"One Time Password\"\r\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-10 21:21:19'),
(24, 'FDR_OPENED', 'FDR Opened successfully', 'FDR Opened successfully', '<div>Your request for opening an FDR is approved successfully.</div>\r\n<div>FDR No. :&nbsp; &nbsp;{{fdr_number}}<br>Plan : {{plan_name}} </div>\r\n<div>Amount :&nbsp;{{amount}}</div>\r\n<div>Locked till :&nbsp;{{locked_date}}&nbsp;</div>\r\n<div>Interest Rate :&nbsp;{{interest_rate}}</div>\r\n<div>Get Interest Every :&nbsp;{{installment_interval}} days</div>\r\n<div><br></div>\r\n<div>You will get your first profit on&nbsp;{{next_installment_date}}</div>\r\n<div><br></div>', 'Your FDR request of {{amount}} is approved successfully. FDR No.: {{fdr_number}}\r\nYou cant withdraw the amount till {{locked_date}}', NULL, '{\n     \"plan_name\": \"Plan name\",\n     \"fdr_number\": \"FDR Number\",\n     \"amount\": \"Deposited Amount\",\n     \"locked_date\": \"User can not withdraw the amount till that date\",\n     \"per_installment\": \"The amount user will get in per installment\",\n     \"interest_rate\": \"Interest rate\",\n     \"installment_interval\": \"How many days the user will receive an installment\",\n     \"next_installment_date\": \"The date of next installment\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-11-24 12:48:06'),
(25, 'FDR_CLOSED', 'FDR Closed', 'FDR Closed', 'Your &nbsp; <span style=\"color: rgb(33, 37, 41);\">&nbsp;{{plan_name}}&nbsp;</span>FDR Plan close request was approved successfully. The main amount {{amount}} {{site_currency}} has been credited to your account.', 'Your  {{plan_name}} FDR Plan closed successfully. The main amount {{amount}} {{site_currency}} has been credited to your account.', NULL, '{\n     \"fdr_number\": \"FDR number\",\n     \"amount\": \"Deposited Amount\",\n     \"profit\": \"Sum of installment received by user\",\n     \"per_installment\": \"Profit amount per interval\",\n     \"currency\": \"Site currency\",\n     \"plan_name\": \"Plan name\",\n     \"post_balance\": \"User\'s balance after this operation\"\n\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-11-24 12:47:32'),
(26, 'DPS_OPENED', 'DPS Opened', 'DPS Opened successfully', '<div> Your application to open a DPS approved successfully<br>{{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan Name\",\n     \"dps_number\": \"DPS Number\",\n     \"per_installment\": \"Installment amount\",\n     \"interest_rate\": \"Users profit rate on the total deposited amount\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"next_installment_date\": \"Next installment date\",\n     \"total_deposited\": \"The summation of installments\",\n     \"withdrawable_amount\": \"The amount user can withdraw after mature\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-27 22:49:00'),
(27, 'DPS_MATURED', 'DPS Matured', 'Dps matured', '<div> Your DPS is matured now<br>{{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan Name\",\n     \"dps_number\": \"DPS Number\",\n     \"per_installment\": \"Installment amount\",\n     \"interest_rate\": \"Users profit rate on the total deposited amount\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"total_deposited\": \"The summation of installments\",\n     \"withdrawable_amount\": \"The amount user can withdraw after mature\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-27 22:50:55'),
(28, 'DPS_CLOSED', 'DPS CLosed', 'DPS closed successfully', '<div> Your {{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan Name\",\n     \"dps_number\": \"DPS Number\",\n     \"per_installment\": \"Installment amount\",\n     \"interest_rate\": \"Users profit rate on the total deposited amount\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"next_installment_date\": \"Next installment date\",\n     \"total_deposited\": \"The summation of installments\",\n     \"withdrawn_amount\": \"The amount user has withdrawn\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-10 21:21:19'),
(29, 'DPS_INSTALLMENT_DUE', 'DPS instalment Due', 'DPS instalment Due', 'Please recharge your balance for the DPS instalment&nbsp;<br><br><br>', 'Please recharge your balance for the DPS instalment', NULL, '{\n     \"dps_number\": \"DPS Number\",\n     \"per_installment\": \"Installment amount\",\n     \"interest_rate\": \"Users profit rate on the total deposited amount\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"installment_date\": \"Installment date\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-08-27 07:26:47'),
(30, 'LOAN_APPROVE', 'Loan Approved Successfully', 'Loan Approved Successfully', '<div>Your request for a loan is approved successfully<br><br>&nbsp;Your {{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan name\",\n     \"loan_number\": \"Loan number\",\n     \"amount\": \"Loan amount\",\n     \"per_installment\": \"Installment amount\",\n     \"payable_amount\": \"Payable amount for user\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"next_installment_date\": \"Next installment date\"\n}', 1, 1, 1, NULL, NULL),
(31, 'LOAN_REJECT', 'Loan Request Rejected', 'Loan Request Rejected', '<div> Your application for a loan is rejected by the authority <br>{{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan name\",\n     \"loan_number\": \"Loan number\",\n     \"amount\": \"Loan amount\",\n     \"per_installment\": \"Installment amount\",\n     \"payable_amount\": \"Payable amount for user\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"reason_of_rejection\": \"Reason of rejection\"\n}', 1, 1, 1, NULL, NULL),
(36, 'LOAN_INSTALLMENT_DUE', 'Loan Installment Due', 'Loan installment due', '<div>Please recharge your balance for installment&nbsp;<br><br>{{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"loan_number\": \"Loan number\",\n     \"amount\": \"Loan amount\",\n     \"per_installment\": \"Installment amount\",\n     \"payable_amount\": \"Payable amount for user\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\",\n     \"installment_date\": \"Installment date\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2022-08-22 22:12:54'),
(37, 'LOAN_PAID', 'Loan Paid', 'Loan completed', '<div> You paid all installment<br>{{plan_name}} </div>', 'Your {{plan_name}}', NULL, '{\n     \"plan_name\": \"Plan name\",\n     \"loan_number\": \"Loan number\",\n     \"amount\": \"Loan amount\",\n     \"per_installment\": \"Installment amount\",\n     \"payable_amount\": \"Payable amount for user\",\n     \"installment_interval\": \"How many days in an installment\",\n     \"delay_value\": \"How many days of delay the charge will be applied\",\n     \"charge_per_installment\": \"Installment delay charge for each day\",\n     \"delay_charge\": \"Total installment delay charge\",\n     \"given_installment\": \"How many installments are given by the user\",\n     \"total_installment\": \"How many installments for this plan\"\n}', 1, 1, 1, '2021-07-10 21:21:19', '2021-07-27 22:46:44'),
(38, 'OTHER_BANK_TRANSFER_REQUEST_SEND', 'Other Bank Money Transfer Request Sent', 'Money Transfer Request Sent Successfully', '<font color=\"#212529\"><span style=\"font-size: 12px; white-space: nowrap;\"><b>{{sending_amount}}&nbsp;{{site_currency}}</b></span></font>&nbsp;transfer request submitted&nbsp;successfully', '{{sending_amount}} {{site_currency}} sent to {recipient_account_number} successfully', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\",\n     \"bank_name\": \"Name of the bank of recipient\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-14 10:56:30'),
(39, 'OTHER_BANK_TRANSFER_COMPLETE', 'Other Bank Money Transfer Completed', 'Money Transfer Completed Successfully', '<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{sending_amount}}&nbsp;</span><span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{currency}}</span>&nbsp;sent to&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{recipient_account_number}}</span>&nbsp;successfully', '{{amount}} {{currency}} sent to {{recipient_account_number}} successfully', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\",\n     \"bank_name\": \"Name of the bank of recipient\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-24 12:49:45'),
(40, 'OTHER_BANK_TRANSFER_REJECT', 'Other Bank Money Transfer Rejected', 'Money Transfer Rejected', '<font color=\"#212529\"><span style=\"font-size: 12px; white-space: nowrap;\"><b>{{sending_amount}}&nbsp;{{site_currency}}</b></span></font>&nbsp;transfer request is rejected for&nbsp;{{reject_reason}} &nbsp;and the amount has refunded to your account', '{{amount}}{{currency}} sent to {{recipient_account_number}} successfully', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\",\n     \"bank_name\": \"Name of the bank of recipient\",\n     \"reject_reason\": \"Reject reason of transaction\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-24 12:50:25'),
(41, 'WIRE_TRANSFER_REQUEST_SEND', 'Wire Transfer Request Sent', 'Money Transfer Request Sent Successfully', '<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{sending_amount}}&nbsp;</span><span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{site_currency}} Wire</span>&nbsp;transfer request submitted&nbsp;successfully', '{{sending_amount}} {{site_currency}} Wire transfer request submitted successfully', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-24 12:53:45'),
(42, 'WIRE_TRANSFER_COMPLETED', 'Wire Transfer Completed', 'WireTransfer Completed Successfully', '<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{sending_amount}}&nbsp;</span><span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{site_currency}}</span>&nbsp;sent to&nbsp;successfully', '{{sending_amount}} {{site_currency}} sent to successfully', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-24 12:53:01'),
(43, 'WIRE_TRANSFER_REJECTED', 'Wire Transfer Rejected', 'Wire Transfer Rejected Successfully', '<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{sending_amount}}&nbsp;</span><span style=\"white-space: nowrap; font-weight: 600; font-size: 12px; color: rgb(33, 37, 41);\">{{site_currency}}</span>&nbsp;transfer request is rejected for&nbsp;{{reject_reason}} &nbsp;and the amount has refunded to your account', '{{sending_amount}} {{site_currency}} transfer request is rejected for {{reject_reason}}  and the amount has refunded to your account', NULL, '{\n     \"sender_account_number\": \"Sender account number\",\n     \"sender_account_name\": \"Sender account name\",\n     \"recipient_account_number\": \"Recipient account number\",\n     \"recipient_account_name\": \"Recipient account name\",\n     \"sending_amount\": \"The amount to be transferred\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"The amount including charge\",\n     \"reject_reason\": \"Reject reason of transaction\"\n}', 1, 1, 1, '2021-07-10 15:21:19', '2022-11-24 12:53:27'),
(44, 'DEPOSIT_VIA_BRANCH', 'Deposit From Branch', 'Deposited Successfullly', '<div style=\"\"><font face=\"Montserrat, sans-serif\">Dear&nbsp;</font><b style=\"font-family: Montserrat, sans-serif;\">{{username}},&nbsp;&nbsp;</b><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\"><b>{{amount}}</b></span><span style=\"font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\"> </span><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\"><b>{{site_currency}}</b></span><span style=\"font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\"> </span><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\">added your account from the</span><span style=\"font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\"> </span><span style=\"font-family: Montserrat, sans-serif; font-size: 1rem; text-align: var(--bs-body-text-align);\">branch</span><span style=\"font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><font face=\"Montserrat, sans-serif\"><b>{{branch_name}}</b></font></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the Branch of user account\",\"charge\":\"Deposit Charge\",\"branch_name\":\"Name of the Branch\",\"post_balance\":\"Balance of the user after this transaction\",\"username\":\"username of the deposited user\"}', 1, 1, 1, '2021-11-03 06:00:00', '2022-08-13 22:18:15'),
(45, 'WITHDRAW_VIA_BRANCH', 'Withdraw From Branch', 'Withdrawn Successfully', '<div style=\"\"><span style=\"font-family: Montserrat, sans-serif; font-weight: bolder;\">Your&nbsp;</span><span style=\"font-family: Montserrat, sans-serif; font-weight: 700; font-size: 1rem; text-align: var(--bs-body-text-align);\">withdraw successfulllyy from the Branch&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><font face=\"Montserrat, sans-serif\"><b>{{branch_name}}</b></font></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Amount withdrawn successfully from the Branch {{branch_name}}', NULL, '        {\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount Of Withdraw\",\"charge\":\"Amount Of Withdraw Charge\",\"branch_name\":\"Name of the withdraw branch\"}\r\n', 1, 1, 1, '2021-11-03 06:00:00', '2022-08-14 05:39:00'),
(46, 'REFERRAL_COMMISSION', 'Referral Commission', 'Referral Commission', 'Congratulation, You you  {{amount}}&nbsp;{{site_currency}}&nbsp; interest And your main balance {{post_balance}}&nbsp;{{site_currency}}&nbsp; . {{level}} . Transaction {{trx}}', 'Congratulation, You you {{amount}} {{site_currency}}  interest And your main balance {{post_balance}} {{site_currency}}  . {{level}} . Transaction {{trx}}', NULL, '{\n     \"amount\": \"amount\",\n     \"post_balance\": \"Balance after commission received\",\n     \"trx\": \"Transaction Number\",\n     \"level\": \"level\"\n}', 1, 1, 1, '2019-09-14 07:14:22', '2022-08-29 07:26:21'),
(47, 'OWN_BANK_TRANSFER_MONEY_SEND', 'Own Bank Transfer - Money Send', 'Money Transferred Successfully', 'Transfer Money Completed Successfully', 'Transfer Money Completed Successfully', NULL, '{\n     \"sender\": \"Who send the money\",\n     \"recipient\": \"Who receive the money\",\n     \"amount\": \"Transfer amount\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"Final amount after charge\",\n     \"trx\": \"Transaction number\",\n     \"post_balance\": \"Balance after this operation\"\n}', 1, 1, 1, NULL, NULL),
(48, 'OWN_BANK_TRANSFER_MONEY_RECEIVE', 'Own Bank Transfer - Money Receive', 'Transferred Money Received', 'You have received {{amount}}&nbsp;{{site_currency}}', 'You have received {{amount}} {{site_currency}}', NULL, '{\n     \"sender\": \"Who send the money\",\n     \"recipient\": \"Who receive the money\",\n     \"amount\": \"Transfer amount\",\n     \"charge\": \"Transfer charge\",\n     \"final_amount\": \"Final amount after charge\",\n     \"trx\": \"Transaction number\",\n     \"post_balance\": \"Balance after this operation\"\n}\n', 1, 1, 1, NULL, '2022-11-14 11:21:15'),
(49, 'STAFF_CREDENTIALS', 'Staff Credentials', 'Staff Login Credentials', 'Email: {{email}}<br>Password: {{password}}<div><br></div><div><br>\r\n\r\n<a href=\"{{login_link}}\" style=\"\r\n    background: #4634ff;\r\n    color: #ffff;\r\n    padding: 10px 15px;\r\n    border-radius: 5px;\r\n\">Login Now</a>\r\n</div>', 'Email: {{email}}\r\nPassword: {{password}}', NULL, '{\n     \"email\": \"Staff Email\",\n     \"password\": \"Password\",\n     \"login_link\": \"Login Link for Staff\"\n\n}', 1, 1, 1, NULL, '2022-11-27 10:20:16'),
(50, 'ACCOUNT_OPENED', 'Account Opened', 'Account Opened successfully', '<div> Your account has been opened successfully.<br>\r\n\r\n</div><div>Your Login Credentials</div><div>Username:{{username}}</div><div>Password:{{password}}</div><div><br></div>', 'Your account has been opened successfully.\r\nUsername:{{username}}\r\nPassword:{{password}}', NULL, '{\r\n    \"email\":\"Your Email Address\",\r\n    \"username\":\"Your username\",\r\n    \"Password\":\"Your Password\"\r\n}\r\n', 1, 1, 1, '2021-07-10 21:21:19', '2022-12-05 10:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `other_banks`
--

CREATE TABLE `other_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000 COMMENT 'Per transaction',
  `maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000 COMMENT 'Per transaction',
  `daily_maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `monthly_maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `daily_total_transaction` int(10) NOT NULL DEFAULT 0,
  `monthly_total_transaction` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `fixed_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `processing_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `form_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `verifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verifiable_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `otp` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_via` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notify_template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `used_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"feature\",\"about\",\"service\",\"why_choose\",\"how_it_work\",\"fdr_plans\",\"dps_plans\",\"loan_plans\",\"overview\",\"testimonial\",\"faq\",\"partner_section\",\"subscribe\"]', 1, '2020-07-11 06:23:58', '2021-08-11 11:47:52'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"subscribe\"]', 1, '2020-10-22 01:14:53', '2021-08-11 11:58:01'),
(12, 'About Us', 'about-us', 'templates.basic.', '[\"about\",\"service\",\"overview\",\"testimonial\",\"partner_section\",\"subscribe\"]', 0, '2021-07-27 12:37:15', '2021-08-11 11:56:08'),
(13, 'Services', 'services', 'templates.basic.', '[\"service\",\"overview\",\"testimonial\",\"partner_section\",\"subscribe\"]', 0, '2021-07-27 12:38:01', '2021-08-11 11:56:57'),
(14, 'FAQ', 'faq', 'templates.basic.', '[\"faq\",\"service\",\"testimonial\",\"overview\",\"subscribe\"]', 0, '2021-07-27 12:40:09', '2021-08-11 11:57:31'),
(15, 'Branch', 'branch', 'templates.basic.', NULL, 1, '2022-11-24 04:34:34', '2022-11-24 04:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referral_settings`
--

CREATE TABLE `referral_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` int(11) NOT NULL,
  `percent` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `branch_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `branch_staff_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `branch_staff_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `account_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `referral_commission_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: sms unverified, 1: sms verified',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified	',
  `kyc_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_complete` tinyint(1) NOT NULL DEFAULT 0,
  `ban_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `click_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wire_transfer_settings`
--

CREATE TABLE `wire_transfer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `minimum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000 COMMENT 'Per transaction',
  `maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000 COMMENT 'Per transaction',
  `daily_maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `monthly_maximum_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `daily_total_transaction` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `monthly_total_transaction` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `fixed_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `instruction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_staff_id` int(10) NOT NULL DEFAULT 0,
  `branch_id` int(10) NOT NULL DEFAULT 0,
  `method_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_branch_staff`
--
ALTER TABLE `assign_branch_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance_transfers`
--
ALTER TABLE `balance_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_name_unique` (`name`),
  ADD UNIQUE KEY `branches_code_unique` (`code`);

--
-- Indexes for table `branch_staff`
--
ALTER TABLE `branch_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_staff_email_unique` (`email`),
  ADD UNIQUE KEY `branch_staff_mobile_unique` (`mobile`);

--
-- Indexes for table `branch_staff_password_resets`
--
ALTER TABLE `branch_staff_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dps`
--
ALTER TABLE `dps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dps_number` (`dps_number`);

--
-- Indexes for table `dps_plans`
--
ALTER TABLE `dps_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fdrs`
--
ALTER TABLE `fdrs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fdr_number` (`fdr_number`);

--
-- Indexes for table `fdr_plans`
--
ALTER TABLE `fdr_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_number` (`loan_number`);

--
-- Indexes for table `loan_plans`
--
ALTER TABLE `loan_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_banks`
--
ALTER TABLE `other_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `referral_settings`
--
ALTER TABLE `referral_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wire_transfer_settings`
--
ALTER TABLE `wire_transfer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_branch_staff`
--
ALTER TABLE `assign_branch_staff`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balance_transfers`
--
ALTER TABLE `balance_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_staff`
--
ALTER TABLE `branch_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_staff_password_resets`
--
ALTER TABLE `branch_staff_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `dps`
--
ALTER TABLE `dps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dps_plans`
--
ALTER TABLE `dps_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fdrs`
--
ALTER TABLE `fdrs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fdr_plans`
--
ALTER TABLE `fdr_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_plans`
--
ALTER TABLE `loan_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `other_banks`
--
ALTER TABLE `other_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referral_settings`
--
ALTER TABLE `referral_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `wire_transfer_settings`
--
ALTER TABLE `wire_transfer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
