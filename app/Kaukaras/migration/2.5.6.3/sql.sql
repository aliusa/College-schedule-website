CREATE TABLE `dev.schedule`.params (
  ParamId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  Title   VARCHAR(255)              DEFAULT NULL,
  Param1  VARCHAR(255)              DEFAULT NULL,
  Param2  VARCHAR(255)              DEFAULT NULL,
  PRIMARY KEY (ParamId)
)
  ENGINE = INNODB
  CHARACTER SET utf8
  COLLATE utf8_general_ci;