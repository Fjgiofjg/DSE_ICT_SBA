-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-09-15 17:23:11
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
  `Quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `cart`
--

INSERT INTO `cart` (`uid`, `Product_id`, `Quantity`) VALUES
(0, 6906969, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `done_orders`
--

CREATE TABLE `done_orders` (
  `uid` int(8) NOT NULL,
  `RefNo` int(10) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `Quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `done_orders`
--

INSERT INTO `done_orders` (`uid`, `RefNo`, `Product_id`, `Quantity`) VALUES
(87654321, 6906969, 1, 1717492491),
(87654321, 6907001, 1, 1717492491),
(87654321, 6907010, 1, 1717492491);

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `uid` int(8) NOT NULL,
  `Product_id` int(7) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `RefNo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(6906969, 'Zebra - bLen Ball Pen', 14.9, 'The Zebra bLen Ball Pen is a collaboration between Zebra and Japanese design studio Nendo. It\'s designed to reduce writing stress by removing vibrations. The pen features a minimalist design that looks different from traditional pens, and when you pick it up, you\'ll notice a unique feel as well. The bLen barrel is engineered for silence, eliminating rattling sounds and vibrations during use. Zebra\'s emulsion ink technology provides a smooth and vibrant writing experience, and the tip design cushions the writing tip for comfortable use. Overall, the bLen offers a pleasant writing experience with its innovative features. If you\'re looking for a pen that combines style, comfort, and performance, the Zebra bLen is worth considering! ', 694, 69),
(6907001, 'Pentel - Calme Ball Pen', 14.9, 'The Pentel Calme Ballpoint Pen is designed to make writing as comfortable and distraction-free as possible. Here are some key features of this pen:\n<br><br>\n1. Quiet Mechanism: The Calme pen features a quiet, gentle click mechanism. When you press the pen clip to extend the refill, it emits significantly less noise compared to regular ballpoint pens, reducing distractions for you and those around you.\n<br><br>\n2. Leather-Like Grip: The pen\'s long grip section has a leather-like texture. This ergonomic design ensures a comfortable and secure hold, allowing you to write for extended periods without discomfort.\n<br><br>\n3. Color Options: The Calme pen comes in various colors, including black, red, blue, ink green, and gray-white. You can choose the one that suits your style or mood.\n<br><br>\nWhether you\'re taking notes, jotting down ideas, or simply enjoying the act of writing, the Pentel Calme Ballpoint Pen offers a smooth experience with its thoughtful design and quiet operation.\n', 942, 42),
(6907010, 'Plus - Correction Tape WH-625 [5mm]', 14.0, 'The Plus Correction Tape WH-625 is a high-quality correction tape designed for precise and clean corrections. It features a 5mm wide tape with a strong adhesive that effectively covers mistakes on various types of paper.\n<br><br>\nKey Features:\n5mm wide tape: Ideal for covering small to medium-sized mistakes.<br>\nStrong adhesive: Ensures the tape adheres firmly to the paper, preventing lifting or peeling.<br>\nSmooth application: The tape glides smoothly over the paper, providing a clean and even correction.<br>\nOpaque white color: Effectively covers mistakes without leaving any visible marks.<br>\nEasy to use: The dispenser features a comfortable grip and a clear window for easy tape application.<br>\nDurable construction: The dispenser is made of high-quality materials for long-lasting use.<br>\n<br><br>\nBenefits:\nSaves time and effort: The tape allows for quick and easy corrections, eliminating the need for erasers or correction fluid.<br>\nProvides a clean and professional finish: The opaque white color ensures that mistakes are completely covered, leaving a clean and professional-looking document.<br>\nReduces paper waste: The tape allows for multiple corrections on the same spot, reducing the need to discard entire pages.<br>\nVersatile: Suitable for use on various types of paper, including notebooks, copy paper, and fax paper.<br>\n<br><br>\nApplications:\nStudents: Ideal for correcting mistakes in homework, essays, and other schoolwork.<br>\nOffice workers: Perfect for correcting typos and other errors in documents, presentations, and reports.<br>\nArtists and designers: Useful for covering small mistakes in sketches, drawings, and other artwork.<br>\nSpecifications:\n<br><br>\nTape width: 5mm<br>\nTape length: 10m<br>\nDispenser color: White<br>\nMaterial: Plastic<br><br>\nOverall, the Plus Correction Tape WH-625 is a reliable and convenient correction tape that provides a clean and professional solution for correcting mistakes.', 701, 0),
(6907020, 'Plus Correction Tape Refill WH-625R', 9.0, 'The Plus Correction Tape Refill WH-625R is a replacement tape cartridge for the Plus Correction Tape WH-625 correction tape dispenser. It features a 5mm wide tape with a strong adhesive that effectively covers mistakes on various types of paper.<br>\n<br><br>\nKey Features:\n<br>\n5mm wide tape: Compatible with the Plus Correction Tape WH-625 dispenser.<br>\nStrong adhesive: Ensures the tape adheres firmly to the paper, preventing lifting or peeling.<br>\nSmooth application: The tape glides smoothly over the paper, providing a clean and even correction.<br>\nOpaque white color: Effectively covers mistakes without leaving any visible marks.<br>\nEasy to install: The refill cartridge can be easily installed into the dispenser.<br>\nEconomical: Provides a cost-effective way to extend the life of your correction tape dispenser.<br><br>\nBenefits:\n<br>\nReduces waste: By using a refill cartridge, you can avoid throwing away the entire dispenser when the tape runs out.<br>\nSaves money: Refills are typically more affordable than purchasing a new dispenser.<br>\nConvenience: Having a spare refill cartridge on hand ensures you can continue using your correction tape dispenser without interruption.<br>\nSpecifications:\n<br><br>\nTape width: 5mm<br>\nTape length: 10m<br>\nMaterial: Plastic<br><br>\nCompatibility:\n<br>\nPlus Correction Tape WH-625<br>\n<br>\nOverall, the Plus Correction Tape Refill WH-625R is an essential accessory for anyone who uses the Plus Correction Tape WH-625 correction tape dispenser. It provides a convenient and economical way to keep your dispenser stocked with fresh tape.', 420, 20),
(6907030, 'SanDisk Ultra - USB 3.0 flash drive (128GB)', 160.0, 'The SanDisk Ultra USB 3.0 Flash Drive is a high-performance flash drive that offers fast data transfer speeds and ample storage capacity. It features a sleek and durable design, making it ideal for storing and transferring important files on the go.<br>\n<br>\nKey Features:\n<br>\nUSB 3.0 interface: Provides transfer speeds up to 10 times faster than USB 2.0, allowing you to quickly transfer large files.<br>\nStorage capacities: Available in a range of capacities from 16GB to 256GB, providing ample space for your photos, videos, music, and other important files.<br>\nDurable design: The drive is shockproof, waterproof, and temperature-proof, ensuring your data is protected against accidental damage.<br>\nSleek and compact: The drive features a small and lightweight design that easily fits in your pocket or bag.<br>\nPassword protection: Optional password protection software helps keep your files secure.<br>\nSanDisk SecureAccess software: Allows you to create a private folder on the drive for added security.<br>\nRescuePRO Deluxe software: Helps recover accidentally deleted files.<br><br>\nBenefits:\n<br>\nFast data transfer speeds: The USB 3.0 interface allows you to quickly transfer large files, saving you time and effort.<br>\nAmple storage capacity: With a range of storage capacities available, you can choose the drive that best suits your needs.<br>\nDurable construction: The drive is built to withstand everyday wear and tear, ensuring your data is protected.<br>\nConvenient and portable: The small and lightweight design makes it easy to take the drive with you wherever you go.<br>\nSecure data storage: Password protection and SanDisk SecureAccess software help keep your files safe from unauthorized access.<br>\nData recovery software: RescuePRO Deluxe software can help you recover accidentally deleted files.<br><br>\nApplications:\n<br>\nStoring and transferring photos, videos, music, and other important files.<br>\nBacking up your computer\'s data.<br>\nSharing files between computers.<br>\nTaking your files with you on the go.<br><br>\nOverall, the SanDisk Ultra USB 3.0 Flash Drive is a versatile and reliable storage solution that offers fast data transfer speeds, ample storage capacity, and durable construction.', 302, 89),
(6907040, 'Test Product Six', 403.8, 'This is a Test Product with a price of $403.80', 403, 80),
(6907050, 'Test Product Seven', 504.5, 'This is a Test Product with a price of $504.50', 504, 50),
(6907060, 'Test Product Eight', 808.1, 'This is a Test Product priced at $808.08', 808, 0),
(6907070, 'Test Product Nine', 909.1, 'A Test Product with a price of $909.09', 909, 9),
(6907080, 'Test Product Ten', 999.9, 'This is a Test Product priced at $999.9', 101, 10);

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
('pencil', 18273645, '5C', 20, 0, '$2y$10$pc7beB3vwzKSfF7MNYkA4O0awfZZHADwbXdwfrCYdN/XNr1reMLL2'),
('Test_1', 87654321, 'Ts', 99, 1, '$2y$10$EOJrkOSD1eF4FxjSpT7yH.Wxg9X/arYf7Y3Yh2Bow7h1/m9/ZG8fq');

-- --------------------------------------------------------

--
-- 資料表結構 `wish`
--

CREATE TABLE `wish` (
  `uid` int(8) NOT NULL,
  `Product_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `wish`
--

INSERT INTO `wish` (`uid`, `Product_id`) VALUES
(87654321, 6906969),
(87654321, 6907001),
(87654321, 6907010);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`uid`,`Product_id`);

--
-- 資料表索引 `done_orders`
--
ALTER TABLE `done_orders`
  ADD PRIMARY KEY (`RefNo`,`Product_id`,`uid`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`uid`,`Product_id`,`RefNo`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- 資料表索引 `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`uid`,`Product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
