CREATE DATABASE IF NOT EXISTS `dev.schedule`
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;
USE `dev.schedule`;

DELIMITER $$
DROP PROCEDURE IF EXISTS `user_login`$$
CREATE DEFINER =`root`@`localhost` PROCEDURE `user_login`(IN `__username`   VARCHAR(255), IN `__password` VARCHAR(255),
                                                          IN `__ip`         VARCHAR(255), IN `__agent` VARCHAR(255),
                                                          IN `__browser`    VARCHAR(255), IN `__platform` VARCHAR(255),
                                                          IN `__resolution` VARCHAR(255)) BEGIN

  DECLARE _UserId INT;

  DECLARE _Username VARCHAR(255);

  DECLARE _FirstName VARCHAR(255);

  DECLARE _LastName VARCHAR(255);

  DECLARE _IsActive BIT;

  DECLARE _IsArchived BIT;


  SELECT

    user.UserId,

    user.Username,

    user.FirstName,

    user.LastName,

    user.IsActive,

    user.IsArchived

  INTO

    _UserId,

    _Username,

    _FirstName,

    _LastName,

    _IsActive,

    _IsArchived

  FROM

    user

  WHERE

    user.Username = __username AND AES_ENCRYPT(user.Password, '1') = AES_ENCRYPT(__password, '1');


  IF (_UserId IS NULL)

  THEN

    SELECT "Patikrinkite vartotojo vardą arba slaptažodį" AS msg;

    SELECT UserId

    INTO _UserId

    FROM user

    WHERE Username = __username;

  END IF;


  IF (_IsActive = 0)

  THEN

    SELECT "Jums atjungtas prisijungimas. Kreipkitės į IS administratorių." AS msg;

  END IF;


  INSERT INTO loginlog

  (`UserId`, `Username`, `IP`, `UserAgent`, `Browser`, `Platform`, `Resolution`, `Success`)

    SELECT

      IF(_UserId IS NULL, NULL, _UserId),

      IF(_UserId IS NULL, __username, NULL),

      __ip,

      __agent,

      __browser,

      __platform,

      __resolution,

      CASE WHEN _Username IS NULL

        THEN NULL

      ELSE 1 END;

  SELECT

    _UserId    AS UserId,

    _FirstName AS FirstName,

    _LastName  AS LastName;

END$$

DROP FUNCTION IF EXISTS `Classroom_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Classroom_Name`(`mID` INT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT Name
            FROM classroom
            WHERE ClassroomId = mID);

  END$$

DROP FUNCTION IF EXISTS `Cluster_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Cluster_Name`(`nClusterId` BIGINT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT cluster.Name

            FROM cluster

            WHERE cluster.ClusterId = nClusterId);

  END$$

DROP FUNCTION IF EXISTS `Option_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Option_Name`(`mParamId` INT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT Name
            FROM options_details
            WHERE OptionsDetailsId = mParamId);

  END$$

DROP FUNCTION IF EXISTS `Professor_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Professor_Name`(`mId` INT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT CONCAT(SUBSTRING(FirstName, 1, 1), '. ', LastName)
            FROM professor
            WHERE ProfessorId = mId);

  END$$

