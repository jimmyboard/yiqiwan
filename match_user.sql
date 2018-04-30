CREATE DATABASE `yiqiwandb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `match_user` (
  `user_id` INT AUTO_INCREMENT,
  `username` VARCHAR(32),
  `password` VARCHAR(40),
  `join_date` DATETIME,
  `real_name` VARCHAR(32),
  `gender` VARCHAR(1),
  `location` VARCHAR(32),
  `phone` VARCHAR(40),
  `picture` VARCHAR(32),
  PRIMARY KEY (`user_id`)
);

INSERT INTO `match_user` VALUES (1, 'sidneyk', '745c52f30f82d4323292dcca9eea0aee87feecc5', '2008-06-03 14:51:46', '张彬','男', '西乡', '15814602831', 'sidneypic.jpg');
INSERT INTO `match_user` VALUES (2, 'nevilj', '12a20bcb5ed139a5f3fc808704897762cbab74ec', '2008-06-03 14:52:09', '张俊', '女', '平湖', '15718889999', 'nevilpic.jpg');
INSERT INTO `match_user` VALUES (3, 'alexc', '676a6666682bd41bef5fd1c1f629fa233b1307a4', '2008-06-03 14:53:05', '温纯芳', '女', '龙岗', '13677778888', 'alexpic.jpg');
INSERT INTO `match_user` VALUES (4, 'sdaniels', '1ff915f2fae864032e44cbe5a6cdd858500c9df7', '2008-06-03 14:58:40', '席俊奇', '男', '西乡', '13819996677', 'susannahpic.jpg');
INSERT INTO `match_user` VALUES (5, 'ethelh', '53a56acb2a52f3815a2518e75029b071c298477a', '2008-06-03 15:00:37', '徐伟周', '男', '西乡', '13822445566', 'ethelpic.jpg');