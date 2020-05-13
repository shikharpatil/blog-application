-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 06:19 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karan_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `title` varchar(150) NOT NULL,
  `blog_url` varchar(400) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `lock_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 is locked',
  `locked_user_id` int(11) NOT NULL DEFAULT 0,
  `edited_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `locked_timestamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `parent_id`, `title`, `blog_url`, `content`, `created_timestamp`, `lock_status`, `locked_user_id`, `edited_timestamp`, `locked_timestamp`) VALUES
(1, 24, 0, '', '', '<p>karans first blog 1</p>', '2020-04-13 08:05:02', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 24, 1, '', '', '<p>karans first blog 1 version 2</p>', '2020-04-20 13:24:56', 0, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 24, 0, 'posts with tags', 'posts-with-tags-v1', '<p>inserted tags in this post , number tags 3</p>', '2020-04-25 11:20:25', 0, 0, '2020-04-25 16:50:25', '2020-04-25 16:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `path` varchar(1000) NOT NULL,
  `name` varchar(500) NOT NULL,
  `upload_dir` varchar(50) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `size` varchar(100) NOT NULL,
  `system_name` varchar(500) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `path`, `name`, `upload_dir`, `extension`, `size`, `system_name`, `date_created`) VALUES
(1, 'application/uploads/24/karan/', 'versioning-v1.txt', '', 'txt', '0.00 MB', '1588422600.txt', '2020-05-02 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_tag_ids`
--

CREATE TABLE `post_tag_ids` (
  `id` int(11) NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_tag_ids`
--

INSERT INTO `post_tag_ids` (`id`, `blog_post_id`, `tag_id`) VALUES
(1, 11, 2),
(2, 11, 3),
(3, 11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(2, 'first'),
(3, 'tagging'),
(4, 'started');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
