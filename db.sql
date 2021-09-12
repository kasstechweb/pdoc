INSERT INTO `frequency` (`id`, `name`, `option_value`, `created_at`, `updated_at`) VALUES
(1, 'Daily (240 pay periods a year)', 'DAILY', NULL, NULL),
(2, 'Weekly (52 pay periods a year)', 'WEEKLY_52PP', NULL, NULL),
(3, 'Biweekly (26 pay periods a year)', 'BI_WEEKLY', NULL, NULL),
(4, 'Semi-monthly (24 pay periods a year)', 'SEMI_MONTHLY', NULL, NULL),
(5, 'Monthly (12 pay periods a year)', 'MONTHLY_12PP', NULL, NULL);

INSERT INTO `provinces` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Alberta', NULL, NULL),
(2, 'British Columbia', NULL, NULL),
(3, 'Manitoba', NULL, NULL),
(4, 'New Brunswick', NULL, NULL),
(5, 'Newfoundland and Labrador', NULL, NULL),
(6, 'Northwest Territories', NULL, NULL),
(7, 'Nova Scotia', NULL, NULL),
(8, 'Nunavut', NULL, NULL),
(9, 'Ontario', NULL, NULL),
(10, 'Prince Edward Island', NULL, NULL),
(11, 'Quebec', NULL, NULL),
(12, 'Saskatchewan', NULL, NULL),
(13, 'Yukon', NULL, NULL);
