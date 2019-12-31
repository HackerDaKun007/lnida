-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-12-31 08:40:21
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `lnida`
--

-- --------------------------------------------------------

--
-- 表的结构 `da_admin`
--

CREATE TABLE `da_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(44) COLLATE utf8_unicode_ci NOT NULL,
  `encryption` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `disable` int(1) NOT NULL DEFAULT '1',
  `listed_id` int(11) DEFAULT '0',
  `contact` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_admin`
--

INSERT INTO `da_admin` (`admin_id`, `username`, `password`, `encryption`, `disable`, `listed_id`, `contact`, `img`, `create_time`, `update_time`) VALUES
(5, 'kefu', '160ad1029ca9112b5dac3b62bd5e89e760c000d9', '-lh^>0tw', 1, NULL, '吴坤盛', '20191227/13992cc803120c72e6652358a9a7c1e8.jpg', 1577415440, 1577427870);

-- --------------------------------------------------------

--
-- 表的结构 `da_channel`
--

CREATE TABLE `da_channel` (
  `channel_id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `disable` int(11) DEFAULT NULL,
  `back` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_channel`
--

INSERT INTO `da_channel` (`channel_id`, `username`, `disable`, `back`, `create_time`, `update_time`) VALUES
(4, '公共', 2, '', 1577737209, 1577737331);

-- --------------------------------------------------------

--
-- 表的结构 `da_chnumber`
--

CREATE TABLE `da_chnumber` (
  `chnumber_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `back` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disable` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_chnumber`
--

INSERT INTO `da_chnumber` (`chnumber_id`, `channel_id`, `username`, `back`, `disable`, `create_time`, `update_time`) VALUES
(2, 4, '002', '', 1, 1577738132, 1577738548),
(3, 4, '12', '222', 1, 1577738467, 1577738617),
(4, 4, '12222', '44', 1, 1577738555, 1577738555);

-- --------------------------------------------------------

--
-- 表的结构 `da_filetxt`
--

CREATE TABLE `da_filetxt` (
  `filetxt_id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `back` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_filetxt`
--

INSERT INTO `da_filetxt` (`filetxt_id`, `username`, `back`, `create_time`, `update_time`) VALUES
(5, 'test', '11', 1577724430, 1577724430);

-- --------------------------------------------------------

--
-- 表的结构 `da_group`
--

CREATE TABLE `da_group` (
  `group_id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `back` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_group`
--

INSERT INTO `da_group` (`group_id`, `username`, `back`, `create_time`, `update_time`) VALUES
(2, '印度市场', '测试阶段', 1577696186, 1577707847),
(3, '成人商品', '中国市场', 1577696225, 1577699976),
(4, '牛逼', '', 1577696235, 1577708242),
(5, '66', '', 1577720025, 1577721324),
(6, '77', '', 1577730191, 1577730191),
(7, '88', '', 1577730265, 1577730265),
(8, '999', '1', 1577730290, 1577730293);

-- --------------------------------------------------------

--
-- 表的结构 `da_html`
--

CREATE TABLE `da_html` (
  `html_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `html` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `back` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `da_html`
--

INSERT INTO `da_html` (`html_id`, `group_id`, `username`, `html`, `back`, `create_time`, `update_time`) VALUES
(1, 5, '12', 'Li8rjk24CSfxQOINGzavnBeZ775m02PY', '1111', 1577708210, 1577721330),
(2, 5, '123', '48Y3hTWuf3JKbM567jzSmw90BALpNknv', '11', 1577730376, 1577730383);

--
-- 转储表的索引
--

--
-- 表的索引 `da_admin`
--
ALTER TABLE `da_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- 表的索引 `da_channel`
--
ALTER TABLE `da_channel`
  ADD PRIMARY KEY (`channel_id`);

--
-- 表的索引 `da_chnumber`
--
ALTER TABLE `da_chnumber`
  ADD PRIMARY KEY (`chnumber_id`,`channel_id`);

--
-- 表的索引 `da_filetxt`
--
ALTER TABLE `da_filetxt`
  ADD PRIMARY KEY (`filetxt_id`);

--
-- 表的索引 `da_group`
--
ALTER TABLE `da_group`
  ADD PRIMARY KEY (`group_id`);

--
-- 表的索引 `da_html`
--
ALTER TABLE `da_html`
  ADD PRIMARY KEY (`html_id`),
  ADD KEY `group_id` (`group_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `da_admin`
--
ALTER TABLE `da_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `da_channel`
--
ALTER TABLE `da_channel`
  MODIFY `channel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `da_chnumber`
--
ALTER TABLE `da_chnumber`
  MODIFY `chnumber_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `da_filetxt`
--
ALTER TABLE `da_filetxt`
  MODIFY `filetxt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `da_group`
--
ALTER TABLE `da_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `da_html`
--
ALTER TABLE `da_html`
  MODIFY `html_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
