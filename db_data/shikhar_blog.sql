-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 04:46 PM
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
-- Database: `shikhar_blog`
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
(1, 1, 0, '', '', '<p>shikhar&#39;s blog <img src=\"http://localhost/ci-blog/./uploads/662d60f42e7819044e829d90df0ef7904de87496.png\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-08 15:37:21', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(4, 1, 0, '', '', '<p>another blog post by shikhar 3</p>', '2020-04-10 06:23:18', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(9, 1, 0, '', '', '<p>shikhar post to save in memcached 1</p>', '2020-04-10 15:10:04', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(14, 1, 0, '', '', '<p>shikhar again</p>', '2020-04-11 07:19:33', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(15, 1, 0, '', '', '<p>shikhar post with username</p>', '2020-04-11 13:51:24', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(16, 1, 0, '', '', '<p>blog post 123 4 heloo djwriwrnb</p>', '2020-04-13 10:05:35', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(17, 1, 0, '', '', '<p>recent post 123</p>', '2020-04-13 11:30:16', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(18, 1, 0, '', '', '<p><img src=\"http://localhost/blog/./uploads/360f783e2ba9c65bc7a2f7c0712f39288255c1da.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-13 11:30:58', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(19, 1, 0, 'blog with title', '', '<p>this the content of the titled blog</p>', '2020-04-13 15:28:42', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(20, 1, 0, 'title for the blog', 'title-for-the-blog-v1', '<p>1246gjvhynnvdsasdfd;dhjhuiu48t1234</p>', '2020-04-14 05:34:00', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(21, 1, 0, 'lorem ipsum', 'lorem-ipsum-v1', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><img src=\"http://localhost/blog/./uploads/c08633f14152fee6f43f1a83de7e717363877578.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '2020-04-14 09:25:26', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(26, 1, 0, 'lorem ipsum?', 'lorem-ipsum1-v1', '<p>qwertyiopasdfghjkl1234</p>', '2020-04-15 12:55:06', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published'),
(27, 1, 0, 'lorem ipsum!', 'lorem-ipsum2-v1', '<p>hey hey hey hey</p>', '2020-04-15 12:58:07', 0, 0, '0000-00-00 00:00:00', '2020-05-13 13:45:53', 'published');

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
(1, 'application/uploads/1/shikhar/', '1223-v1.jpg', 'shikhar', 'jpg', '0.01 MB', '1588427521.jpg', '2020-05-02 13:52:01'),
(2, 'application/uploads/1/shikhar1/', 'Elegantroom-200x180-v1.jpg', 'shikhar1', 'jpg', '0.01 MB', '1588427923.jpg', '2020-05-02 13:58:43');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
