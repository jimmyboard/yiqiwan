CREATE TABLE `match_response` (
  `response_id` INT AUTO_INCREMENT,
  `user_id` INT,
  `topic_id` INT,
  `response` TINYINT,
  `response_date` DATETIME,
  PRIMARY KEY (`response_id`)
);
