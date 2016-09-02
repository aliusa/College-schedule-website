# Pakeičia pogrupio pavadinimą iš BIT į VARCHAR
ALTER TABLE subcluster
  CHANGE COLUMN Name Name VARCHAR(255) NOT NULL DEFAULT '0';

# unimplemented tables in production
DROP TABLE IF EXISTS semester_professor;

CREATE TABLE professor_semester (
  ProfessorId INT(11) UNSIGNED NOT NULL,
  SemesterId  INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (ProfessorId, SemesterId),
  INDEX IDX_semester_professor_ProfessorId (ProfessorId),
  INDEX IDX_semester_professor_SemesterId (SemesterId)
)
  ENGINE = INNODB
  CHARACTER SET utf8
  COLLATE utf8_general_ci;


# Prideda Foreign Key ant lentelių professor_semester


ALTER TABLE professor_semester
  ADD CONSTRAINT FK_professor_semester_professor_ProfessorId FOREIGN KEY (ProfessorId)
REFERENCES professor (ProfessorId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE professor_semester
  CHANGE COLUMN SemesterId SemesterId TINYINT(4) UNSIGNED NOT NULL;

ALTER TABLE professor_semester
  ADD CONSTRAINT FK_professor_semester_semester_SemesterId FOREIGN KEY (SemesterId)
REFERENCES semester (SemesterId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#

ALTER TABLE module
  DROP INDEX fk_module_semester1_idx,
  DROP INDEX fk_module_subject1_idx;

ALTER TABLE module
  ADD CONSTRAINT FK_module_subject_SubjectId FOREIGN KEY (SubjectId)
REFERENCES subject (SubjectId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE module
  CHANGE COLUMN SemesterId SemesterId TINYINT(4) UNSIGNED NOT NULL;

ALTER TABLE module
  ADD CONSTRAINT FK_module_semester_SemesterId FOREIGN KEY (SemesterId)
REFERENCES semester (SemesterId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

# Adding DEFAULT NULL

ALTER TABLE cluster
  CHANGE COLUMN IsActive IsActive TINYINT(1) UNSIGNED DEFAULT 1
COMMENT 'default 1, else 0',
  CHANGE COLUMN IsArchived IsArchived TINYINT(1) UNSIGNED DEFAULT 0
COMMENT 'default 0, else 1',
  CHANGE COLUMN StudyFormId StudyFormId INT(11) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN FacultyId FacultyId INT(11) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN FieldId FieldId INT(11) UNSIGNED DEFAULT NULL;

# Remove Unique index

ALTER TABLE cluster
  DROP INDEX Name_UNIQUE,
  CHANGE COLUMN Name Name VARCHAR(255) NOT NULL;

# Add column and FK

ALTER TABLE cluster
  ADD COLUMN ParentId INT(11) UNSIGNED DEFAULT NULL
  AFTER Name;

ALTER TABLE cluster
  ADD CONSTRAINT FK_cluster_cluster_ClusterId FOREIGN KEY (ParentId)
REFERENCES cluster (ClusterId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

# Move all data from SubCluster to Cluster
INSERT INTO cluster (`Name`, `ParentId`)
  SELECT
    Name,
    ClusterId
  FROM subcluster;


ALTER TABLE module_subcluster
  RENAME module_cluster,
  DROP FOREIGN KEY fk_module_has_subcluster_subcluster1,
  CHANGE COLUMN SubClusterId ClusterId INT(11) UNSIGNED NOT NULL
COMMENT 'FK to SubCluster';

ALTER TABLE module_cluster
  DROP INDEX fk_module_has_subcluster_subcluster1_idx;

ALTER TABLE module_cluster
  ADD CONSTRAINT FK_module_cluster_cluster_ClusterId FOREIGN KEY (ClusterId)
REFERENCES cluster (ClusterId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE module_cluster
  DROP FOREIGN KEY fk_module_has_subcluster_module1;

ALTER TABLE module_cluster
  DROP INDEX fk_module_has_subcluster_module1_idx;

ALTER TABLE module_cluster
  ADD CONSTRAINT FK_module_cluster_module_ModuleId FOREIGN KEY (ModuleId)
REFERENCES module (ModuleId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

DROP TABLE `subcluster`;

# Rename column
ALTER TABLE module_cluster
  CHANGE COLUMN ModuleSubclusterId ModuleClusterId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;

# adding default null
ALTER TABLE cluster
  CHANGE COLUMN IsActive IsActive TINYINT(1) UNSIGNED DEFAULT 1
COMMENT 'default 1, else 0',
  CHANGE COLUMN IsArchived IsArchived TINYINT(1) UNSIGNED DEFAULT 0
COMMENT 'default 0, else 1';

# removing preset default values when subclusters was moved to cluster table
UPDATE cluster
SET IsActive = NULL, IsArchived = NULL
WHERE ParentId IS NOT NULL;


ALTER TABLE recurringtask
  DROP FOREIGN KEY FK_recurringtask_module_subcluster_ModuleSubclusterId,
  CHANGE COLUMN ModuleSubclusterId ModuleClusterId INT(11) UNSIGNED NOT NULL;

ALTER TABLE recurringtask
  ADD CONSTRAINT FK_recurringtask_module_subcluster_ModuleSubclusterId FOREIGN KEY (ModuleClusterId)
REFERENCES module_cluster (ModuleClusterId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

# removing default values from IsActive, IsArchived.

ALTER TABLE cluster
  CHANGE COLUMN ParentId ParentId INT(11) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN Email Email VARCHAR(45) DEFAULT NULL,
  CHANGE COLUMN IsActive IsActive TINYINT(1) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN IsArchived IsArchived TINYINT(1) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN StudyFormId StudyFormId INT(11) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN FacultyId FacultyId INT(11) UNSIGNED DEFAULT NULL,
  CHANGE COLUMN FieldId FieldId INT(11) UNSIGNED DEFAULT NULL;

##

CREATE TABLE faculty (
  FacultyId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  Name      VARCHAR(255)          DEFAULT NULL,
  PRIMARY KEY (FacultyId)
)
  ENGINE = INNODB;

# Move faculties to own table
INSERT INTO faculty (`Name`)
  SELECT `Name`
  FROM options_details
  WHERE OptionsId = 1;

DELETE FROM options_details
WHERE OptionsId = 1;
DELETE FROM Options
WHERE OptionsId = 1;

ALTER TABLE options_details
  DROP FOREIGN KEY fk_Options_details_Options1;
UPDATE options_details
SET OptionsId = OptionsId - 1;
UPDATE options
SET OptionsId = OptionsId - 1;

# Add FK
ALTER TABLE options_details
  ADD CONSTRAINT FK_options_details_options_OptionsId FOREIGN KEY (OptionsId)
REFERENCES options (OptionsId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE faculty
  ADD COLUMN SortOrder INT(11) UNSIGNED NOT NULL DEFAULT 0
  AFTER Name;

#Prep for changing cell values
ALTER TABLE cluster
  DROP INDEX fk_Cluster_Options_details2_idx;

UPDATE cluster
SET FacultyId = FacultyId - 99
WHERE FacultyId IS NOT NULL;

#add removed FK
ALTER TABLE cluster
  ADD CONSTRAINT FK_cluster_faculty_FacultyId FOREIGN KEY (FacultyId)
REFERENCES faculty (FacultyId)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

##

ALTER TABLE cluster
  ADD COLUMN StartYear YEAR(4) DEFAULT NULL
  AFTER FieldId;
