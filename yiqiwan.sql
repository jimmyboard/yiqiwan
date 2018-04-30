-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Apr 22, 2015 at 11:03 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `yiqiwandb`
--

-- --------------------------------------------------------

--
-- Table structure for table `match_conversation`
--

CREATE TABLE `match_conversation` (
`c_id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `content` varchar(10000) DEFAULT NULL,
  `c_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `match_response`
--

CREATE TABLE `match_response` (
`response_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `response` tinyint(4) DEFAULT NULL,
  `response_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `match_response`
--

INSERT INTO `match_response` (`response_id`, `user_id`, `topic_id`, `response`, `response_date`) VALUES
(111, 5, 1, NULL, '2015-04-22 15:09:39'),
(112, 5, 2, NULL, '2015-04-22 15:09:39'),
(113, 5, 3, NULL, '2015-04-22 15:09:39'),
(114, 5, 4, NULL, '2015-04-22 15:09:39'),
(115, 5, 5, NULL, '2015-04-22 15:09:39'),
(116, 5, 6, 1, '2015-04-22 15:09:39'),
(117, 5, 7, NULL, '2015-04-22 15:09:39'),
(118, 5, 8, NULL, '2015-04-22 15:09:39'),
(119, 5, 9, NULL, '2015-04-22 15:09:39'),
(120, 5, 10, NULL, '2015-04-22 15:09:39'),
(121, 6, 1, NULL, '2015-04-22 15:11:49'),
(122, 6, 2, 1, '2015-04-22 15:11:49'),
(123, 6, 3, NULL, '2015-04-22 15:11:49'),
(124, 6, 4, NULL, '2015-04-22 15:11:49'),
(125, 6, 5, NULL, '2015-04-22 15:11:49'),
(126, 6, 6, NULL, '2015-04-22 15:11:49'),
(127, 6, 7, NULL, '2015-04-22 15:11:49'),
(128, 6, 8, NULL, '2015-04-22 15:11:49'),
(129, 6, 9, NULL, '2015-04-22 15:11:49'),
(130, 6, 10, NULL, '2015-04-22 15:11:49'),
(131, 7, 1, NULL, '2015-04-22 15:11:10'),
(132, 7, 2, 1, '2015-04-22 15:11:10'),
(133, 7, 3, NULL, '2015-04-22 15:11:10'),
(134, 7, 4, NULL, '2015-04-22 15:11:10'),
(135, 7, 5, NULL, '2015-04-22 15:11:10'),
(136, 7, 6, NULL, '2015-04-22 15:11:10'),
(137, 7, 7, NULL, '2015-04-22 15:11:10'),
(138, 7, 8, NULL, '2015-04-22 15:11:10'),
(139, 7, 9, NULL, '2015-04-22 15:11:10'),
(140, 7, 10, NULL, '2015-04-22 15:11:10'),
(141, 8, 1, NULL, '2015-04-17 09:57:22'),
(142, 8, 2, NULL, '2015-04-17 09:57:22'),
(143, 8, 3, NULL, '2015-04-17 09:57:22'),
(144, 8, 4, 1, '2015-04-17 09:57:22'),
(145, 8, 5, NULL, '2015-04-17 09:57:22'),
(146, 8, 6, NULL, '2015-04-17 09:57:22'),
(147, 8, 7, NULL, '2015-04-17 09:57:22'),
(148, 8, 8, NULL, '2015-04-17 09:57:22'),
(149, 8, 9, NULL, '2015-04-17 09:57:22'),
(150, 8, 10, NULL, '2015-04-17 09:57:22'),
(151, 9, 1, NULL, '2015-04-17 10:09:58'),
(152, 9, 2, NULL, '2015-04-17 10:09:58'),
(153, 9, 3, NULL, '2015-04-17 10:09:58'),
(154, 9, 4, NULL, '2015-04-17 10:09:58'),
(155, 9, 5, NULL, '2015-04-17 10:09:58'),
(156, 9, 6, 1, '2015-04-17 10:09:58'),
(157, 9, 7, NULL, '2015-04-17 10:09:58'),
(158, 9, 8, NULL, '2015-04-17 10:09:58'),
(159, 9, 9, NULL, '2015-04-17 10:09:58'),
(160, 9, 10, NULL, '2015-04-17 10:09:58'),
(161, 10, 1, NULL, '2015-04-17 10:11:47'),
(162, 10, 2, NULL, '2015-04-17 10:11:47'),
(163, 10, 3, NULL, '2015-04-17 10:11:47'),
(164, 10, 4, NULL, '2015-04-17 10:11:47'),
(165, 10, 5, NULL, '2015-04-17 10:11:47'),
(166, 10, 6, NULL, '2015-04-17 10:11:47'),
(167, 10, 7, 1, '2015-04-17 10:11:47'),
(168, 10, 8, NULL, '2015-04-17 10:11:47'),
(169, 10, 9, NULL, '2015-04-17 10:11:47'),
(170, 10, 10, NULL, '2015-04-17 10:11:47'),
(171, 11, 1, NULL, '2015-04-17 10:16:29'),
(172, 11, 2, NULL, '2015-04-17 10:16:29'),
(173, 11, 3, 1, '2015-04-17 10:16:29'),
(174, 11, 4, NULL, '2015-04-17 10:16:29'),
(175, 11, 5, NULL, '2015-04-17 10:16:29'),
(176, 11, 6, NULL, '2015-04-17 10:16:29'),
(177, 11, 7, NULL, '2015-04-17 10:16:29'),
(178, 11, 8, NULL, '2015-04-17 10:16:29'),
(179, 11, 9, NULL, '2015-04-17 10:16:29'),
(180, 11, 10, NULL, '2015-04-17 10:16:29'),
(181, 13, 1, NULL, '2015-04-22 16:22:08'),
(182, 13, 2, NULL, '2015-04-22 16:22:08'),
(183, 13, 3, 1, '2015-04-22 16:22:08'),
(184, 13, 4, NULL, '2015-04-22 16:22:08'),
(185, 13, 5, NULL, '2015-04-22 16:22:08'),
(186, 13, 6, NULL, '2015-04-22 16:22:08'),
(187, 13, 7, NULL, '2015-04-22 16:22:08'),
(188, 13, 8, NULL, '2015-04-22 16:22:08'),
(189, 13, 9, NULL, '2015-04-22 16:22:08'),
(190, 13, 10, NULL, '2015-04-22 16:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `match_topic`
--

CREATE TABLE `match_topic` (
`topic_id` int(11) NOT NULL,
  `name` varchar(48) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `match_topic`
--

INSERT INTO `match_topic` (`topic_id`, `name`) VALUES
(1, 'HTML&CSS'),
(2, 'JavaScript'),
(3, 'Python'),
(4, 'Node.js'),
(5, 'Rails'),
(6, 'PHP'),
(7, 'iOS'),
(8, 'Andriod'),
(9, 'Photoshop'),
(10, 'Illustrator');

-- --------------------------------------------------------

--
-- Table structure for table `match_user`
--

CREATE TABLE `match_user` (
`user_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `join_date` datetime DEFAULT NULL,
  `real_name` varchar(32) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `area` varchar(32) DEFAULT NULL,
  `street` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `resume` varchar(10000) DEFAULT NULL,
  `job` varchar(500) DEFAULT NULL,
  `education` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `match_user`
--

INSERT INTO `match_user` (`user_id`, `username`, `password`, `join_date`, `real_name`, `gender`, `picture`, `area`, `street`, `email`, `resume`, `job`, `education`) VALUES
(5, 'beckhambeckhambeckhambeckhambe', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 09:18:51', NULL, 'M', 'nick.jpg', '罗湖区', '东湖街道', 'jumijie1@163.com', '', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(6, 'March_Liu', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 09:35:20', NULL, 'M', 'rocket.jpg', '南山区', '招商街道', 'jumijie2@163.com', '膘的blog:   挖坑不填是一种美德   追寻智慧之美   [好看簿] 曾经未来 的好看簿 \r\nblog地址：http://marchliu.github.com/\r\n数学系的数盲\r\n\r\n偏头痛的不爱运动中年男胖子\r\n\r\n野生程序员\r\n\r\n野生架构师\r\n\r\n野生产品经理\r\n\r\nTutorial 终结者\r\n\r\nPython Tutorial 2.3、2.4、2.5、2.7、3.0 简体中文。\r\n\r\nCommon Lisp Tutorial 简体中文版。\r\n\r\nReal World Haskell 两章（Lee大我对不起你⋯⋯', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(7, 'M. Tong', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 09:42:46', NULL, 'M', 'super_nick.jpg', '南山区', '招商街道', 'jumijie3@163.com', 'M. Tong的blog:   童牧晨玄的工作坊   M. Tong''s Neverland \r\nblog地址：www.mastermindcn.com\r\n87年生人。数据挖掘，机器学习\r\n\r\n喜欢的编程语言：Clojure\r\n\r\n更多地使用Twitter进行信息收集: @demon386\r\n\r\nGithub: http://www.jumijie.com/', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(8, 'Ryutlis', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 09:56:42', NULL, 'M', 'ul1209238-19.jpg', '宝安区', '民治街道', 'jumijie4@163.com', 'Ryutlis的blog:   Ryutlism \r\nFind my daily updates on twitter: \r\nhttp://twitter.com/ryutlis\r\n\r\nMy photos are here:\r\nhttp://instagram.com/ryutlis/\r\n\r\nSimplicity is the ultimate sophistication.\r\n-- Leonardo da Vinci\r\n\r\nVictorious warriors win first and then go to war, while defeated warriors go to war first and then seek to win.', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(9, 'tottily', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 09:58:08', NULL, 'M', 'ul1259573-20.jpg', '福田区', '南园街道', 'jumijie5@163.com', '拖地的blog:   " 人可乂'' ...... " \r\nhttp://www.zhihu.com/people/think\r\n\r\n伪宅男，喜欢起床前暖暖的被窝。\r\n\r\n每天24小时都在开心的生活着。\r\n\r\n踢球的时候被对手说 “那个胖子”......\r\n\r\n呵呵', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(10, 'liuwt123', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 10:10:53', NULL, 'M', 'ul1281994-45.jpg', '南山区', '桃源街道', 'jumijie6@163.com', '业余编码人，创客爱好者，喜新鲜事物，好涉猎，不求甚解，拖延症，头大心粗！\r\nhttp://blog.iscsky.net', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(11, 'gengrenjie', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-17 10:13:00', NULL, 'M', '11shuai.jpg', '南山区', '粤海街道', 'jumijie7@163.com', 'gengrenjie的blog:   耿人杰的网络日志 (未认领) \r\n工程师爸爸：appshare.cn\r\nblog地址：http://gengrenjie.com\r\n耿人杰，男，上海，关注用户体验设计，儿童教育，移动互联网', '深圳市大疆创新科技有限公司 产品经理', '深圳职业技术学院 10届法律事务专业'),
(12, 'wanwan', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-21 23:50:38', NULL, NULL, NULL, '南山区', '招商街道', 'jumijie8@163.com', NULL, NULL, NULL),
(13, 'jumijie9', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2015-04-22 16:21:45', NULL, NULL, NULL, '罗湖区', '南湖街道', 'jumijie9@163.com', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match_conversation`
--
ALTER TABLE `match_conversation`
 ADD PRIMARY KEY (`c_id`), ADD KEY `user_one` (`user_one`), ADD KEY `user_two` (`user_two`);

--
-- Indexes for table `match_response`
--
ALTER TABLE `match_response`
 ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `match_topic`
--
ALTER TABLE `match_topic`
 ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `match_user`
--
ALTER TABLE `match_user`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `match_conversation`
--
ALTER TABLE `match_conversation`
MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `match_response`
--
ALTER TABLE `match_response`
MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT for table `match_topic`
--
ALTER TABLE `match_topic`
MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `match_user`
--
ALTER TABLE `match_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `match_conversation`
--
ALTER TABLE `match_conversation`
ADD CONSTRAINT `match_conversation_ibfk_1` FOREIGN KEY (`user_one`) REFERENCES `match_user` (`user_id`),
ADD CONSTRAINT `match_conversation_ibfk_2` FOREIGN KEY (`user_two`) REFERENCES `match_user` (`user_id`);
