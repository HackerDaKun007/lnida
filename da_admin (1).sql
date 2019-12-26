-- phpMyAdmin SQL Dump
-- version 5.0.0-rc1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-12-26 14:29:13
-- 服务器版本： 5.7.28
-- PHP 版本： 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `da_admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `da_admin`
--

CREATE TABLE `da_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `encryption` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `disable` int(1) NOT NULL DEFAULT '1',
  `listed_id` int(11) DEFAULT NULL,
  `contact` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `da_admin`
--
ALTER TABLE `da_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `da_admin`
--
ALTER TABLE `da_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

