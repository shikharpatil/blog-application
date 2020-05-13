-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 04:48 PM
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
-- Database: `john_blog`
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
  `locked_timestamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `publish_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `parent_id`, `title`, `blog_url`, `content`, `created_timestamp`, `lock_status`, `locked_user_id`, `edited_timestamp`, `locked_timestamp`, `publish_status`) VALUES
(1, 28, 0, 'post for football', 'post-for-football-v1', '<p>football players ronaldo messi</p>', '2020-04-28 06:39:19', 0, 0, '2020-04-28 12:09:19', '2020-05-13 13:43:29', 'published'),
(2, 28, 0, 'football post', 'football-post-v1', '<p>goal fooltball barca, real madrid</p>', '2020-04-28 06:43:00', 0, 0, '2020-04-28 12:13:00', '2020-05-13 13:43:29', 'published'),
(13, 28, 2, 'football post', 'football-post-v2', '<p>goal fooltball barca, real madrid edited </p>', '2020-05-12 11:35:38', 0, 0, '2020-05-12 17:05:38', '2020-05-13 17:28:21', 'published'),
(14, 28, 0, 'post in draft', 'post-in-draft-v1', '<p>post to be saved as drafts edited draft once</p>', '2020-05-13 09:20:33', 0, 0, '2020-05-13 14:50:33', '2020-05-13 18:46:10', 'published'),
(15, 28, 0, 'trial draft post', 'trial-draft-post-v1', '<p>drafts post test 1<br><img src=\"http://localhost/blog/application/assets/ae2a10ae49035d8c4c660aeb25e214a0e3a280a9.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-05-13 12:45:27', 0, 0, '2020-05-13 18:15:27', '2020-05-13 18:16:31', 'draft'),
(16, 28, 0, 'draft feature', 'draft-feature-v1', '<p>this a draft post 123</p>', '2020-05-13 13:38:47', 0, 0, '2020-05-13 19:08:47', '2020-05-13 19:08:47', 'draft'),
(17, 28, 0, 'test for draft', 'test-for-draft-v1', '<p>hduwhgjweg1241urdjhflje</p>', '2020-05-13 14:24:59', 0, 0, '2020-05-13 19:54:59', '2020-05-13 19:55:39', 'published');

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
(1, 'application/uploads/28/', '1223-v1.jpg', '', 'jpg', '0.01 MB', '1588334226.jpg', '2020-05-01 11:57:06'),
(2, 'application/uploads/28/', 'wpfontsize-180x180-v1.png', '', 'png', '0.02 MB', '1588345200.png', '2020-05-01 15:00:00'),
(3, 'application/uploads/28/john1/', 'single-handle200x180-v1.JPG', 'john1', 'JPG', '0.01 MB', '1588425330.JPG', '2020-05-02 13:15:30'),
(4, 'application/uploads/28/john/', 'Cactus-Removable-Wallpaper-200x180-v1.jpg', 'john', 'jpg', '0.03 MB', '1588425346.jpg', '2020-05-02 13:15:46');

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
(7, 7, 5),
(11, 14, 8),
(12, 14, 3),
(13, 15, 8),
(14, 15, 9),
(15, 16, 8),
(16, 17, 8);

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
(3, 'first'),
(4, 'froala'),
(5, 'video'),
(6, 'move'),
(7, 'test'),
(8, 'drafts'),
(9, 'image');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
