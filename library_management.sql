-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 12:01 AM
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
-- Database: `library_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Available','In Use','Under Maintenance') NOT NULL DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `description`, `status`, `created_at`, `image_path`, `category`) VALUES
(10, 'Predator Helios 16', '16-inch display, Intel Core i9 processors, and NVIDIA GeForce RTX 40 Series laptop GPUs', 'Available', '2025-07-01 15:53:23', 'uploads/assets/1751385203_helios neo 16.jpeg', 'Laptop'),
(11, 'Acer Nitro 5', 'Standing screen display size	‎15.6 Inches\r\nScreen Resolution	‎1920 x 1080 pixels\r\nMax Screen Resolution	‎1920 x 1080 Pixels\r\nProcessor	‎4.1 GHz core_i5\r\nRAM	‎8 GB DDR4', 'Available', '2025-07-01 16:26:59', 'uploads/assets/1751387219_acer nitro 5.jpg', 'Laptop'),
(12, 'The Pilgrim’s Progress by John Bunyan (1678)', 'The Pilgrim\'s Progress from This World, to That Which Is to Come is a 1678 Christian allegory written by John Bunyan. It is commonly regarded as one of the most significant works of Protestant devotional literature and of wider early modern English literature.[1][2][3][4][5][6] It has been translated into more than 200 languages and has never been out of print.', 'Available', '2025-07-01 16:40:28', 'uploads/assets/1751388028_29797.jpg', 'English Novel'),
(13, 'Robinson Crusoe by Daniel Defoe (1719)', 'By the end of the 19th century, no book in English literary history had enjoyed more editions, spin-offs and translations. Crusoe’s world-famous novel is a complex literary confection, and it’s irresistible.', 'Available', '2025-07-01 16:43:03', 'uploads/assets/1751388183_110001085.jpg', 'English Novel'),
(14, 'Gulliver’s Travels by Jonathan Swift (1726)', 'A satirical masterpiece that’s never been out of print, Jonathan Swift’s Gulliver’s Travels comes third in our list of the best novels written in English', 'Available', '2025-07-01 16:45:07', 'uploads/assets/1751388307_gulliver-s-travels-220.jpg', 'English Novel'),
(15, 'Clarissa by Samuel Richardson (1748)', 'Clarissa is a tragic heroine, pressured by her unscrupulous nouveau-riche family to marry a wealthy man she detests, in the book that Samuel Johnson described as “the first book in the world for the knowledge it displays of the human heart.”', 'Available', '2025-07-01 16:46:41', 'uploads/assets/1751388401_91upQqBjBRL._UF1000,1000_QL80_.jpg', 'English Novel'),
(16, 'Tom Jones by Henry Fielding (1749)', 'Tom Jones is a classic English novel that captures the spirit of its age and whose famous characters have come to represent Augustan society in all its loquacious, turbulent, comic variety.', 'Available', '2025-07-01 16:47:52', 'uploads/assets/1751388472_1028649.jpg', 'English Novel'),
(17, 'Lenovo 16 Legion 5 Pro', '16\" Legion 5 Pro Gaming Laptop from Lenovo. NVIDIA GeForce RTX 3070 graphics card with 8GB of GDDR6 VRAM, ray-tracing, Tensor cores, and DLSS for immersive graphics in a small footprint. Additionally, a 16\" 2560 x 1600 IPS display provides a 165 Hz refresh rate, 3 ms response time, and NVIDIA G-Sync support for smooth visuals. A 3.2 GHz AMD Ryzen 7 CPU and 32GB of DDR4 RAM let you tackle your favorite games or heavy workloads. Plus, use the 1TB NVMe SSD to store apps and launch them in a flash.', 'Available', '2025-07-01 16:51:14', 'uploads/assets/1751388674_lenovo_82jq00fcus_legion_5_75800h_32gb_1tb_rtx3070_w11p_16_1693974.jpg', 'Laptop'),
(19, 'Confucius: The Analects', 'The Analects of Confucius has been one of the most widely read and studied books in China for the last 2,000 years, and continues to have a substantial influence on thought and values today. His words largely concern ethics, morality within the family, within marriage and within government, social relationships, justice and sincerity, valour and virtue. But whether you regard this as high philosophy or self- help for all the ages, whether your interest is in Chinese culture or leadership, whether it is spirituality or success that occupies your thoughts, Confucius has wise and accessible things to say about them all.', 'Available', '2025-07-01 21:33:15', 'uploads/assets/1751405595_71w9miEOMxL._SL1500_.jpg', 'Chinese Book'),
(21, 'Love Test', 'Yang Yi is 28 and has never been in a relationship—not for lack of desire, but because she devoted most of her energy to school and work. Her parents, growing increasingly anxious, often urge her to approach love with the same seriousness she once gave her studies—as if it were an exam she must pass soon.', 'Available', '2025-07-01 21:39:01', 'uploads/assets/1751405941_71qqYLcCeuL._SL1499_.jpg', 'Chinese Book'),
(22, 'Allow Everything to Happen', 'This book mainly includes \"No success does not require hard work\", \"There is hope only when you never despair\", \"Success starts with self-confidence\", \"It doesn\'t matter if you fail, try again\", etc. This book tells about some disappointments in life, the confusion when facing dreams, and the ups and downs of careers, so that readers can learn to face them calmly and have the strength to rise up. These experiences are like every mediocre person. Let people learn to \"allow\", allow everything to happen, allow us to accept and face it. The purpose of this book is to teach readers to learn to face life in a relaxed manner, get through the unsatisfactory stages of life, learn to get along with themselves, and thus have a better life. It has certain publishing value.', 'Available', '2025-07-01 21:42:55', 'uploads/assets/1751406175_61aeYpB3v+L._SL1280_.jpg', 'Chinese Book'),
(23, 'Danshari', 'When we “reject” the relationship with things ( Dan ), and “throw away” things ( Sha ), then we can “let go” of the attachment to them ( Ri ), so the essence itself is “letting go” of things. That is the essence of Danshari , the Japanese decluttering philosophy that has gone global. \r\nBy changing our view of the value of the things we hold so far, this book invites you to take action and transform your life.', 'Available', '2025-07-01 21:46:10', 'uploads/assets/1751406370_Katalog-Web-Noura-5.png', 'Chinese Book'),
(24, 'Miss Unlucky', 'Four girls, one college dorm room: A girl with perpetual bad luck, a girl known as a jinx, a girl who reacts as slowly as “Flash the Sloth,” and a girl nicknamed “Genie.” What kind of fun adventures and chaos will unfold?\r\n\r\nImmerse yourself in the fascinating stories of Chinese college students: their heartfelt friendships, vibrant campus life, youthful romances, and the rich emotions woven into their everyday lives.', 'Available', '2025-07-01 21:47:13', 'uploads/assets/1751406433_7137YA4Ks+L._SL1499_.jpg', 'Chinese Book'),
(25, 'Destiny\'s Dance', 'The year is 1909. When Ivan accidentally causes the death of a gypsy girl, he and Katya must leave Europe to escape the gypsies\' revenge. They settle in Gary, Indiana. Amidst the poor living conditions in the multi-cultural immigrant section of town, they make some good friends, yet Katya is subjected to much unhappiness. Other men pursue her, but she seeks independence. Destiny\'s Dance is part three of the \"Destiny\" trilogy.', 'Available', '2025-07-01 21:52:07', 'uploads/assets/1751406727_71gF5lwFxrL._SL1360_.jpg', 'English Novel'),
(26, 'The Academy', 'Born and raised in a small town, Leo K. Doyle has never seen the ocean or stepped foot on a plane. But Leo is a star soccer player with big dreams in life.', 'Available', '2025-07-01 21:57:27', 'uploads/assets/1751407047_71NvC01m0wL._SL1500_.jpg', 'English Novel');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Returned') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `asset_id`, `booking_date`, `return_date`, `status`, `created_at`) VALUES
(7, 1, 11, '2025-07-03', NULL, 'Approved', '2025-07-01 16:29:05'),
(8, 1, 10, '2025-07-04', NULL, 'Pending', '2025-07-01 16:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT 'Submitted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `title`, `message`, `status`, `created_at`) VALUES
(1, 1, 'Air Conditioner', 'I request to add more air conditioner in the library, it\'s too hot', 'In Progress', '2025-06-11 11:57:15'),
(2, 1, 'Seat in Library', 'Pls add more seat in library', 'Submitted', '2025-06-11 13:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `issue_description` text NOT NULL,
  `reported_by` int(11) NOT NULL,
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('Unread','Reviewed') DEFAULT 'Unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `asset_id`, `title`, `content`, `status`, `created_at`) VALUES
(1, 1, NULL, 'Maintenance needed', 'the key board is not functioning', 'Unread', '2025-06-11 13:52:18'),
(2, 4, NULL, 'sound not clear', 'when i connected and play music, it comes out noisy sound', 'Reviewed', '2025-06-23 01:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'student', '$2y$10$XoWINmaKmctz7VUew1iS1.byPgBOSFD3p5kMQxn2MMSgosKj2Rxze', 'student'),
(2, 'admin', '$2y$10$qt35mKkSmk07PqXPpJKPyOcFcfGebLXJClLszXTCYyELNyge7gSlO', 'admin'),
(3, 'admin2', '$2y$10$Y01ZXFlNIois6sqg2jrpeuxRoJ1nOsE6VQYgOHz04J1IOpo0cjJdC', 'admin'),
(4, 'student1', '$2y$10$1RRLS.m/L33.BBD6gIMqhOEAF08O5r.cLp23lbhqseGq4zAooUT3e', 'student'),
(5, 'admin3', '$2y$10$jMR1zz9oFYdFMWQ12/S6DuzBTTLPt1I7wQIO.nwGNiiZF7V/pQctm', 'admin'),
(6, 'Yang', '$2y$10$96xp6Bl4CV4OFY0O3w0DqOo7dhWYQbdzfB7PTo34BMP5JY96X6g1i', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `maintenance_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
