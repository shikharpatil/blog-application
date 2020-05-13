-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 06:20 AM
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
-- Database: `ravi_blog`
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
(1, 25, 0, '', '', '<p>ravi 123 blog<img src=\"http://localhost/ci-blog/./uploads/45dbc4616454dfb1f3fbea8e1ff86a9c00e59e5f.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-08 14:31:54', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 25, 0, '', '', '<p>ravi&#39;S post made for fed check 123</p>', '2020-04-13 05:32:49', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 25, 0, 'blog by ravi ', 'blog-by-ravi-v1', '<p><br><br><img src=\"http://localhost/blog/./uploads/0cee18c1a41e168c91edffc038bfb02b871243c2.png\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-fil\"></p><p><br></p><p>here is my blog</p>', '2020-04-17 13:28:51', 0, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 25, 4, 'blog by ravi ', 'blog-by-ravi-v2', '<p><br><br><img src=\"http://localhost/blog/./uploads/0cee18c1a41e168c91edffc038bfb02b871243c2.png\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-fil\"></p><p><br></p><p>here is my blog 1234</p>', '2020-04-22 12:58:30', 0, 0, '0000-00-00 00:00:00', '2020-04-23 12:30:46'),
(6, 25, 5, 'blog by ravi ', 'blog-by-ravi-v3', '<p><br><br><img src=\"http://localhost/blog/./uploads/0cee18c1a41e168c91edffc038bfb02b871243c2.png\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-fil\"></p><p><br></p><p>here is my blog 1234 version 3 is created</p>', '2020-04-23 07:00:46', 0, 0, '2020-04-23 12:30:46', '2020-04-24 15:56:20'),
(7, 25, 0, 'ravi did post with tag', 'ravi-did-post-with-tag-v1', '<p>hello hello 123 ravi qweryt</p>', '2020-04-27 09:05:51', 0, 0, '2020-04-27 14:35:51', '2020-04-27 14:35:51'),
(8, 25, 0, 'cricket post', 'cricket-post-v1', '<p>play cricket</p>', '2020-04-27 11:34:28', 0, 0, '2020-04-27 17:04:28', '2020-04-27 17:04:28');

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
(1, 4, 'ravi', 'my blog comment by ravi', '2020-04-17 13:29:47'),
(2, 4, 'shikhar', 'good blog', '2020-04-17 13:30:21');

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
(1, 7, 1),
(2, 7, 2),
(3, 8, 3),
(4, 8, 4);

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
(1, 'first'),
(2, 'tagging'),
(3, 'cricket'),
(4, 'sports'),
(5, 'travel'),
(6, 'adventure');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
