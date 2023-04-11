-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.5.19-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------


DROP TABLE IF EXISTS `board_info`;
CREATE TABLE IF NOT EXISTS `board_info` (
  `board_no` int(11) NOT NULL AUTO_INCREMENT,
  `board_title` varchar(100) NOT NULL,
  `board_cont` varchar(1000) NOT NULL,
  `create_date` datetime NOT NULL,
  `del_flag` char(1) NOT NULL DEFAULT '0',
  `delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`board_no`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `board_info` (`board_no`, `board_title`, `board_cont`, `create_date`, `del_flag`, `delete_date`) VALUES
	(1, '제목 1', '내용 1', '2023-04-10 11:04:33', '0', NULL),
	(2, '제목 2', '내용 2', '2023-04-10 11:05:04', '0', NULL),
	(3, '제목 3', '내용 3', '2023-04-10 11:05:09', '0', NULL),
	(4, '제목 4', '내용 4', '2023-04-10 11:05:13', '0', NULL),
	(5, '제목 5', '내용 5', '2023-04-10 11:05:19', '0', NULL),
	(6, '제목 6', '내용 6', '2023-04-10 11:05:23', '0', NULL),
	(7, '제목 7', '내용 7', '2023-04-10 11:05:28', '0', NULL),
	(8, '제목 8', '내용 8', '2023-04-10 11:05:32', '0', NULL),
	(9, '제목 9', '내용 9', '2023-04-10 11:05:37', '0', NULL),
	(10, '제목 10', '내용 10', '2023-04-10 11:05:41', '0', NULL),
	(11, '제목 11', '내용 11', '2023-04-10 11:05:48', '0', NULL),
	(12, '제목 12', '내용 12', '2023-04-10 11:05:52', '0', NULL),
	(13, '제목 13', '내용 13', '2023-04-10 11:05:57', '0', NULL),
	(14, '제목 14', '내용 14', '2023-04-10 11:06:01', '0', NULL),
	(15, '제목 15', '내용 15', '2023-04-10 11:06:06', '0', NULL),
	(16, '제목 16', '내용 16', '2023-04-10 11:06:09', '0', NULL),
	(17, '제목 17', '내용 17', '2023-04-10 11:06:14', '0', NULL),
	(18, '제목 18', '내용 18', '2023-04-10 11:06:17', '0', NULL),
	(19, '제목 19', '내용 19', '2023-04-10 11:06:24', '0', NULL),
	(20, '제목 20', '내용 20', '2023-04-10 11:06:30', '0', NULL);