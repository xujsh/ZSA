create table teacher
(
	id int(11) not null auto_increment,
	fullname varchar(32) not null,
	gender tinyint(1) not null default 0,
	age int(2) not null,
	national varchar(32) not null,
	picid int(11) not null default 0,
	phone varchar(64) null,
	qq varchar(64) null,
	skype varchar(64) null,
	email varchar(64) null,
	createtime datetime not null,
	deltag tinyint(1) not null default 0,
	primary key(id)
) ENGINE=InnoDB;

create index idx_deltag on teacher(deltag);

create table student_permission
(
	id int(11) not null auto_increment,
	studentid int(11) not null,
	pname varchar(32) not null,
	expireddate date not null,
	bookcount int(11) not null,
	createtime datetime not null,
	deltag tinyint(1) not null default 0,
	primary key(id)
) ENGINE=InnoDB;

create table schedue
(
	id int(11) not null auto_increment,
	teacherid int(11) not null,
	studentid int(11) not null,
	studydate date not null,
	studytimeid int(5) not null,
	memo varchar(254) null,
	status tinyint(2) not null default 0,
	createtime datetime not null,
	deltag tinyint(1) not null default 0,
	primary key(id)
) ENGINE=InnoDB;

create index idx_deltag on schedue(deltag);
create index idx_teacherid on schedue(teacherid);
create index idx_studentid on schedue(studentid);
create index idx_studydate on schedue(studydate);
create index idx_studytimeid on schedue(studytimeid);
create index idx_status on schedue(status);

// schedue status 0=预订 1=上课中 2=完成 3=旷课 4=取消
// studytimeid 0-24点，每30分钟计数

create table scheduelog
(
	id int(11) not null auto_increment,
	schedueid int(11) not null,
	status tinyint(2) not null default 0,
	createtime datetime not null,
	primary key(id)
) ENGINE=InnoDB;


create table pic
(
	id int(11) not null auto_increment,
	filepath varchar(254) not null,
	fileext varchar(16) not null,
	filetype varchar(64) not null,
	createtime datetime not null,
	deltag tinyint(1) not null default 0,
	primary key(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `teacher_available_time` (
  `id` int(11) NOT NULL auto_increment,
  `teacherid` int(11) NOT NULL,
  `timeid` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `teacherid` (`teacherid`,`timeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

create table activate_code
(
	id int(11) not null auto_increment,
	code varchar(32) not null,
	codetype int(5) not null default 0,
 	desctext varchar(254) not null,
 	status tinyint(1) not null default 0,
 	activatedate datetime null,
 	userid int(11) null,
 	primary key(id)
) ENGINE=InnoDB;

create index idx_code on activate_code(code);

CREATE TABLE IF NOT EXISTS `schedue_comment` (
  `id` int(11) NOT NULL auto_increment,
  `schedueid` int(11) NOT NULL,
  `score_a` tinyint(2) NOT NULL,
  `score_b` tinyint(2) NOT NULL,
  `score_c` tinyint(2) NOT NULL,
  `content` varchar(500) NOT NULL,
  `addtime` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `schedueid` (`schedueid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL auto_increment,
  `schedueid` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `content` varchar(500) NOT NULL,
  `addtime` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `schedueid` (`schedueid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` int(11) NOT NULL auto_increment,
  `loginname` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `createtime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `admin_user`
--

INSERT INTO `admin_user` (`id`, `loginname`, `password`, `createtime`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2013-06-03 21:46:49'),
(3, 'merlin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00');

create table teacher_note
(
	id int(11) not null auto_increment,
	schedueid int(11) not null,
	studentid int(11) not null,
	teacherid int(11) not null,
	content text null,
	createtime datetime not null,
	deltag tinyint(1) not null default 0,
	primary key(id)
) ENGINE=InnoDB;

ALTER TABLE  `schedue` ADD  `coursetool` VARCHAR( 10 ) NOT NULL AFTER  `studytimeid`
