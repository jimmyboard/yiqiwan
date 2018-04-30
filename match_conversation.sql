CREATE TABLE `match_conversation` (
    `c_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_one` int(11) NOT NULL,
    `user_two` int(11) NOT NULL,
    `content` varchar(10000) DEFAULT NULL,
    `c_date` datetime DEFAULT NULL,
    `status` TINYINT,
    FOREIGN KEY (user_one) REFERENCES match_user(user_id),
    FOREIGN KEY (user_two) REFERENCES match_user(user_id)
);