DROP FUNCTION IF EXISTS `RecurringTask_Pattern`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `RecurringTask_Pattern`(`nRecurrintTaskId` INT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN

    DECLARE _IsRecurring TINYINT;

    DECLARE _DateStart DATE;

    DECLARE _DateEnd DATE;

    DECLARE _TimeStart TIME;

    DECLARE _TimeEnd TIME;

    DECLARE _IsMonday TINYINT;

    DECLARE _IsTuesday TINYINT;

    DECLARE _IsWednesday TINYINT;

    DECLARE _IsThursday TINYINT;

    DECLARE _IsFriday TINYINT;

    DECLARE _IsSaturday TINYINT;

    DECLARE _IsSunday TINYINT;

    DECLARE _Occurs INT;

    DECLARE _OccursEvery INT;

    DECLARE _OUT TEXT;


    SELECT

      recurringtask.IsRecurring,

      recurringtask.DateStart,

      recurringtask.DateEnd,

      recurringtask.TimeStart,

      recurringtask.TimeEnd,

      recurringtask.IsMonday,

      recurringtask.IsTuesday,

      recurringtask.IsWednesday,

      recurringtask.IsThursday,

      recurringtask.IsFriday,

      recurringtask.IsSaturday,

      recurringtask.IsSunday,

      recurringtask.Occurs,

      recurringtask.OccursEvery

    INTO

      _IsRecurring,

      _DateStart,

      _DateEnd,

      _TimeStart,

      _TimeEnd,

      _IsMonday,

      _IsTuesday,

      _IsWednesday,

      _IsThursday,

      _IsFriday,

      _IsSaturday,

      _IsSunday,

      _Occurs,

      _OccursEvery

    FROM recurringtask

    WHERE recurringtask.RecurringTaskId = nRecurrintTaskId;


    IF (_IsRecurring = 0)

    THEN

      SET _OUT = CONCAT("Vyksta 1 kartą ", _DateStart, " nuo ", _TimeStart, " iki", _TimeEnd, ".");

    ELSE

      IF (_OccursEvery = 1)

      THEN

        IF (_Occurs = 1)

        THEN

          SET _OUT = CONCAT("Vyksta dieną nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart), "-",
                            Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 2)

          THEN

            SET _OUT = CONCAT("Vyksta kas dieną nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart),
                              "-", Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 3)

          THEN

            SET _OUT = CONCAT("Vyksta kas savaitę nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart),
                              "-", Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 4)

          THEN

            SET _OUT = CONCAT("Vyksta kas mėnesį nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart),
                              "-", Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 5)

          THEN

            SET _OUT = CONCAT("Vyksta pasirinktomis dienomis nuo ", _DateStart, " iki ", _DateEnd, ", ",
                              Time_standard(_TimeStart), "-", Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 6)

          THEN

            SET _OUT = CONCAT("Vyksta kas metus nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart),
                              "-", Time_standard(_TimeEnd), ".");

        END IF;

      ELSE

        SET _OUT = CONCAT("Vyksta kas ", _OccursEvery);

        IF (_Occurs = 1)

        THEN

          SET _OUT = CONCAT(_OUT, "dieną nuo ", _DateStart, " iki ", _DateEnd, ".");
        ELSEIF (_Occurs = 2)

          THEN

            SET _OUT = CONCAT(_OUT, "dieną nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart), "-",
                              Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 3)

          THEN

            SET _OUT = CONCAT(_OUT, "savaites nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart),
                              "-", Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 4)

          THEN

            SET _OUT = CONCAT(_OUT, "mėnesį nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart), "-",
                              Time_standard(_TimeEnd), ".");

        ELSEIF (_Occurs = 5)

          THEN

            SET _OUT = CONCAT(_OUT, "savaites nuo ", _DateStart, " iki ", _DateEnd, ".");
        ELSEIF (_Occurs = 6)

          THEN

            SET _OUT = CONCAT(_OUT, "metus nuo ", _DateStart, " iki ", _DateEnd, ", ", Time_standard(_TimeStart), "-",
                              Time_standard(_TimeEnd), ".");

        END IF;

      END IF;

    END IF;


    RETURN (SELECT _OUT AS msg);

  END$$

DROP FUNCTION IF EXISTS `Semester_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Semester_Name`(`nId` BIGINT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT Name

            FROM semester

            WHERE SemesterId = nId);

  END$$

DROP FUNCTION IF EXISTS `Subject_Name`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Subject_Name`(`nSubjectId` BIGINT)
  RETURNS VARCHAR(255)
  CHARSET utf8 READS SQL DATA
  BEGIN


    RETURN (SELECT subject.Name

            FROM subject

            WHERE subject.SubjectId = nSubjectId);

  END$$

DROP FUNCTION IF EXISTS `Time_standard`$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Time_standard`(`mTime` TIME)
  RETURNS VARCHAR(5)
  CHARSET utf8 BEGIN


  RETURN (DATE_FORMAT(mTime, '%H:%i'));

END$$

DELIMITER ;

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `ClassroomId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name`        VARCHAR(255)     NOT NULL,
  `FacultyId`   INT(11) UNSIGNED          DEFAULT NULL,
  `Vacancy`     INT(10) UNSIGNED          DEFAULT NULL,
  PRIMARY KEY (`ClassroomId`),
  UNIQUE KEY `UK_classroom` (`Name`, `FacultyId`),
  KEY `fk_Classroom_Options_details1_idx` (`FacultyId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `classroom_equipment`;
CREATE TABLE IF NOT EXISTS `classroom_equipment` (
  `ClassroomId` INT(11) UNSIGNED NOT NULL,
  `EquipmentId` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`ClassroomId`, `EquipmentId`),
  KEY `fk_classroom_has_equipment_equipment1_idx` (`EquipmentId`),
  KEY `fk_classroom_has_equipment_classroom1_idx` (`ClassroomId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `cluster`;
CREATE TABLE IF NOT EXISTS `cluster` (
  `ClusterId`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name`        VARCHAR(255)     NOT NULL,
  `ParentId`    INT(11) UNSIGNED          DEFAULT NULL,
  `Email`       VARCHAR(45)               DEFAULT NULL,
  `IsActive`    TINYINT(1) UNSIGNED       DEFAULT NULL,
  `IsArchived`  TINYINT(1) UNSIGNED       DEFAULT NULL,
  `StudyFormId` INT(11) UNSIGNED          DEFAULT NULL,
  `FacultyId`   INT(11) UNSIGNED          DEFAULT NULL,
  `FieldId`     INT(11) UNSIGNED          DEFAULT NULL,
  `StartYear`   YEAR(4)                   DEFAULT NULL,
  PRIMARY KEY (`ClusterId`),
  KEY `fk_Cluster_Options_details1_idx` (`StudyFormId`),
  KEY `fk_Cluster_Options_details3_idx` (`FieldId`),
  KEY `IsActive` (`IsActive`),
  KEY `IsArchived` (`IsArchived`),
  KEY `FK_cluster_cluster_ClusterId` (`ParentId`),
  KEY `FK_cluster_faculty_FacultyId` (`FacultyId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `cluster_student`;
CREATE TABLE IF NOT EXISTS `cluster_student` (
  `ClusterId` INT(11) UNSIGNED NOT NULL,
  `StudentId` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ClusterId`, `StudentId`),
  KEY `fk_cluster_has_student_student1_idx` (`StudentId`),
  KEY `fk_cluster_has_student_cluster1_idx` (`ClusterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `EquipmentId` INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `Name`        VARCHAR(255)        NOT NULL,
  `Type`        TINYINT(2) UNSIGNED NOT NULL
  COMMENT '1 - hardware, 2 - software',
  PRIMARY KEY (`EquipmentId`),
  UNIQUE KEY `Name` (`Name`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `FacultyId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name`      VARCHAR(255)              DEFAULT NULL,
  `SortOrder` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`FacultyId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `lecture`;
CREATE TABLE IF NOT EXISTS `lecture` (
  `LectureId`       INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `RecurringTaskId` INT(11) UNSIGNED    NOT NULL,
  `ClassroomId`     INT(11) UNSIGNED    NOT NULL,
  `Date`            DATE                NOT NULL,
  `TimeStart`       TIME                         DEFAULT NULL,
  `TimeEnd`         TIME                         DEFAULT NULL,
  `Duration`        TIME AS (TIMEDIFF(TimeEnd, TimeStart)) VIRTUAL,
  `Weekday`         TINYINT(1) AS (WEEKDAY(Date) + 1) VIRTUAL,
  `Notes`           TEXT,
  `Topic`           VARCHAR(1024)                DEFAULT NULL,
  `IsCanceled`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `DateCreated`     TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`LectureId`),
  KEY `fk_Lecture_Classroom1_idx` (`ClassroomId`),
  KEY `fk_Lecture_RecurringTask1_idx` (`RecurringTaskId`),
  KEY `Date` (`Date`),
  KEY `TimeStart` (`TimeStart`),
  KEY `TimeEnd` (`TimeEnd`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `loginlog`;
CREATE TABLE IF NOT EXISTS `loginlog` (
  `LoginLogId` BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `UserId`     TINYINT(4) UNSIGNED          DEFAULT NULL,
  `Username`   VARCHAR(255)                 DEFAULT NULL,
  `DateTime`   DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP`         VARCHAR(45)                  DEFAULT NULL,
  `UserAgent`  VARCHAR(255)                 DEFAULT NULL,
  `Browser`    VARCHAR(255)                 DEFAULT NULL,
  `Platform`   VARCHAR(255)                 DEFAULT NULL,
  `Resolution` VARCHAR(45)                  DEFAULT NULL,
  `Success`    TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `Notes`      TEXT,
  PRIMARY KEY (`LoginLogId`),
  KEY `fk_LoginLog_User1_idx` (`UserId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `log_actions`;
CREATE TABLE IF NOT EXISTS `log_actions` (
  `LogId`  BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date`   DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` TINYINT(4) UNSIGNED NOT NULL,
  `action` VARCHAR(50)                  DEFAULT NULL
  COMMENT 'insert,update,exec,delete,excelexport,bach_update',
  `sql`    TEXT,
  `pk`     INT(11) UNSIGNED             DEFAULT NULL,
  `tbl`    TEXT,
  PRIMARY KEY (`LogId`),
  KEY `fk_Log_User1_idx` (`UserId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `log_actions_details`;
CREATE TABLE IF NOT EXISTS `log_actions_details` (
  `LogActionDetailsId` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `LogActionId`        BIGINT(20) UNSIGNED          DEFAULT NULL,
  `Field`              VARCHAR(255)        NOT NULL,
  `OldValue`           TEXT,
  `NewValue`           TEXT,
  PRIMARY KEY (`LogActionDetailsId`),
  KEY `FK_log_actions_details_log_actions_LogId` (`LogActionId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `ModuleId`   INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `SubjectId`  INT(11) UNSIGNED    NOT NULL,
  `SemesterId` TINYINT(4) UNSIGNED NOT NULL,
  `Credits`    INT(2) UNSIGNED              DEFAULT NULL,
  PRIMARY KEY (`ModuleId`),
  KEY `FK_module_subject_SubjectId` (`SubjectId`),
  KEY `FK_module_semester_SemesterId` (`SemesterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `module_cluster`;
CREATE TABLE IF NOT EXISTS `module_cluster` (
  `ModuleClusterId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ModuleId`        INT(11) UNSIGNED NOT NULL,
  `ClusterId`       INT(11) UNSIGNED NOT NULL
  COMMENT 'FK to SubCluster',
  `IsChosen`        TINYINT(1)                DEFAULT '0',
  PRIMARY KEY (`ModuleClusterId`),
  KEY `FK_module_cluster_cluster_ClusterId` (`ClusterId`),
  KEY `FK_module_cluster_module_ModuleId` (`ModuleId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `OptionsId`     BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name`          VARCHAR(255)        NOT NULL,
  `IntervalStart` BIGINT(19) UNSIGNED NOT NULL,
  `IntervalEnd`   BIGINT(19) UNSIGNED NOT NULL,
  PRIMARY KEY (`OptionsId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `options_details`;
CREATE TABLE IF NOT EXISTS `options_details` (
  `OptionsDetailsId` BIGINT(19) UNSIGNED NOT NULL AUTO_INCREMENT,
  `OptionsId`        BIGINT(19) UNSIGNED NOT NULL,
  `Name`             VARCHAR(255)        NOT NULL,
  `SortOrder`        INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  PRIMARY KEY (`OptionsDetailsId`),
  KEY `fk_Options_details_Options1_idx` (`OptionsId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `params`;
CREATE TABLE IF NOT EXISTS `params` (
  `ParamId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Title`   VARCHAR(255)              DEFAULT NULL,
  `Param1`  VARCHAR(255)              DEFAULT NULL,
  `Param2`  VARCHAR(255)              DEFAULT NULL,
  PRIMARY KEY (`ParamId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `ProfessorId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FirstName`   VARCHAR(255)     NOT NULL,
  `LastName`    VARCHAR(255)     NOT NULL,
  `FullName`    TEXT AS (CONCAT(FirstName, ' ', LastName)) VIRTUAL,
  `Email`       VARCHAR(255)              DEFAULT NULL,
  `Notes`       TEXT,
  `Picture`     VARCHAR(255)              DEFAULT NULL,
  `Phone`       VARCHAR(255)              DEFAULT NULL,
  `DegreeId`    INT(11) UNSIGNED          DEFAULT NULL,
  `IsActive`    TINYINT(1) UNSIGNED       DEFAULT '1'
  COMMENT 'default 1, else NULL',
  PRIMARY KEY (`ProfessorId`),
  KEY `FK_professor_options_details_OptionsDetailsId` (`DegreeId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `professor_semester`;
CREATE TABLE IF NOT EXISTS `professor_semester` (
  `ProfessorId` INT(11) UNSIGNED    NOT NULL,
  `SemesterId`  TINYINT(4) UNSIGNED NOT NULL,
  PRIMARY KEY (`ProfessorId`, `SemesterId`),
  KEY `IDX_semester_professor_SemesterId` (`SemesterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `recurringtask`;
CREATE TABLE IF NOT EXISTS `recurringtask` (
  `RecurringTaskId` INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `ModuleId`        INT(11) UNSIGNED    NOT NULL,
  `ProfessorId`     INT(11) UNSIGNED    NOT NULL,
  `ModuleClusterId` INT(11) UNSIGNED    NOT NULL,
  `IsRecurring`     TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT 'One time - 0\nLong term - 1',
  `DateStart`       DATE                NOT NULL,
  `DateEnd`         DATE                         DEFAULT NULL,
  `TimeStart`       TIME                NOT NULL,
  `TimeEnd`         TIME                NOT NULL,
  `Duration`        TIME AS (TIMEDIFF(TimeEnd, TimeStart)) VIRTUAL,
  `IsMonday`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsTuesday`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsWednesday`     TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsThursday`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsFriday`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsSaturday`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `IsSunday`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `Occurs`          TINYINT(1) UNSIGNED NOT NULL DEFAULT '2'
  COMMENT '1 - Vieną kartą\n2 - Kasdien\n3 - Kas savaitę\n4 - Kas mėn.\n5 - Pasirinkomis dienomis',
  `OccursEvery`     TINYINT(4) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT '0 - is not recurrent\n1 - Every time (day/week/month)\n2 - Every 2nd week/month',
  `DateCreated`     TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RecurringTaskId`),
  KEY `fk_RecurringTask_Task1_idx` (`ModuleId`),
  KEY `FK_recurringtask_professor_ProfessorId` (`ProfessorId`),
  KEY `FK_recurringtask_module_subcluster_ModuleSubclusterId` (`ModuleClusterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `SemesterId` TINYINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name`       VARCHAR(255)        NOT NULL,
  `SortOrder`  TINYINT(4) UNSIGNED NOT NULL,
  PRIMARY KEY (`SemesterId`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StudentId`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FirstName`   VARCHAR(127)              DEFAULT NULL,
  `LastName`    VARCHAR(127)              DEFAULT NULL,
  `Email`       VARCHAR(255)              DEFAULT NULL,
  `DateOfBirth` DATE                      DEFAULT NULL,
  `FacebookId`  VARCHAR(45)               DEFAULT NULL,
  PRIMARY KEY (`StudentId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `SubjectId` INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `Name`      VARCHAR(255)        NOT NULL,
  `IsActive`  TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`SubjectId`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserId`      TINYINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Username`    VARCHAR(45)         NOT NULL,
  `FirstName`   VARCHAR(45)         NOT NULL,
  `LastName`    VARCHAR(45)         NOT NULL,
  `FullName`    VARCHAR(128) AS (CONCAT(FirstName, ' ', LastName)) VIRTUAL COMMENT 'virtual column',
  `Password`    VARCHAR(128)        NOT NULL,
  `AllowedIp`   VARCHAR(512)                 DEFAULT NULL
  COMMENT 'Allowed IPs to login from. NULL - allowed from anywhere. ',
  `BannedIp`    VARCHAR(512)                 DEFAULT NULL,
  `Email`       VARCHAR(255)                 DEFAULT NULL,
  `IsActive`    TINYINT(1) UNSIGNED NOT NULL DEFAULT '1'
  COMMENT 'default 1, else 0',
  `IsArchived`  TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT 'default 0, else 1',
  `DateCreated` DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Image`       VARCHAR(255)                 DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  UNIQUE KEY `RawPassword_UNIQUE` (`Password`),
  KEY `IsActive` (`IsActive`),
  KEY `IsArchived` (`IsArchived`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


ALTER TABLE `classroom_equipment`
  ADD CONSTRAINT `fk_classroom_has_equipment_classroom1` FOREIGN KEY (`ClassroomId`) REFERENCES `classroom` (`ClassroomId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classroom_has_equipment_equipment1` FOREIGN KEY (`EquipmentId`) REFERENCES `equipment` (`EquipmentId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `cluster`
  ADD CONSTRAINT `FK_cluster_cluster_ClusterId` FOREIGN KEY (`ParentId`) REFERENCES `cluster` (`ClusterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_cluster_faculty_FacultyId` FOREIGN KEY (`FacultyId`) REFERENCES `faculty` (`FacultyId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `cluster_student`
  ADD CONSTRAINT `fk_cluster_has_student_cluster1` FOREIGN KEY (`ClusterId`) REFERENCES `cluster` (`ClusterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cluster_has_student_student1` FOREIGN KEY (`StudentId`) REFERENCES `student` (`StudentId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `lecture`
  ADD CONSTRAINT `FK_lecture_classroom_ClassroomId` FOREIGN KEY (`ClassroomId`) REFERENCES `classroom` (`ClassroomId`),
  ADD CONSTRAINT `FK_lecture_recurringtask_RecurringTaskId` FOREIGN KEY (`RecurringTaskId`) REFERENCES `recurringtask` (`RecurringTaskId`);

ALTER TABLE `loginlog`
  ADD CONSTRAINT `FK_loginlog_user_UserId` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `log_actions`
  ADD CONSTRAINT `FK_log_user_UserId` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `log_actions_details`
  ADD CONSTRAINT `FK_log_actions_details_log_actions_LogId` FOREIGN KEY (`LogActionId`) REFERENCES `log_actions` (`LogId`);

ALTER TABLE `module`
  ADD CONSTRAINT `FK_module_semester_SemesterId` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_module_subject_SubjectId` FOREIGN KEY (`SubjectId`) REFERENCES `subject` (`SubjectId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `module_cluster`
  ADD CONSTRAINT `FK_module_cluster_cluster_ClusterId` FOREIGN KEY (`ClusterId`) REFERENCES `cluster` (`ClusterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_module_cluster_module_ModuleId` FOREIGN KEY (`ModuleId`) REFERENCES `module` (`ModuleId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `options_details`
  ADD CONSTRAINT `FK_options_details_options_OptionsId` FOREIGN KEY (`OptionsId`) REFERENCES `options` (`OptionsId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `professor_semester`
  ADD CONSTRAINT `FK_professor_semester_professor_ProfessorId` FOREIGN KEY (`ProfessorId`) REFERENCES `professor` (`ProfessorId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_professor_semester_semester_SemesterId` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `recurringtask`
  ADD CONSTRAINT `FK_recurringtask_module_ModuleId` FOREIGN KEY (`ModuleId`) REFERENCES `module` (`ModuleId`),
  ADD CONSTRAINT `FK_recurringtask_module_subcluster_ModuleSubclusterId` FOREIGN KEY (`ModuleClusterId`) REFERENCES `module_cluster` (`ModuleClusterId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_recurringtask_professor_ProfessorId` FOREIGN KEY (`ProfessorId`) REFERENCES `professor` (`ProfessorId`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
