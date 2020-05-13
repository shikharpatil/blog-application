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
-- Database: `blog_user`
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
(1, 24, 0, 'hello', 'hello-v1', 'qwrty', '2020-04-23 05:51:02', 0, 0, '2020-04-23 11:21:02', '2020-04-23 11:22:22'),
(3, 2, 0, 'hello 1234 qwerty', 'hello-1234-qwerty-v1', 'qwertyuiop', '2020-04-23 11:21:12', 0, 0, '2020-04-23 16:51:12', '2020-04-23 16:51:12'),
(4, 2, 0, 'hello 1234 qwerty', 'hello-1234-qwerty-v1', 'qwertyuiop', '2020-04-23 11:22:10', 0, 0, '2020-04-23 16:52:10', '2020-04-23 16:52:10'),
(5, 2, 0, 'hello 1234 qwerty', 'hello-1234-qwerty-v1', 'qwertyuiop', '2020-04-23 11:22:12', 0, 0, '2020-04-23 16:52:12', '2020-04-23 16:52:12'),
(6, 2, 0, 'hello 1234 qwerty', 'hello-1234-qwerty-v1', 'qwertyuiop', '2020-04-23 11:22:38', 0, 0, '2020-04-23 16:52:38', '2020-04-23 16:52:38'),
(7, 2, 0, 'hello 1234 qwerty', 'hello-1234-qwerty-v1', 'qwertyuiop', '2020-04-23 14:05:01', 0, 0, '2020-04-23 19:35:01', '2020-04-23 19:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `post_tag_ids`
--

CREATE TABLE `post_tag_ids` (
  `id` int(11) NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `database_name` varchar(20) NOT NULL,
  `database_hostname` varchar(20) NOT NULL,
  `database_username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `date_time`, `database_name`, `database_hostname`, `database_username`) VALUES
(1, 'shikhar', '123', '2020-04-07 12:20:47', 'shikhar_blog', 'localhost', 'root'),
(23, 'yash', '1234', '2020-04-08 10:39:58', 'yash_blog', 'localhost', 'root'),
(24, 'karan', '1234', '2020-04-08 11:16:32', 'karan_blog', 'localhost', 'root'),
(25, 'ravi', '1234', '2020-04-08 11:31:53', 'ravi_blog', 'localhost', 'root'),
(26, 'parv', '1234', '2020-04-09 11:05:19', 'parv_blog', 'localhost', 'root'),
(28, 'john', '1234', '2020-04-20 15:38:53', 'john_blog', 'localhost', 'root'),
(29, 'mary', '1234', '2020-04-25 13:34:00', 'mary_blog', 'localhost', 'root'),
(30, 'paul', '1234', '2020-05-02 08:15:26', 'paul_blog', 'localhost', 'root');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
