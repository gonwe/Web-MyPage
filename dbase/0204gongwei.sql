-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 12 月 25 日 13:32
-- 服务器版本: 5.5.38
-- PHP 版本: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `0204gongwei`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(10) NOT NULL,
  `passwd` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`username`, `passwd`) VALUES
('lsw', 'lsw'),
('admin', 'admin'),
('gw', '0204');

-- --------------------------------------------------------

--
-- 表的结构 `guest`
--

CREATE TABLE IF NOT EXISTS `guest` (
  `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'ID主键自增',
  `name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `phone` char(11) DEFAULT '' COMMENT '手机号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `time` datetime DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `guest`
--

INSERT INTO `guest` (`id`, `name`, `phone`, `email`, `time`, `message`) VALUES
(2, '白色球鞋', '13258522023', 'dhphp@shou.cn', '2019-12-26 11:33:46', '有一条路不能选择――那就是放弃。'),
(3, '半句羞', '13258522024', 'dhphp@shou.cn', '2019-12-27 11:33:46', '没有一种不通过蔑视、忍受和奋斗就可以征服的命运。'),
(4, 'o骨子里傲', '13258522025', 'dhphp@shou.cn', '2019-12-28 11:33:46', '勇气不是感觉不到恐惧而是感觉到恐惧也继续做下去。'),
(5, '小呀么小土豪', '13258522026', 'dhphp@shou.cn', '2019-12-29 11:33:46', '记住：你是你生命的船长;走自己的路，何必在乎其它。'),
(6, '浪野少女心', '13258522027', 'dhphp@shou.cn', '2019-12-30 11:33:46', '不去追逐，永远不会拥有。不往前走，永远原地停留。'),
(7, '★余是yuan方~', '13258522028', 'dhphp@shou.cn', '2019-12-31 11:33:46', '没有所谓失败，除非你不再尝试。'),
(8, '述情', '13258522029', 'dhphp@shou.cn', '2020-01-01 11:33:46', '立志趁早点，上路轻松点，目光放远点，苦累看淡点，努力多一点，奋斗勇一点，胜利把名点，祝你折桂冠，成功新起点，幸福多一点，笑容亮一点。'),
(9, '魍魉影魅', '13258522030', 'dhphp@shou.cn', '2020-01-02 11:33:46', '有一条路不能选择――那就是放弃。'),
(10, '、Really', '13258522031', 'dhphp@shou.cn', '2020-01-03 11:33:46', '没有一种不通过蔑视、忍受和奋斗就可以征服的命运。'),
(11, '小朋友', '13258522032', 'dhphp@shou.cn', '2020-01-04 11:33:46', '勇气不是感觉不到恐惧而是感觉到恐惧也继续做下去。'),
(12, '多啦爱A梦', '13258522033', 'dhphp@shou.cn', '2020-01-05 11:33:46', '记住：你是你生命的船长;走自己的路，何必在乎其它。'),
(13, '回心韩意。', '13258522034', 'dhphp@shou.cn', '2020-01-06 11:33:46', '愚痴的人，一直想要别人了解他。有智慧的人，却努力的了解自己。'),
(14, '蒲公英的四处飘散', '13258522035', 'dhphp@shou.cn', '2020-01-07 11:33:45', '生命的道路上永远没有捷径可言，只有脚踏实地走下去。'),
(15, '拼了老命在学习i', '13258522036', 'dhphp@shou.cn', '2020-01-08 11:33:45', '只要还有明天，今天就永远是起跑线。');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
