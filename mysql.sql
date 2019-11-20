CREATE TABLE IF NOT EXISTS `cases` (
  `caseID` int(11) NOT NULL AUTO_INCREMENT,
  `case_name` varchar(250) NOT NULL,
  `case_text` text NOT NULL,
  `case_date` varchar(100) NOT NULL,
  `case_to` varchar(50) NOT NULL,
  `case_from` varchar(50) NOT NULL,
  `case_status` varchar(20) NOT NULL,
  `case_attachment` text NOT NULL,
  `case_posted` varchar(6) NOT NULL,
  `case_received` varchar(6) NOT NULL,
  `case_d` varchar(20) NOT NULL,
  PRIMARY KEY (`caseID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `notice` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_subject` varchar(200) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_to` varchar(20) NOT NULL,
  `comment_from` varchar(20) NOT NULL,
  `comment_status` varchar(20) NOT NULL,
  `comment_date` varchar(100) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `userType` varchar(50) NOT NULL,
  `userState` varchar(200) NOT NULL,
  `userLevel` varchar(20) NOT NULL,
  `regTime` varchar(200) NOT NULL,
  `lastSeen` varchar(200) NOT NULL,
  `courtID` int(11) NOT NULL,
  `court_name` varchar(100) NOT NULL,
  `court_text` text NOT NULL,
  `court_status` varchar(20) NOT NULL,
  `court_address` text NOT NULL,
  `court_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
