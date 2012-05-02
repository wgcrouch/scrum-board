    SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
    SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
    SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

    CREATE SCHEMA IF NOT EXISTS `agile` DEFAULT CHARACTER SET utf8 ;
    USE `agile` ;

    -- -----------------------------------------------------
    -- Table `agile`.`user`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`user` (
    `userId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(100) NULL ,
    `fullName` VARCHAR(255) NULL ,
    `status` ENUM('awaitingVerification', 'Active', 'Disabled') NULL DEFAULT 'awaitingVerification' ,
    PRIMARY KEY (`userId`) )
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`team`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`team` (
    `teamId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `owner` INT(11) UNSIGNED NOT NULL ,
    `name` VARCHAR(255) NULL ,
    `velocity` INT(11) UNSIGNED NOT NULL ,
    PRIMARY KEY (`teamId`) ,
    INDEX `fk_team_owner` (`owner` ASC) ,
    CONSTRAINT `fk_team_owner`
        FOREIGN KEY (`owner` )
        REFERENCES `agile`.`user` (`userId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`role`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`role` (
    `roleId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(100) NOT NULL ,
    PRIMARY KEY (`roleId`) )
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`teamMember`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`teamMember` (
    `userId` INT(11) UNSIGNED NOT NULL ,
    `teamId` INT(11) UNSIGNED NOT NULL ,
    `roleId` INT(11) UNSIGNED NOT NULL ,
    INDEX `fk_teamMember_userId` (`userId` ASC) ,
    INDEX `fk_teamMember_teamId` (`teamId` ASC) ,
    INDEX `fk_teamMember_roleId` (`roleId` ASC) ,
    CONSTRAINT `fk_teamMember_userId`
        FOREIGN KEY (`userId` )
        REFERENCES `agile`.`user` (`userId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_teamMember_teamId`
        FOREIGN KEY (`teamId` )
        REFERENCES `agile`.`team` (`teamId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_teamMember_roleId`
        FOREIGN KEY (`roleId` )
        REFERENCES `agile`.`role` (`roleId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`backlog`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`backlog` (
    `backlogId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `teamId` INT(11) UNSIGNED NOT NULL ,
    `owner` INT(11) UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`backlogId`) ,
    INDEX `fk_backlog_teamId` (`teamId` ASC) ,
    INDEX `fk_backlog_owner` (`owner` ASC) ,
    CONSTRAINT `fk_backlog_teamId`
        FOREIGN KEY (`teamId` )
        REFERENCES `agile`.`team` (`teamId` )
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `fk_backlog_owner`
        FOREIGN KEY (`owner` )
        REFERENCES `agile`.`user` (`userId` )
        ON DELETE SET NULL
        ON UPDATE CASCADE)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`backlogColumn`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`backlogColumn` (
    `backlogColumnId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `backlogId` INT(11) UNSIGNED NOT NULL ,
    `column` VARCHAR(45) NULL ,
    `priority` INT(11) NOT NULL ,
    PRIMARY KEY (`backlogColumnId`) ,
    INDEX `priority` (`backlogId` ASC, `priority` ASC) ,
    INDEX `fk_backlogColumn_backlogId` (`backlogId` ASC) ,
    CONSTRAINT `fk_backlogColumn_backlogId`
        FOREIGN KEY (`backlogId` )
        REFERENCES `agile`.`backlog` (`backlogId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`backlogRow`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`backlogRow` (
    `backlogRowId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `backlogId` INT(11) UNSIGNED NOT NULL ,
    `rowId` INT(11) UNSIGNED NOT NULL ,
    PRIMARY KEY (`backlogRowId`) ,
    INDEX `fk_backlogRow_backlogId` (`backlogId` ASC) ,
    CONSTRAINT `fk_backlogRow_backlogId`
        FOREIGN KEY (`backlogId` )
        REFERENCES `agile`.`backlog` (`backlogId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`backlogRowColumnData`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`backlogRowColumnData` (
    `backlogRowColumDataId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `backlogId` INT(11) UNSIGNED NOT NULL ,
    `backlogRowId` INT(11) UNSIGNED NOT NULL ,
    `backlogColumnId` INT(11) UNSIGNED NOT NULL ,
    `data` TEXT NULL ,
    PRIMARY KEY (`backlogRowColumDataId`) ,
    INDEX `fk_backlogRowColumnData_backlogId` (`backlogId` ASC) ,
    INDEX `fk_backlogRowColumnData_backlogRowId` (`backlogRowId` ASC) ,
    INDEX `fk_backlogRowColumnData_backlogColumnId` (`backlogColumnId` ASC) ,
    CONSTRAINT `fk_backlogRowColumnData_backlogId`
        FOREIGN KEY (`backlogId` )
        REFERENCES `agile`.`backlog` (`backlogId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_backlogRowColumnData_backlogRowId`
        FOREIGN KEY (`backlogRowId` )
        REFERENCES `agile`.`backlogRow` (`backlogRowId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_backlogRowColumnData_backlogColumnId`
        FOREIGN KEY (`backlogColumnId` )
        REFERENCES `agile`.`backlogColumn` (`backlogColumnId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`release`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`release` (
    `releaseId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `teamId` INT(11) UNSIGNED NOT NULL ,
    `name` VARCHAR(255) NULL ,
    `startDate` DATE NULL ,
    `endDate` DATE NULL ,
    PRIMARY KEY (`releaseId`) ,
    INDEX `fk_release_teamId` (`teamId` ASC) ,
    CONSTRAINT `fk_release_teamId`
        FOREIGN KEY (`teamId` )
        REFERENCES `agile`.`team` (`teamId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`scrumboard`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`scrumboard` (
    `scrumboardId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `teamId` INT(11) UNSIGNED NOT NULL ,
    `releaseId` INT(11) UNSIGNED NOT NULL ,
    `name` VARCHAR(45) NULL ,
    `startDate` DATE NULL ,
    `endDate` DATE NULL ,
    PRIMARY KEY (`scrumboardId`) ,
    INDEX `fk_scrumboard_teamId` (`teamId` ASC) ,
    INDEX `fk_scrumboard_releaseId` (`releaseId` ASC) ,
    CONSTRAINT `fk_scrumboard_teamId`
        FOREIGN KEY (`teamId` )
        REFERENCES `agile`.`team` (`teamId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_scrumboard_releaseId`
        FOREIGN KEY (`releaseId` )
        REFERENCES `agile`.`release` (`releaseId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`scrumboardColumn`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`scrumboardColumn` (
    `scrumboardColumnId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `scrumboardId` INT(11) UNSIGNED NOT NULL ,
    `column` VARCHAR(255) NOT NULL ,
    `priority` INT(11) UNSIGNED NOT NULL ,
    PRIMARY KEY (`scrumboardColumnId`) ,
    INDEX `fk_scrumboardColumn_scrumboardId` (`scrumboardId` ASC) ,
    CONSTRAINT `fk_scrumboardColumn_scrumboardId`
        FOREIGN KEY (`scrumboardId` )
        REFERENCES `agile`.`scrumboard` (`scrumboardId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`ticket`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`ticket` (
    `ticketId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `colour` VARCHAR(45) NULL ,
    `cssHash` VARCHAR(6) NULL ,
    `content` TEXT null,
    PRIMARY KEY (`ticketId`) )
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`scrumboardColumData`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`scrumboardColumData` (
    `scrumboardColumnDataId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `scrumboardId` INT(11) UNSIGNED NOT NULL ,
    `scrumboardColumnId` INT(11) UNSIGNED NOT NULL ,
    `ticketId` INT(11) UNSIGNED NULL ,
    `isAction` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 ,
    `parentId` INT(11) UNSIGNED NOT NULL DEFAULT 0 ,
    PRIMARY KEY (`scrumboardColumnDataId`) ,
    INDEX `fk_scrumboardColumData_ticketId` (`ticketId` ASC) ,
    INDEX `fk_scrumboardColumData_scrumBoardId` (`scrumboardId` ASC) ,
    INDEX `fk_scrumboardColumData_scrumBoardColumnId` (`scrumboardColumnId` ASC) ,
    CONSTRAINT `fk_scrumboardColumData_ticketId`
        FOREIGN KEY (`ticketId` )
        REFERENCES `agile`.`ticket` (`ticketId` )
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    CONSTRAINT `fk_scrumboardColumData_scrumBoardId`
        FOREIGN KEY (`scrumboardId` )
        REFERENCES `agile`.`scrumboard` (`scrumboardId` )
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `fk_scrumboardColumData_scrumBoardColumnId`
        FOREIGN KEY (`scrumboardColumnId` )
        REFERENCES `agile`.`scrumboardColumn` (`scrumboardColumnId` )
        ON DELETE CASCADE
        ON UPDATE CASCADE)
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `agile`.`scrumBoardMapping`
    -- -----------------------------------------------------
    CREATE  TABLE IF NOT EXISTS `agile`.`scrumBoardMapping` (
    `scrumboardId` INT(11) UNSIGNED NOT NULL ,
    `doneColumnId` INT(11) UNSIGNED NOT NULL ,
    `actionTicketId` INT(11) UNSIGNED NOT NULL ,
    PRIMARY KEY (`scrumboardId`) ,
    INDEX `fk_scrumBoardMapping_doneColumnId` (`doneColumnId` ASC) ,
    INDEX `fk_scrumBoardMapping_actionTicketId` (`actionTicketId` ASC) ,
    CONSTRAINT `fk_scrumBoardMapping_doneColumnId`
        FOREIGN KEY (`doneColumnId` )
        REFERENCES `agile`.`scrumboardColumn` (`scrumboardColumnId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_scrumBoardMapping_actionTicketId`
        FOREIGN KEY (`actionTicketId` )
        REFERENCES `agile`.`ticket` (`ticketId` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;



    SET SQL_MODE=@OLD_SQL_MODE;
    SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
    SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;