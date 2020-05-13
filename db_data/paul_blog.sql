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
-- Database: `paul_blog`
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
(1, 30, 0, 'froala editor options', 'froala-editor-options-v1', '<p><strong>dweg<em>gwrw</em></strong><u>berhwrh<s>ererhrh<sub>r3h3</sub></s></u>rwrhw<sup>rwrywr<span style=\"font-family: \n        Georgia,serif;\">wr</span></sup><span style=\"font-family: \n        Georgia,serif;\">hrhrhrh</span><span style=\"font-family: Verdana, Geneva, sans-serif;\">etrethet</span><span style=\"font-family: \n        Arial,Helvetica,sans-serif;\">ethethe<span style=\"font-size: \n      11px;\">erhrherh</span><span style=\"font-size: 10px;\">rwh</span><span style=\"font-size: \n      14px;\">rh35h</span><span style=\"font-size: 14px; color: rgb(250, 197, 28);\">35h35h</span><span style=\"font-size: 14px; color: rgb(250, 197, 28); background-color: rgb(65, 168, 95);\">35h3h</span></span></p>', '2020-05-08 06:55:10', 0, 0, '2020-05-08 12:25:10', '2020-05-09 19:55:28'),
(2, 30, 0, 'just a post', 'just-a-post-v1', '<p>hererjhfjkhh;g;dfnowrgj</p>', '2020-05-06 15:25:20', 0, 0, '2020-05-06 20:55:20', '2020-05-09 20:15:54'),
(3, 30, 0, 'john post with tag', 'john-post-with-tag-v1', '<p>hwqerpuyjsdljkbvkjs 3695</p>', '2020-04-28 06:57:40', 0, 0, '2020-04-28 12:27:40', '2020-05-11 12:55:40'),
(7, 30, 0, 'travel post', 'travel-post-v1', '<p>i like travel</p>', '2020-04-27 12:27:53', 0, 0, '2020-04-27 17:57:53', '2020-05-11 17:50:54'),
(8, 30, 7, 'travel post', 'travel-post-v2', '<p>i like travel 1241359up</p>', '2020-05-05 06:19:08', 0, 0, '2020-05-05 11:49:08', '2020-05-11 17:50:54'),
(9, 30, 0, 'move check post', 'move-check-post-v1', '<p>post to check move operation</p>', '2020-05-11 12:24:21', 0, 0, '2020-05-11 17:54:21', '2020-05-11 18:06:00'),
(10, 30, 9, 'move check post', 'move-check-post-v2', '<p>post to check move operation edited with version</p>', '2020-05-11 12:24:49', 0, 0, '2020-05-11 17:54:49', '2020-05-11 18:06:00'),
(11, 30, 0, 'move post again', 'move-post-again-v1', '<p>move post test with versions</p>', '2020-05-11 13:36:40', 0, 0, '2020-05-11 19:06:40', '2020-05-11 19:33:58'),
(12, 30, 11, 'move post again', 'move-post-again-v2', '<p>move post test with versions edited version</p>', '2020-05-11 13:44:06', 0, 0, '2020-05-11 19:14:06', '2020-05-11 19:33:58'),
(13, 30, 0, 'a post with tags ', 'a-post-with-tags-v1', '<p>content of the post with tags</p>', '2020-04-25 11:43:07', 0, 0, '2020-04-25 17:13:07', '2020-05-12 12:14:49'),
(14, 30, 13, 'a post with tags ', 'a-post-with-tags-v2', '<p>content of the post with tags version 2</p>', '2020-05-04 12:52:50', 0, 0, '2020-05-04 18:22:50', '2020-05-12 12:14:49'),
(15, 30, 0, 'john post again', 'john-post-again-v1', '<p>hell0o i14o1idkjlhs</p>', '2020-04-28 06:54:42', 0, 0, '2020-04-28 12:24:42', '2020-05-12 12:27:05'),
(16, 30, 15, 'john post again', 'john-post-again-v2', '<p>hell0o i14o1idkjlhs version edited</p>', '2020-05-12 06:55:06', 0, 0, '2020-05-12 12:25:06', '2020-05-12 12:27:05'),
(17, 30, 0, 'this the url title', 'this-the-url-title-v1', '<p>blog to check post with url</p>', '2020-04-13 15:35:42', 0, 0, '0000-00-00 00:00:00', '2020-05-12 14:38:15'),
(18, 30, 17, 'this the url title', 'this-the-url-title-v2', '<p>blog to check post with url version 2</p>', '2020-04-20 13:24:25', 0, 0, '0000-00-00 00:00:00', '2020-05-12 14:38:15'),
(19, 30, 18, 'this the url title', 'this-the-url-title-v3', '<p>blog to check post with url version 3</p>', '2020-04-20 13:40:57', 0, 0, '0000-00-00 00:00:00', '2020-05-12 14:38:15'),
(20, 30, 19, 'this the url title', 'this-the-url-title-v4', '<p>blog to check post with url version 4</p>', '2020-04-22 09:07:22', 0, 0, '0000-00-00 00:00:00', '2020-05-12 14:38:15'),
(21, 30, 20, 'this the url title', 'this-the-url-title-v5', '<p>blog to check post with url version 4</p>', '2020-04-22 09:50:28', 0, 0, '0000-00-00 00:00:00', '2020-05-12 14:38:15'),
(22, 30, 0, 'copy-just a post', 'copy-just-a-post-v1', '<p>hererjhfjkhh;g;dfnowrgj</p>', '2020-05-06 15:25:20', 0, 0, '2020-05-06 20:55:20', '2020-05-13 09:14:36');

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
(1, 1, 'john', 'john post to be moved 1', '2020-05-09 14:25:28'),
(2, 1, 'john', 'john post to be moved\n', '2020-05-09 14:25:28'),
(3, 7, 'john', '<p>ajax comment edited comment</p>', '2020-05-11 12:20:54'),
(4, 7, 'john', '<p>ajax comment edited comment 2</p>', '2020-05-11 12:20:54'),
(5, 8, 'john', '<p>ajax comment edited comment</p>', '2020-05-11 12:20:54'),
(6, 8, 'john', '<p>ajax comment edited comment 2</p>', '2020-05-11 12:20:54'),
(7, 9, 'john', 'comment on post v2 ', '2020-05-11 12:36:00'),
(8, 10, 'john', 'comment on post v2 ', '2020-05-11 12:36:00'),
(9, 11, 'john', 'comment in parent post test for move', '2020-05-11 14:03:58'),
(10, 12, 'john', 'comment on post version 2', '2020-05-11 14:03:58'),
(11, 14, 'john', 'comment with ajax 3', '2020-05-12 06:44:49'),
(12, 14, 'john', 'comment with ajax 2', '2020-05-12 06:44:49'),
(13, 14, 'john', 'comment with ajax post', '2020-05-12 06:44:49'),
(14, 15, 'john', 'comment on version 1 only hell0o i14o1idkjlhs', '2020-05-12 06:57:05'),
(15, 17, 'karan', 'hello ', '2020-05-12 09:08:15'),
(16, 18, 'karan', '1213t1', '2020-05-12 09:08:15'),
(17, 21, 'john', '<p>comment through ajax 2 edited comment</p>', '2020-05-12 09:08:15'),
(18, 21, 'john', '<p><img src=\"http://localhost/blog/application/assets/b7b1445e352ae9a0ad694065f834ff01bb581ab9.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\">comment through ajax 2</p>', '2020-05-12 09:08:15'),
(19, 21, 'john', '<p>comment through ajax edited qiuqr</p>', '2020-05-12 09:08:15'),
(20, 21, 'john', '<p>qwiyioefew hello</p>', '2020-05-12 09:08:15'),
(21, 21, 'john', '<p>hello edited hello</p>', '2020-05-12 09:08:15');

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
(1, 'application/uploads/30/', 'Elegantroom-200x180-v1.jpg', '', 'jpg', '0.01 MB', '1588407354.jpg', '2020-05-02 08:15:54');

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
(1, 1, 1),
(2, 2, 2),
(3, 11, 3),
(4, 11, 4),
(5, 13, 2),
(6, 13, 5),
(7, 22, 2);

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
(1, 'froala'),
(2, 'first'),
(3, 'move'),
(4, 'test'),
(5, 'tagging');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_tag_ids`
--
ALTER TABLE `post_tag_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
