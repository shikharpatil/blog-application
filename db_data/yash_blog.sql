-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 06:21 AM
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
-- Database: `yash_blog`
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
(1, 23, 0, '', '', '<p>yash blog poast 123 updated blog<img src=\"http://localhost/ci-blog/./uploads/7d1f2c21b6006a99bdaaa67d5283b06e5ab9b91a.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-09 03:42:46', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 23, 0, '', '', '<p>1234 blog edit<img src=\"http://localhost/ci-blog/./uploads/b58a327aee62d232108d82ecf8c8c5bc0790afe3.png\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-09 07:25:39', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 23, 0, '', '', '<p>yash creates a post no 3</p>', '2020-04-10 13:25:25', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 23, 0, '', '', '<p>yash post to save in memcached 1</p>', '2020-04-10 15:10:27', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 23, 0, '', '', '<p>yaash post to save in memcached 2</p>', '2020-04-11 05:42:34', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 23, 0, '', '', '<p>save post in emcached 134h</p>', '2020-04-11 05:50:12', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 23, 0, '', '', '<p>yash post again 123yash</p>', '2020-04-11 05:57:52', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 23, 0, '', '', '<p>yash post to check dadt in memcached 1234mem</p>', '2020-04-11 06:39:11', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 23, 0, '', '', '<p>yash post to check key</p>', '2020-04-11 07:15:19', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 23, 0, '', '', '<p>yash post again 1234566788</p>', '2020-04-11 07:16:32', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 23, 0, '', '', '<p>yash again</p>', '2020-04-11 07:18:49', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 23, 0, '', '', '<p>check post if occurs in feed or not</p>', '2020-04-11 10:06:33', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 23, 0, '', '', '<p>check for post occures in the feed or not 2</p>', '2020-04-11 12:50:33', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 23, 0, '', '', '<p>another post by yash 123</p>', '2020-04-11 13:48:05', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 23, 0, '', '', '<p>yash blog with username<br><br><img src=\"http://localhost/blog/./uploads/1c5fb3d1e8c7b9f4f98811b0950b88e4f1d5a352.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-fil\"></p>', '2020-04-11 14:27:32', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 23, 0, '', '', '<p>yash made a blog here 123oiuieigq&nbsp;</p>', '2020-04-13 04:37:54', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 23, 0, 'yash created by blog.', 'yash-created-by-blog.', '<p>this is the blog content, hello 12345</p>', '2020-04-14 06:57:39', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 23, 0, 'blog with image', 'blog-with-image', '<p><img src=\"http://localhost/blog/./uploads/ffd28febee876929d25056da51fbb86c621757fe.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-14 07:58:23', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 23, 0, 'mybblog', 'mybblog', '<p>qwertyuiopasdfghjl123098000000</p>', '2020-04-16 03:37:43', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 23, 24, 'mybblog', 'mybblog', '<p>qwertyuiopasdfghjl</p>', '2020-04-18 14:00:51', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 23, 22, 'yash created by blog.', 'yash-created-by-blog.', '<p>this is the blog content</p>', '2020-04-18 14:17:27', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(1, 24, 'shikhar', 'nice blog comment by shikhar', '2020-04-17 13:06:02'),
(2, 24, 'ravi', 'nice blog comment by ravi', '2020-04-17 13:12:07'),
(3, 24, 'ravi', 'ravi comments again', '2020-04-17 13:14:14'),
(4, 24, 'ravi', 'ravi comment 3', '2020-04-17 13:21:40'),
(5, 24, 'shikhar', 'shikhar comment again', '2020-04-17 13:25:17'),
(6, 24, 'shikhar', 'good blog', '2020-04-17 13:25:28');

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
(1, 'application/uploads/23/yash/', 'doc export-v1.png', 'yash', 'png', '0.07 MB', '1588433437.png', '2020-05-02 15:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `post_tag_ids`
--

CREATE TABLE `post_tag_ids` (
  `id` int(11) NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
