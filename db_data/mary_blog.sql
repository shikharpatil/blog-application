-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 04:47 PM
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
-- Database: `mary_blog`
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
  `locked_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `publish_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `parent_id`, `title`, `blog_url`, `content`, `created_timestamp`, `lock_status`, `locked_user_id`, `edited_timestamp`, `locked_timestamp`, `publish_status`) VALUES
(1, 29, 0, 'mary fist post', 'mary-fist-post-v1', '<p>123235fgsfghihh hr hello</p>', '2020-04-28 07:12:18', 0, 0, '2020-04-28 12:42:18', '2020-04-28 12:42:18', 'published'),
(2, 29, 0, 'image post', 'image-post-v1', '<p><img src=\"http://localhost/blog/application/assets/b5f3f3c73c014072ad4976eba2d91b3b13a9a45a.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-29 12:39:24', 0, 0, '2020-04-29 18:09:24', '2020-04-29 18:09:24', 'published'),
(3, 29, 2, 'image post', 'image-post-v2', '<p><img src=\"http://localhost/blog/application/assets/b5f3f3c73c014072ad4976eba2d91b3b13a9a45a.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p><p>added text here check copy feature</p>', '2020-05-12 14:05:16', 0, 0, '2020-05-12 19:35:16', '2020-05-12 19:35:16', 'published'),
(4, 29, 0, 'copy-image post', 'copy-image-post-v1', '<p><img src=\"http://localhost/blog/application/assets/b5f3f3c73c014072ad4976eba2d91b3b13a9a45a.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-29 12:39:24', 0, 0, '2020-04-29 18:09:24', '2020-05-12 19:35:53', 'published'),
(5, 29, 4, 'copy-image post', 'copy-image-post-v2', '<p><img src=\"http://localhost/blog/application/assets/b5f3f3c73c014072ad4976eba2d91b3b13a9a45a.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p><p>added text here check copy feature</p>', '2020-05-12 14:05:16', 0, 0, '2020-05-12 19:35:16', '2020-05-12 19:35:53', 'published'),
(6, 29, 0, 'copy-mary fist post', 'copy-mary-fist-post-v1', '<p>123235fgsfghihh hr hello</p>', '2020-04-28 07:12:18', 0, 0, '2020-04-28 12:42:18', '2020-05-12 20:37:01', 'published'),
(8, 29, 0, 'post to be copied', 'post-to-be-copied-v1', '<p>hello copied content</p>', '2020-05-12 15:11:10', 0, 0, '2020-05-12 20:41:10', '2020-05-12 20:41:10', 'published'),
(9, 29, 8, 'post to be copied', 'post-to-be-copied-v2', '<p>hello copied content edited content</p>', '2020-05-12 15:13:01', 0, 0, '2020-05-12 20:43:01', '2020-05-12 20:43:01', 'published');

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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_post_id`, `username`, `content`, `date_time`) VALUES
(1, 3, 'mary', 'comment on version 2', '2020-05-12 14:05:32'),
(2, 5, 'mary', 'comment on version 2', '2020-05-12 14:05:53'),
(3, 8, 'mary', 'comment on post to be copied', '2020-05-12 15:11:49');

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
(1, 'application/uploads/futuristic-blurred-mobile-wallpaper-with-neon-light-shapes_79603-464.jpg', 'futuristic-blurred-mobile-wallpaper-with-neon-light-shapes_79603-464.jpg', '', 'jpg', '0.02 MB', '1588232580jpg', '2020-04-30 07:43:00'),
(2, 'application/uploads/single-handle200x1801588243357.JPG', 'single-handle200x180.JPG', '', 'JPG', '0.01 MB', '1588243357.JPG', '2020-04-30 10:42:37'),
(3, 'application/uploads/gaborone1588251497.JPG', 'gaborone-v1.JPG', '', 'JPG', '0.01 MB', '1588251497.JPG', '2020-04-30 12:58:17'),
(5, 'application/uploads/gaborone1588251948.JPG', 'gaborone-v2.JPG', '', 'JPG', '0.01 MB', '1588251948.JPG', '2020-04-30 13:05:48'),
(6, 'application/uploads/versioning1588254088.txt', 'versioning-v1.txt', '', 'txt', '0.00 MB', '1588254088.txt', '2020-04-30 13:41:28'),
(7, 'application/uploads/SampleVideo_1280x720_20mb1588255300.mp4', 'SampleVideo_1280x720_20mb-v1.mp4', '', 'mp4', '20.09 MB', '1588255300.mp4', '2020-04-30 14:01:40');

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
(1, 1, 2),
(2, 1, 3),
(3, 2, 4),
(4, 4, 4),
(5, 6, 2),
(6, 6, 3),
(7, 7, 2),
(8, 7, 3),
(9, 8, 5),
(10, 8, 6);

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
(1, ''),
(2, 'hello'),
(3, 'first'),
(4, 'image'),
(5, 'copy'),
(6, 'test');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
