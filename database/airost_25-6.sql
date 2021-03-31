/*
Navicat MySQL Data Transfer

Source Server         : Airost
Source Server Version : 100110
Source Host           : localhost:3306
Source Database       : airost

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2020-06-25 19:03:04
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
  KEY `Amount` (`Amount`) USING BTREE,
  KEY `FK_ApplicantID` (`ApplicantID`) USING BTREE,
  KEY `FK_ApproverID` (`ApproverID`) USING BTREE,
  KEY `FK_BorrowItemID` (`InventoryID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of application
-- ----------------------------
INSERT INTO `application` VALUES ('1', '1', '1', '2', '2020-06-24', '2020-06-30', '2020-07-02', '2020-06-24', 'For competition purpose', 'APPROVED', '1', '');
INSERT INTO `application` VALUES ('2', '1', '1', '2', '2020-06-24', '2020-06-30', '2020-07-02', '2020-06-24', 'For competition purpose', 'REJECTED', '1', 'long borrow time');
INSERT INTO `application` VALUES ('3', '1', '1', '1', '2020-06-25', '2020-06-02', '2020-06-08', '2020-06-25', '', 'REJECTED', '1', 'das');

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
INSERT INTO `inventory` VALUES ('1', 'Battery', '7', '2');
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
  KEY `FK_ApplicationID` (`AppID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of itemreturn
-- ----------------------------
INSERT INTO `itemreturn` VALUES ('1', '1', null, null, null, null, '1');

-- ----------------------------
-- Table structure for report
-- ----------------------------
DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `ReportID` int(20) NOT NULL,
  `DateGenerated` date NOT NULL,
  `UserID` int(20) NOT NULL,
  PRIMARY KEY (`ReportID`),
  KEY `UserID` (`UserID`) USING BTREE
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
INSERT INTO `user` VALUES ('2', 'TAN ZHI QUAN', '123', 'kaixiana@GMAIL.COM', '1234', 'GENERAL MEMBER');
INSERT INTO `user` VALUES ('9', 'TOK KAI XIANn', '123', 'kaixianp@gmail.com', '1113005114', 'GENERAL MEMBER');
INSERT INTO `user` VALUES ('10', 'TOK KAI XIAN333', '123', 'kaixian98@yahoo.com', '1113005114', 'GENERAL MEMBER');
INSERT INTO `user` VALUES ('11', 'LEE', '123', 'kaixianp@gmail.com', '01113005114', 'GENERAL MEMBER');
INSERT INTO `user` VALUES ('12', 'tan', '123', 'kaixianp@gmail.com', '01113005114', '');
INSERT INTO `user` VALUES ('13', '123', '123', 'kaixianp@gmail.com', '01113005114', '');
