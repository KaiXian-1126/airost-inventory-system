/*
Navicat MySQL Data Transfer

Source Server         : Airost
Source Server Version : 100110
Source Host           : localhost:3306
Source Database       : airost

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2020-07-02 13:12:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for application
-- ----------------------------
DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `ApplicationID` int(20) NOT NULL,
  `ApplicantID` int(255) NOT NULL,
  `ApproverID` int(20) DEFAULT NULL,
  `Amount` int(20) NOT NULL,
  `AppliedDate` date NOT NULL,
  `BorrowDate` date NOT NULL,
  `ReturnDate` date NOT NULL,
  `ApprovedDate` date DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(20) NOT NULL,
  `InventoryID` int(20) NOT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ApplicationID`),
  KEY `ApplicantID` (`ApplicantID`),
  KEY `ApproverID` (`ApproverID`),
  KEY `InventoryID` (`InventoryID`),
  CONSTRAINT `application_ibfk_1` FOREIGN KEY (`ApplicantID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `application_ibfk_2` FOREIGN KEY (`ApproverID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `application_ibfk_3` FOREIGN KEY (`InventoryID`) REFERENCES `inventory` (`InventoryID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of application
-- ----------------------------

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `InventoryID` int(20) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `ItemAmount` int(20) NOT NULL,
  `BorrowAmount` int(20) NOT NULL,
  PRIMARY KEY (`InventoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES ('1', 'Battery', '7', '0');
INSERT INTO `inventory` VALUES ('2', 'Robot', '10', '0');
INSERT INTO `inventory` VALUES ('3', 'new item', '5', '0');

-- ----------------------------
-- Table structure for itemreturn
-- ----------------------------
DROP TABLE IF EXISTS `itemreturn`;
CREATE TABLE `itemreturn` (
  `ReturnID` int(20) NOT NULL,
  `AppID` int(20) NOT NULL,
  `ItemLoss` int(20) DEFAULT NULL,
  `ReturnAmount` int(20) DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `LossReason` varchar(255) DEFAULT NULL,
  `ItemID` int(20) NOT NULL,
  PRIMARY KEY (`ReturnID`),
  KEY `AppID` (`AppID`),
  KEY `ItemID` (`ItemID`),
  CONSTRAINT `itemreturn_ibfk_1` FOREIGN KEY (`AppID`) REFERENCES `application` (`ApplicationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `itemreturn_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`InventoryID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of itemreturn
-- ----------------------------

-- ----------------------------
-- Table structure for report
-- ----------------------------
DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `ReportID` int(20) NOT NULL,
  `DateGenerated` date NOT NULL,
  `UserID` int(20) NOT NULL,
  PRIMARY KEY (`ReportID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserID` int(20) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Position` varchar(20) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'TOK KAI XIAN', '123456', 'kaixiana@gmail.com', '0123456789', 'MANAGEMENT LEVEL');
INSERT INTO `user` VALUES ('2', 'TAN ZHI QUAN', '123456', 'kaixiana@gmail.com', '01113005114', 'GENERAL MEMBER');
