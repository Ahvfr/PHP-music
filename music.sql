

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";




--
-- 数据库： `music`
--

-- --------------------------------------------------------

--
-- 表的结构 `gedan`
--

CREATE TABLE `gedan` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `imgpath` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `up_time` timestamp NOT NULL DEFAULT '2024-10-08 16:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `gedan`
--

INSERT INTO `gedan` (`id`, `name`, `author`, `imgpath`, `intro`, `type`, `hits`, `up_time`) VALUES
(1, '官方歌单_1', 'admin', '../static/images/官方歌单_1.jpg', '官方歌单', 1, 17, '2024-10-08 16:00:00'),
(2, '官方歌单_2', 'admin', '../static/images/官方歌单_2.jpg', '官方歌单', 1, 24, '2024-10-08 16:00:00'),
(3, '官方歌单_3', 'admin', '../static/images/官方歌单_3.jpg', '官方歌单', 1, 10, '2024-10-08 16:00:00'),
(4, '官方歌单_4', 'admin', '../static/images/官方歌单_4.jpg', '官方歌单', 1, 1, '2024-10-08 16:00:00'),
(6, '用户歌单_1', 'user1', '../static/images/用户歌单_1.jpg', '用户歌单', 0, 10, '2024-10-08 16:00:00'),
(7, '用户歌单_2', 'user2', '../static/images/用户歌单_2.jpg', '用户歌单', 0, 6, '2024-10-08 16:00:00'),
(8, '用户歌单_4', 'user4', '../static/images/用户歌单_4.jpg', '用户歌单', 0, 4, '2024-10-08 16:00:00'),
(9, '用户歌单_5', 'user5', '../static/images/用户歌单_5.png', '用户歌单', 0, 2, '2024-10-08 16:00:00'),
(10, '用户歌单_6', 'user6', '../static/images/用户歌单_6.jpg', '用户歌单', 0, 5, '2024-10-08 16:00:00'),
(11, '用户歌单_7', 'user7', '../static/images/用户歌单_7.jpg', '用户歌单', 0, 99, '2024-10-08 16:00:00'),
(12, '用户歌单_8', 'user8', '../static/images/用户歌单_8.jpg', '用户歌单', 0, 13, '2024-10-08 16:00:00'),
(13, '用户歌单_9', 'user9', '../static/images/用户歌单_9.jpg', '用户歌单', 0, 53, '2024-10-08 16:00:00'),
(14, '用户歌单_3', 'user3', '../static/images/用户歌单_3.png', '用户歌单', 0, 78, '2024-10-08 16:00:00'),
(23, 'user10', 'user10', '../static/images/用户歌单_3.png', 'user10的歌单', 0, 21, '2024-10-09 16:00:00'),
(24, '管理员的歌单', 'admin', '../static/images/管理员的歌单.png', '哈哈', 1, 2, '2024-10-08 16:00:00'),
(25, 'hh', 'admin', '../static/images/hh.jpg', 'hh', 1, 4, '2024-10-08 16:00:00'),
(26, 'user12的歌单', 'user12', '../static/images/用户歌单_3.png', 'user12', 0, 3, '2024-10-08 16:00:00'),
(27, '打上花火', 'user9', '../static/images/打上花火.jpg', '打上花火', 0, 4, '2024-10-08 16:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time` int(11) NOT NULL,
  `gedan` int(11) NOT NULL,
  `CheckMess` int(2) NOT NULL DEFAULT '1',
  `HitBack` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `username`, `content`, `time`, `gedan`, `CheckMess`, `HitBack`) VALUES
