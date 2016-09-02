DROP TABLE IF EXISTS cluster_timetable;

CREATE TABLE cluster_timetable (
  ClusterId   INT(11) UNSIGNED NOT NULL,
  TimeTableId INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (ClusterId, TimeTableId),
  CONSTRAINT FK_cluster_timetable_cluster_ClusterId FOREIGN KEY (ClusterId)
  REFERENCES cluster (ClusterId)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_cluster_timetable_timetable_TimeTableId FOREIGN KEY (TimeTableId)
  REFERENCES timetable (TimeTableId)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
  ENGINE = INNODB
  CHARACTER SET utf8
  COLLATE utf8_general_ci;

# unimplemented tables in production
DROP TABLE IF EXISTS timetable;
DROP TABLE IF EXISTS timetable_details;
