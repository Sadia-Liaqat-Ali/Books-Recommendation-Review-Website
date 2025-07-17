-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 12:39 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booksrecommendation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `username`, `email`, `password`) VALUES
(1, 'system administrator', 'admin@gmail.com', 'adminpassword');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooks`
--

CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `title`, `author`, `genre`, `publication_year`, `isbn`, `description`, `cover_image`, `created_at`) VALUES
(1, 'Jannat k Pattay', 'Nimra Ahmad', 'Fantasy', 2010, 'nimraahmed456@gmail.com ISBN:1133689900 Alternativ', 'From the streets of Istanbul to the Bosporus sea, from the caves of Cappadocia to the torture cells in Indian jails, Jannat Kay Pattay (“Leaves of Heaven”) is a roller‑coaster ride full of unexpected twists. The story follows Haya Suleman, an LLB (Hons) student whose life is upended when a private video of hers is leaked online. Determined to reclaim her dignity and uncover the truth, Haya embarks on a dangerous journey across continents—chasing leads in Turkey, confronting conspiracies, and ultimately searching for the man she has never met but has been seeking for years', '1752093557_jannat k pty.PNG', '2025-07-09 20:32:34'),
(2, ' INFINITY GAME SIMON SINEK', 'James Hilton', 'Fiction', 1933, 'ISBN: 9781234567897 ', ' A mysterious tale of a hidden utopia in the Himalayas called Shangri-La, where time stands still and peace reigns.  \r\nCover Image: Use the file named `lost-horizon.jpg` (uploaded via the form)', '1752108784_acy-ian-malimban-uBaO9bp1E9g-unsplash.jpg', '2025-07-10 00:53:04'),
(3, 'God & Nature', 'Noovan shuster', 'Self-Help', 2000, 'ISBN‑13: 978‑9383582556  amazon.com  Alternative L', '“Nature & God” invites readers on a profound journey to discover how the intricate beauty of the natural world—from the smallest atom to vast ecosystems—mirrors a deeper spiritual unity. Drawing on mystical insights from Sufi, Vedantic, and Christian traditions alongside modern scientific perspectives, it shows how environmental stewardship becomes a sacred duty. Through engaging philosophy and vivid examples, the book rekindles a sense of wonder and responsibility, revealing the divine presence woven throughout every aspect of creation.', '1752110590_david-emrich-uH03NpIt-JQ-unsplash.jpg', '2025-07-10 01:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotification`
--

CREATE TABLE `tblnotification` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `genre_id` int(11) NOT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblnotification`
--

INSERT INTO `tblnotification` (`id`, `book_id`, `created_at`, `genre_id`, `message`) VALUES
(1, 2, '2025-07-10 00:53:04', 1, '📚 A new Fiction book \"<strong> INFINITY GAME SIMON SINEK</strong>\" by James Hilton has been added! \r\n                        If you\'re into Fiction stories, don\'t miss it.'),
(2, 3, '2025-07-10 01:23:10', 8, '📚 A new Self-Help book \"<strong>God & Nature</strong>\" by Noovan shuster has been added! \r\n                        If you\'re into Self-Help stories, don\'t miss it.');

-- --------------------------------------------------------

--
-- Table structure for table `tblrecommendation`
--

CREATE TABLE `tblrecommendation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrecommendation`
--

INSERT INTO `tblrecommendation` (`id`, `user_id`, `genre_id`, `book_id`, `created_at`) VALUES
(33, 1, 1, NULL, '2025-07-10 01:24:15'),
(34, 1, 3, NULL, '2025-07-10 01:24:15'),
(35, 1, 4, NULL, '2025-07-10 01:24:15'),
(36, 1, 5, NULL, '2025-07-10 01:24:15'),
(37, 1, 6, NULL, '2025-07-10 01:24:15'),
(38, 1, 7, NULL, '2025-07-10 01:24:15'),
(39, 1, 8, NULL, '2025-07-10 01:24:15'),
(40, 2, 1, NULL, '2025-07-10 14:21:47'),
(41, 2, 4, NULL, '2025-07-10 14:21:47'),
(42, 2, 7, NULL, '2025-07-10 14:21:47'),
(43, 2, 10, NULL, '2025-07-10 14:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `tblreviews`
--

CREATE TABLE `tblreviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblreviews`
--

INSERT INTO `tblreviews` (`id`, `user_id`, `book_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 5, 'excellent book', '2025-07-09 23:51:48', NULL),
(3, 2, 2, 5, 'Excellent book I love it', '2025-07-10 14:21:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `name`, `email`, `password`, `profile_pic`, `bio`, `created_at`) VALUES
(1, 'Diya Shezadi ', 'diya@gmail.com', 'diya', '1752092986_portrait-female-working-from-home.jpg', 'I am a Professional Web Developer.', '2025-07-09 20:29:46'),
(2, 'User', 'user@gmail.com', 'user123', '1752157182_business-owner-working-their-strategy.jpg', 'I am a graphic designer having 5 year of professional experience in logo designing.', '2025-07-10 14:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

CREATE TABLE `tblwishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblwishlist`
--

INSERT INTO `tblwishlist` (`id`, `user_id`, `book_id`, `created_at`) VALUES
(3, 1, 2, '2025-07-10 01:19:55'),
(4, 2, 1, '2025-07-10 14:19:59'),
(5, 2, 2, '2025-07-10 14:20:41'),
(6, 2, 3, '2025-07-10 16:46:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnotification`
--
ALTER TABLE `tblnotification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrecommendation`
--
ALTER TABLE `tblrecommendation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblreviews`
--
ALTER TABLE `tblreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblnotification`
--
ALTER TABLE `tblnotification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblrecommendation`
--
ALTER TABLE `tblrecommendation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tblreviews`
--
ALTER TABLE `tblreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