(3, 'user9', '测试', 1728440380, 27, 1, 0),
(6, 'user10', '1', 1728472247, 12, 0, 0),
(7, 'user10', '123', 1728488302, 2, 1, 0),
(8, 'user10', '123456', 1728488352, 3, 0, 0),
(9, 'user9', 'user9', 1728491867, 2, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `imgpath` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lyric` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '暂无歌词',
  `audiopath` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gedan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT ',',
  `hits` int(11) NOT NULL DEFAULT '0',
  `rgb` int(11) NOT NULL DEFAULT '0',
  `ndb` int(11) NOT NULL DEFAULT '0',
  `rhb` int(11) NOT NULL DEFAULT '0',
  `CheckMusic` int(2) NOT NULL DEFAULT '1',
  `HitBack` int(2) NOT NULL DEFAULT '0',
  `uid` int(2) NOT NULL DEFAULT '2',
  `up_time` date NOT NULL DEFAULT '2024-10-09',
  `reason` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `music`
--

INSERT INTO `music` (`id`, `name`, `author`, `imgpath`, `time`, `lyric`, `audiopath`, `gedan`, `hits`, `rgb`, `ndb`, `rhb`, `CheckMusic`, `HitBack`, `uid`, `up_time`, `reason`) VALUES
(1, '把回忆拼好给你', '把回忆拼好给你', '../static/images/music.png', '3.00', '把回忆拼好给你', '../static/music/把回忆拼好给你-王贰浪.mp3', '7,24,1,26,23,', 5652171, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(2, '壁上观', '壁上观', '../static/images/music.png', '3.00', '壁上观', '../static/music/壁上观.mp3 	', '2,24,1,23,', 28, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(3, '苦茶子', '苦茶子', '../static/images/music.png', '3.00', '苦茶子', '../static/music/苦茶子.mp3 	', '3,2,24,', 90, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(4, '烂泥', '烂泥', '../static/images/music.png', '3.00', '烂泥', '../static/music/烂泥.mp3', '4,24,', 4, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(5, '离别开出花', '离别开出花', '../static/images/music.png', '3.00', '离别开出花', '../static/music/离别开出花.mp3', '5,24,', 6855, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(6, '罗生门（Follow）', '罗生门（Follow）', '../static/images/music.png', '3.00', '罗生门（Follow）', '../static/music/罗生门（Follow）.mp3', '6,24,23,', 9559, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(28, '明天我在你身边', '明天我在你身边', '../static/images/music.png', '3.00', '明天我在你身边', '../static/music/明天我在你身边.mp3', '7,', 3549, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(29, '凄美地', '凄美地', '../static/images/music.png', '3.00', '凄美地', '../static/music/凄美地.mp3', '8,', 654357, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(30, '起风了', 'qw', '../static/images/music.png', '3.00', 'qwsd', '../static/music/起风了 - 买辣椒也用券.mp3', '9,', 548535, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(31, '如果爱忘了', 'qw', '../static/images/music.png', '3.00', 'qwsd', '../static/music/如果爱忘了.mp3', '9,', 350, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(32, '我记得', 'qw', '../static/images/music.png', '3.00', 'qwsd', '../static/music/我记得.mp3', '10,1,', 69, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(33, '醒了', 'qw', '../static/images/music.png', '3.00', 'qwsd', '../static/music/醒了.mp3', '12,1,', 358, 1, 0, 0, 1, 0, 2, '2024-10-10', 0),
(35, '银河系里的夏夜幻想', 'v', '../static/images/music.png', '3.00', '银河系里的夏夜幻想', '../static/music/银河系里的夏夜幻想.mp3', '1,', 562, 1, 1, 0, 1, 0, 2, '2024-10-10', 0),
(36, '与我无关 - 阿冗', '与我无关 - 阿冗', '../static/images/music.png', '3.00', '与我无关 - 阿冗', '../static/music/与我无关 - 阿冗.mp3', '12,25,', 258, 1, 1, 0, 1, 0, 2, '2024-10-10', 0),
(37, '再次爱上你', '再次爱上你', '../static/images/music.png', '3.00', 'qwsd', '../static/music/再次爱上你.mp3', '14,25,8,', 15853, 1, 0, 1, 1, 0, 2, '2024-10-10', 0),
(44, '1', 'qw', '../static/images/music.png', '3.00', 'qwsd', '../static/music/1.mp3', '25,26,8,11,13,23,', 0, 1, 0, 1, 1, 0, 2, '2024-10-10', 0),
(46, 'user12user12', 'user12user12', '../static/images/music.png', '3.00', 'user12user12', '../static/music/user12user12.mp3', '', 0, 1, 0, 0, 0, 1, 10, '2024-10-10', 1),
(48, 'user12', 'user12', '../static/images/music.png', '3.00', 'user12', '../static/music/user12.mp3', '', 0, 1, 0, 0, 0, 0, 10, '2024-10-10', 0),
(53, '打上花火', '打上花火', '../static/images/music.png', '3.00', 'qwsd', '../static/music/打上花火.mp3', '27,', 2, 1, 0, 0, 1, 0, 8, '2024-10-10', 0),
(54, '恋愛サーキ', '恋愛サーキ', '../static/images/music.png', '3.00', '恋愛サーキ', '../static/music/恋愛サーキュレーション.mp3', '', 2, 1, 0, 0, 1, 0, 8, '2024-10-10', 0),
(55, '天気の子', '天気の子', '../static/images/music.png', '3.00', '天気の子', '../static/music/天気の子.mp3', '', 0, 1, 0, 0, 1, 0, 8, '2024-10-10', 0),
(56, '11', '11', '../static/images/music.png', '3.00', '11', '../static/music/11.mp3', '', 0, 1, 0, 0, 1, 0, 8, '2024-10-10', 0),
(57, 'qw', 'qw', '../static/images/music.png', '3.00', 'qwsd1235645', '../static/music/qw.mp3', '', 0, 1, 0, 1, 0, 0, 9, '2024-10-10', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `txpath` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gxqm` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zcsj` int(11) DEFAULT NULL,
  `mail` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` int(5) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `txpath`, `nickname`, `phone`, `gxqm`, `zcsj`, `mail`, `type`) VALUES
(1, 'user1', 'f9d4049dd6a4dc35d40e5265954b2a46', '../static/images/user1.png', 'aaa', '12345678910', 'aaaa', 1727081673, '123456@qq.com', 2),
(2, 'admin', 'f9d4049dd6a4dc35d40e5265954b2a46', '../static/images/admin.png', '管理员', '11111111111', '管理员', 1727081673, '', 0),
(3, 'user2', '585028aa0f794af812ee3be8804eb14a', '../static/images/user2.jpg', '创作者', '64684618', '', 1727085368, '56484@1.com', 1),
(7, 'user3', '585028aa0f794af812ee3be8804eb14a', '../static/images/user3.jpg', '', 'a', '', 1727595382, 'a@a.com', 2),
(8, 'user9', '92c4f572f7e60eaabd584c7bd527af22', '../static/images/user.png', '', '', '', 1728136794, '', 1),
(9, 'user10', 'e77a7fcbf416b2bc88d9a27fcc098c10', '../static/images/user.png', '', '', '', 1728360918, '', 1),
(10, 'user12', '23cd17300143cc75935fb4b6087ac900', '../static/images/user12.png', '', '11111111111', '', 1728380755, '', 1);

--
-- 转储表的索引
--

--
-- 表的索引 `gedan`
--
ALTER TABLE `gedan`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `gedan`
--
ALTER TABLE `gedan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
