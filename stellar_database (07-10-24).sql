-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-10-07 14:01:16
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `stellar_database`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cart`
--

CREATE TABLE `cart` (
  `uid` int(8) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `var_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `cart`
--

INSERT INTO `cart` (`uid`, `Product_id`, `Quantity`, `var_id`) VALUES
(0, 6906969, 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `done_orders`
--

CREATE TABLE `done_orders` (
  `uid` int(8) NOT NULL,
  `RefNo` int(10) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `var_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `done_orders`
--

INSERT INTO `done_orders` (`uid`, `RefNo`, `Product_id`, `Quantity`, `var_id`) VALUES
(87654321, 6906969, 1, 1726491169, 0),
(87654321, 6907001, 1, 1726491169, 0),
(87654321, 6907010, 1, 1726491169, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `uid` int(8) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `RefNo` int(10) NOT NULL,
  `var_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`uid`, `Product_id`, `Quantity`, `RefNo`, `var_id`) VALUES
(19201005, 1234567, 2, 1727279293, 0),
(87654321, 1234567, 1, 1726738574, 0),
(87654321, 1234567, 2, 1726739006, 0),
(87654321, 6906969, 1, 1726738574, 0),
(87654321, 6906969, 1, 1726738574, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `password_requests`
--

CREATE TABLE `password_requests` (
  `uid` int(11) NOT NULL,
  `request_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `Product_id` int(7) NOT NULL,
  `Product_name` text NOT NULL,
  `Price` decimal(5,1) NOT NULL,
  `Product_desc` text NOT NULL,
  `Remain_no` int(3) NOT NULL,
  `Discount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`Product_id`, `Product_name`, `Price`, `Product_desc`, `Remain_no`, `Discount`) VALUES
(1234567, 'Pentalic Monthly Pass', 800.0, 'The Pentalic Transport Student Monthly Pass is designed to provide students with convenient, affordable, and reliable transportation options. This pass allows students to travel seamlessly across our network, making commuting to school, extracurricular activities, and social events hassle-free.\r\n    \r\n    Key Benefits\r\n    \r\n        Unlimited Travel: Enjoy unlimited rides throughout the month, giving you the freedom to travel as often as needed.\r\n        Affordable Pricing: Specially priced to fit student budgets, ensuring that transportation is accessible for everyone.\r\n        Convenient Access: Easy-to-use pass that can be used on all our buses, allowing for smooth and efficient journeys.\r\n        Safety and Comfort: Travel in a safe and comfortable environment, with modern buses equipped for a pleasant experience.\r\n        Flexibility: Ideal for daily commutes or spontaneous outings, making it perfect for busy student lifestyles.\r\n    \r\n    With the Pentalic Transport Student Monthly Pass, students can focus on their studies and activities without the stress of transportation costs or scheduling. Join us and make your travel experience as smooth as possible!', 999, 10),
(6906969, 'Zebra - bLen Ball Pen', 14.9, 'The Zebra bLen Ball Pen is a collaboration between Zebra and Japanese design studio Nendo. It\'s designed to reduce writing stress by removing vibrations. The pen features a minimalist design that looks different from traditional pens, and when you pick it up, you\'ll notice a unique feel as well. The bLen barrel is engineered for silence, eliminating rattling sounds and vibrations during use. Zebra\'s emulsion ink technology provides a smooth and vibrant writing experience, and the tip design cushions the writing tip for comfortable use. Overall, the bLen offers a pleasant writing experience with its innovative features. If you\'re looking for a pen that combines style, comfort, and performance, the Zebra bLen is worth considering! ', 694, 69),
(6907001, 'Pentel - Calme Ball Pen', 14.9, 'The Pentel Calme Ballpoint Pen is designed to make writing as comfortable and distraction-free as possible. Here are some key features of this pen:\r\n\r\n1. Quiet Mechanism: The Calme pen features a quiet, gentle click mechanism. When you press the pen clip to extend the refill, it emits significantly less noise compared to regular ballpoint pens, reducing distractions for you and those around you.\r\n\r\n2. Leather-Like Grip: The pen\'s long grip section has a leather-like texture. This ergonomic design ensures a comfortable and secure hold, allowing you to write for extended periods without discomfort.\r\n\r\n3. Color Options: The Calme pen comes in various colors, including black, red, blue, ink green, and gray-white. You can choose the one that suits your style or mood.\r\n\r\nWhether you\'re taking notes, jotting down ideas, or simply enjoying the act of writing, the Pentel Calme Ballpoint Pen offers a smooth experience with its thoughtful design and quiet operation.\r\n', 942, 42),
(6907010, 'Plus - Correction Tape WH-625 [5mm]', 14.0, '<p>The Plus Correction Tape WH-625 is a high-quality correction tape for precise and clean corrections.</p><h2>Key Features</h2><ul><li><b>5mm Wide Tape:</b> Ideal for small to medium mistakes.</li><li><b>Strong Adhesive:</b> Adheres firmly, preventing lifting.</li><li><b>Smooth Application:</b> Glides easily for even corrections.</li><li><b>Opaque White Color:</b> Covers mistakes without visible marks.</li><li><b>Easy to Use:</b> Comfortable grip with a clear window.</li><li><b>Durable Construction:</b> Made from high-quality materials.</li></ul><h2>Benefits</h2><ul><li><b>Saves Time:</b> Quick corrections eliminate the need for erasers.</li><li><b>Professional Finish:</b> Ensures documents look clean and neat.</li><li><b>Reduces Waste:</b> Allows multiple corrections on the same spot.</li><li><b>Versatile:</b> Works on various paper types.</li></ul><h2>Applications</h2><ul><li><b>Students:</b> Great for homework and essays.</li><li><b>Office Workers:</b> Ideal for correcting documents.</li><li><b>Artists:</b> Useful for sketches and drawings.</li></ul><h2>Specifications</h2><ul><li><b>Tape Width:</b> 5mm</li><li><b>Tape Length:</b> 10m</li><li><b>Dispenser Color:</b> White</li><li><b>Material:</b> Plastic</li></ul><p>Overall, the Plus Correction Tape WH-625 is a reliable tool for effective corrections.</p>', 701, 0),
(6907020, 'Plus Correction Tape Refill WH-625R', 9.0, 'The Plus Correction Tape Refill WH-625R is a replacement tape cartridge for the Plus Correction Tape WH-625 correction tape dispenser. It features a 5mm wide tape with a strong adhesive that effectively covers mistakes on various types of paper.<br>\n<br><br>\nKey Features:\n<br>\n5mm wide tape: Compatible with the Plus Correction Tape WH-625 dispenser.<br>\nStrong adhesive: Ensures the tape adheres firmly to the paper, preventing lifting or peeling.<br>\nSmooth application: The tape glides smoothly over the paper, providing a clean and even correction.<br>\nOpaque white color: Effectively covers mistakes without leaving any visible marks.<br>\nEasy to install: The refill cartridge can be easily installed into the dispenser.<br>\nEconomical: Provides a cost-effective way to extend the life of your correction tape dispenser.<br><br>\nBenefits:\n<br>\nReduces waste: By using a refill cartridge, you can avoid throwing away the entire dispenser when the tape runs out.<br>\nSaves money: Refills are typically more affordable than purchasing a new dispenser.<br>\nConvenience: Having a spare refill cartridge on hand ensures you can continue using your correction tape dispenser without interruption.<br>\nSpecifications:\n<br><br>\nTape width: 5mm<br>\nTape length: 10m<br>\nMaterial: Plastic<br><br>\nCompatibility:\n<br>\nPlus Correction Tape WH-625<br>\n<br>\nOverall, the Plus Correction Tape Refill WH-625R is an essential accessory for anyone who uses the Plus Correction Tape WH-625 correction tape dispenser. It provides a convenient and economical way to keep your dispenser stocked with fresh tape.', 420, 20),
(6907030, 'SanDisk Ultra - USB 3.0 flash drive (128GB)', 160.0, 'The SanDisk Ultra USB 3.0 Flash Drive is a high-performance flash drive that offers fast data transfer speeds and ample storage capacity. It features a sleek and durable design, making it ideal for storing and transferring important files on the go.\r\n\r\nKey Features:\r\n\r\nUSB 3.0 interface: Provides transfer speeds up to 10 times faster than USB 2.0, allowing you to quickly transfer large files.\r\nStorage capacities: Available in a range of capacities from 16GB to 256GB, providing ample space for your photos, videos, music, and other important files.\r\nDurable design: The drive is shockproof, waterproof, and temperature-proof, ensuring your data is protected against accidental damage.\r\nSleek and compact: The drive features a small and lightweight design that easily fits in your pocket or bag.\r\nPassword protection: Optional password protection software helps keep your files secure.\r\nSanDisk SecureAccess software: Allows you to create a private folder on the drive for added security.\r\nRescuePRO Deluxe software: Helps recover accidentally deleted files.\r\nBenefits:\r\n\r\nFast data transfer speeds: The USB 3.0 interface allows you to quickly transfer large files, saving you time and effort.\r\nAmple storage capacity: With a range of storage capacities available, you can choose the drive that best suits your needs.\r\nDurable construction: The drive is built to withstand everyday wear and tear, ensuring your data is protected.\r\nConvenient and portable: The small and lightweight design makes it easy to take the drive with you wherever you go.\r\nSecure data storage: Password protection and SanDisk SecureAccess software help keep your files safe from unauthorized access.\r\nData recovery software: RescuePRO Deluxe software can help you recover accidentally deleted files.\r\nApplications:\r\n\r\nStoring and transferring photos, videos, music, and other important files.\r\nBacking up your computer\'s data.\r\nSharing files between computers.\r\nTaking your files with you on the go.\r\nOverall, the SanDisk Ultra USB 3.0 Flash Drive is a versatile and reliable storage solution that offers fast data transfer speeds, ample storage capacity, and durable construction.', 302, 89),
(6907040, 'Test Product Six', 403.8, 'This is a Test Product with a price of $403.80', 403, 80),
(6907050, 'Test Product Seven', 504.5, 'This is a Test Product with a price of $504.50', 504, 50),
(6907060, 'Test Product Eight', 808.1, 'This is a Test Product priced at $808.08', 808, 0),
(6907070, 'Test Product Nine', 909.1, 'A Test Product with a price of $909.09', 909, 9);

-- --------------------------------------------------------

--
-- 資料表結構 `tags`
--

CREATE TABLE `tags` (
  `Product_id` int(7) NOT NULL,
  `Tag` text NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `tags`
--

INSERT INTO `tags` (`Product_id`, `Tag`, `tag_id`) VALUES
(1234567, 'Featured', 0),
(1234567, 'Transport', 1),
(1844111, 'Featured', 0),
(6907001, 'Pen', 0),
(6907001, 'Pentel', 1),
(6907001, 'Featured', 2),
(6907010, 'Correction', 5),
(6907030, 'Featured', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `Username` text NOT NULL,
  `uid` int(8) NOT NULL,
  `Class` text NOT NULL,
  `Class_No` int(2) NOT NULL,
  `Is_Admin` tinyint(1) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`Username`, `uid`, `Class`, `Class_No`, `Is_Admin`, `Password`) VALUES
('abcdefg', 12341234, '9E', 69, 0, '$2y$10$U6eq7jFvBAscnNCmB.mB2.D9R8pN4XfcDatN4r.glFm/5w8rWlyWG'),
('Test_sts', 12345678, '9Z', 99, 0, '$2y$10$pc7beB3vwzKSfF7MNYkA4O0awfZZHADwbXdwfrCYdN/XNr1reMLL2'),
('Era', 12549726, '6D', 22, 1, '$2y$10$N50zFjUYaZcdIQwRnuzEz.U5Ac5DvOeeYQXupdIwVaB8LY8BQ1ZYm'),
('pencil', 18273645, '5C', 20, 1, '$2y$10$pc7beB3vwzKSfF7MNYkA4O0awfZZHADwbXdwfrCYdN/XNr1reMLL2'),
('Pencil_B', 19201005, '6C', 20, 0, '$2y$10$Iv/yxbvVaF113cUrbFsajOi5hqD76RuKRkLPX.Q5l.r2s4oXAxkvm'),
('Pen', 19201025, '6C', 20, 0, '$2y$10$PvczydN0ijQGIcqedPM/S.CI5k.rjKSoF2HX5lJQHdmMISLzp1aLK'),
('Pencil', 19201648, '6C', 20, 0, '$2y$10$wKSfrFUh2H3UUqh6RVzD1.UAYnaD/ZUcushCBExapvM5iFvjXKi1W'),
('Test_1', 87654321, 'Ts', 99, 1, '$2y$10$EOJrkOSD1eF4FxjSpT7yH.Wxg9X/arYf7Y3Yh2Bow7h1/m9/ZG8fq');

-- --------------------------------------------------------

--
-- 資料表結構 `variations`
--

CREATE TABLE `variations` (
  `Product_ID` int(7) NOT NULL,
  `variation` text NOT NULL,
  `var_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `variations`
--

INSERT INTO `variations` (`Product_ID`, `variation`, `var_id`) VALUES
(1234567, 'Basic', 0),
(1844111, 'Basic', 0),
(6906969, 'Blue', 0),
(6906969, 'Red', 1),
(6906969, 'Green', 2),
(6907001, 'Red', 0),
(6907001, 'Green', 1),
(6907001, 'Blue', 2),
(6907001, 'Black', 3);

-- --------------------------------------------------------

--
-- 資料表結構 `wish`
--

CREATE TABLE `wish` (
  `uid` int(8) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `var_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `wish`
--

INSERT INTO `wish` (`uid`, `Product_id`, `var_id`) VALUES
(19201005, 6907001, 1),
(87654321, 1234567, 0),
(87654321, 1844111, 0),
(87654321, 6906969, 0),
(87654321, 6906969, 2),
(87654321, 6907001, 0),
(87654321, 6907010, 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`uid`,`Product_id`,`var_id`);

--
-- 資料表索引 `done_orders`
--
ALTER TABLE `done_orders`
  ADD PRIMARY KEY (`uid`,`RefNo`,`Product_id`,`var_id`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`uid`,`Product_id`,`RefNo`,`var_id`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_id`);

--
-- 資料表索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`Product_id`,`tag_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- 資料表索引 `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`Product_ID`,`var_id`);

--
-- 資料表索引 `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`uid`,`Product_id`,`var_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
