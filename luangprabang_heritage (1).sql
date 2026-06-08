-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2026 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luangprabang_heritage`
--

-- --------------------------------------------------------

--
-- Table structure for table `heritage_categories`
--

CREATE TABLE `heritage_categories` (
  `category_id` int(11) NOT NULL,
  `category_name_lo` varchar(100) DEFAULT NULL,
  `category_name_en` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heritage_categories`
--

INSERT INTO `heritage_categories` (`category_id`, `category_name_lo`, `category_name_en`) VALUES
(1, 'ເຮືອນພື້ນເມືອງ', 'Traditional House'),
(2, 'ວັດວາອາຮາມ', 'Temple'),
(3, 'ອາຄານສະໄໝຝຣັ່ງ', 'French Colonial Building'),
(4, 'ອາຄານສະໄໝລາວ-ຝຣັ່ງ', 'Lao-French Architecture'),
(5, 'ຮ້ານຄ້າພື້ນເມືອງ', 'Traditional Shop House');

-- --------------------------------------------------------

--
-- Table structure for table `heritage_houses`
--

CREATE TABLE `heritage_houses` (
  `house_id` int(11) NOT NULL,
  `qr_code` varchar(100) NOT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `house_name_lo` varchar(255) DEFAULT NULL,
  `house_name_en` varchar(255) DEFAULT NULL,
  `owner_name_lo` varchar(255) DEFAULT NULL,
  `owner_name_en` varchar(255) DEFAULT NULL,
  `construction_year` int(11) DEFAULT NULL,
  `architectural_style_lo` varchar(255) DEFAULT NULL,
  `architectural_style_en` varchar(255) DEFAULT NULL,
  `historical_significance_lo` text DEFAULT NULL,
  `historical_significance_en` text DEFAULT NULL,
  `description_lo` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `image_main` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `house_type` varchar(100) DEFAULT NULL,
  `building_material` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heritage_houses`
--

INSERT INTO `heritage_houses` (`house_id`, `qr_code`, `house_number`, `house_name_lo`, `house_name_en`, `owner_name_lo`, `owner_name_en`, `construction_year`, `architectural_style_lo`, `architectural_style_en`, `historical_significance_lo`, `historical_significance_en`, `description_lo`, `description_en`, `image_main`, `status`, `house_type`, `building_material`, `created_at`) VALUES
(28, 'LP_H001', '01', 'ຊຽງທອງ', 'Xieng Thong', '', '', 1937, '', '', 'ໃນອະດີດ ຊາວລາວນິຍົມສ້າງເຮືອນດ້ວຍໄມ້ ເນື່ອງຈາກເປັນວັດສະດຸທີ່ຫາໄດ້ງ່າຍໃນທ້ອງຖິ່ນ ແລະ ເໝາະກັບສະພາບອາກາດຮ້ອນຊຸ່ມ. ເຮືອນສ່ວນໃຫຍ່ຈະຍົກພື້ນສູງ ເພື່ອປ້ອງກັນນ້ຳຖ້ວມ ສັດມີພິດ ແລະ ຊ່ວຍໃຫ້ອາກາດໄຫຼຜ່ານໄດ້ດີ.\r\n\r\nສຳລັບເຮືອນແບບຫຼວງພະບາງ ຈະມີການຜະສົມຜະສານລະຫວ່າງສິນລະປະລາວດັ້ງເດີມ ແລະ ສະຖາປັດຕະຍະກຳຝຣັ່ງ ໃນສະໄໝອານານິຄົມ ຈຶ່ງເຫັນການໃຊ້ຝາປູນສີຂາວ ຮ່ວມກັບໂຄງສ້າງໄມ້ ແລະ ຫຼັງຄາຊົງສູງ.', '', 'ເຮືອນໃນຮູບເປັນເຮືອນໄມ້ແບບດັ້ງເດີມຂອງລາວ ຫຼື ເຮືອນແບບຫຼວງພະບາງ ທີ່ມີການຜະສົມຜະສານລະຫວ່າງສະຖາປັດຕະຍະກຳພື້ນເມືອງ ແລະ ຄວາມເປັນທຳມະຊາດ ໂດຍມີລາຍລະອຽດດັ່ງນີ້:\r\n\r\nໂຄງສ້າງເຮືອນເຮັດດ້ວຍໄມ້ ເພາະໄມ້ເປັນວັດສະດຸຫຼັກທີ່ນິຍົມໃນການກໍ່ສ້າງເຮືອນດັ້ງເດີມ ຊ່ວຍໃຫ້ເຢັນ ແລະ ລະບາຍອາກາດໄດ້ດີ\r\nຫຼັງຄາເປັນຮູບສາມຫຼ່ຽມຊ່ວຍລະບາຍນ້ຳຝົນໄດ້ດີ ແລະ ເໝາະກັບອາກາດຮ້ອນຊຸ່ມ\r\nດ້ານໜ້າມີລະບຽງ ຫຼື ຊານເຮືອນ ໃຊ້ເປັນບ່ອນພັກຜ່ອນ ນັ່ງຮັບລົມ ແລະ ຕ້ອນຮັບແຂກ\r\nມີຮົ້ວໄມ້ລ້ອມຮອບ ເພື່ອແບ່ງເຂດບ້ານ ແລະ ເພີ່ມຄວາມງາມ\r\nຮອບເຮືອນມີຕົ້ນໄມ້ ແລະ ພືດສີຂຽວຫຼາຍ ຊ່ວຍໃຫ້ບັນຍາກາດຮົ່ມເຢັນ ແລະ ສອດຄ່ອງກັບວິຖີຊີວິດແບບທຳມະຊາດ\r\n+ ຫຼັງການບູລະນະບາງສ່ວນຂອງເຮືອນໃຊ້ຝາປູນສີຂາວຮ່ວມກັບໄມ້ ສະແດງເຖິງການປັບປຸງແບບຮ່ວມສະໄໝ ແຕ່ຍັງຮັກສາເອກະລັກດັ້ງເດີມ\r\nຮູບທີສອງເປັນເຮືອນສູງສອງຊັ້ນ ມີພື້ນທີ່ໂລ່ງດ້ານລຸ່ມ ເປັນລັກສະນະເຮືອນຍົກພື້ນ ເພື່ອປ້ອງກັນນ້ຳຖ້ວມ ແລະ ຊ່ວຍໃຫ້ອາກາດໄຫຼຜ່ານໄດ້ດີ', '', '1779245836_6a0d230cc17a7.jpeg', 'active', 'ຫຼັງຄາດ່ຽວ', 'ໄມ້', '2026-06-08 03:33:15'),
(29, '1', '02', 'k', 'nmkl', '', '', 1123, '', '', 'jkl', '', 'kl;', '', '1780904564_6a267274934c6.jpeg', 'active', 'ຫຼັງຄາດ່ຽວ', 'ໄມ້', '2026-06-08 07:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `heritage_images`
--

CREATE TABLE `heritage_images` (
  `image_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_caption_lo` varchar(255) DEFAULT NULL,
  `image_caption_en` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heritage_images`
--

INSERT INTO `heritage_images` (`image_id`, `house_id`, `image_path`, `image_caption_lo`, `image_caption_en`, `display_order`) VALUES
(1, 28, '1779245836_6a0d230cc2a53_0.png', 'ຮູບພາບເກົ່າ ໃນຊ່ວງປີ 2000', '', 0),
(2, 28, '1779245836_6a0d230cc3761_1.png', 'ປີກໍ່ສ້າງ', '', 1),
(3, 28, '1779245836_6a0d230cc4390_2.png', 'ທີ່ຕັ້ງ ແລະ ຂອບເຂດ', '', 2),
(4, 29, '1780904564_6a26727495c84_0.png', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname_lo` varchar(100) DEFAULT NULL,
  `fullname_en` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff','viewer') DEFAULT 'viewer',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname_lo`, `fullname_en`, `email`, `role`, `status`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ຜູ້ດູແລລະບົບ', 'Administrator', NULL, 'admin', 'active', '2026-06-08 03:33:15'),
(2, 'ນ່າ', '$2y$10$RWG4QjBNoSmJDf4/nGCFfOSFB1u3fNX5wiixoqa38.OyJAOmZDtBS', 'ນ່າ', NULL, NULL, 'staff', 'active', '2026-06-08 03:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `visit_logs`
--

CREATE TABLE `visit_logs` (
  `log_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `visitor_ip` varchar(45) DEFAULT NULL,
  `visitor_device` varchar(255) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `heritage_houses`
--
ALTER TABLE `heritage_houses`
  ADD PRIMARY KEY (`house_id`),
  ADD UNIQUE KEY `qr_code` (`qr_code`);

--
-- Indexes for table `heritage_images`
--
ALTER TABLE `heritage_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `visit_logs`
--
ALTER TABLE `visit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `house_id` (`house_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `heritage_houses`
--
ALTER TABLE `heritage_houses`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `heritage_images`
--
ALTER TABLE `heritage_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visit_logs`
--
ALTER TABLE `visit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
