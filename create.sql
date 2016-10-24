--
-- Table structure for table `Actor`
--

DROP TABLE IF EXISTS `Actor`;
CREATE TABLE `Actor` (
  `id` int(11) NOT NULL,
  `last` varchar(20) DEFAULT NULL,
  `first` varchar(20) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `dod` date DEFAULT NULL,
  PRIMARY KEY (`id`),   -- primary key constrain of Actor, id of an actor should be unique
  CHECK(`sex` = "Female" OR `sex` = "Male")  -- sex should be either female of male
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `Director`
--

DROP TABLE IF EXISTS `Director`;
CREATE TABLE `Director` (
  `id` int(11) NOT NULL,
  `last` varchar(20) DEFAULT NULL,
  `first` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `dod` date DEFAULT NULL,
  PRIMARY KEY (`id`),      -- primary key constrain of Director, id of a director should be unique
  CHECK(`dod` > `dob`)     -- date of death should be later than date of birth
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `MaxMovieID`
--

DROP TABLE IF EXISTS `MaxMovieID`;
CREATE TABLE `MaxMovieID` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT MaxMovieID VALUE(4750);

--
-- Table structure for table `MaxPersonID`
--

DROP TABLE IF EXISTS `MaxPersonID`;
CREATE TABLE `MaxPersonID` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT MaxPersonID VALUE(69000);


--
-- Table structure for table `Movie`
--

DROP TABLE IF EXISTS `Movie`;
CREATE TABLE `Movie` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),        -- primary key constrain of Movie, id of a movie should be unique
  CHECK (`year` >= 1895)     -- film started from 1895
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `MovieActor`
--

DROP TABLE IF EXISTS `MovieActor`;
CREATE TABLE `MovieActor` (
  `mid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  FOREIGN KEY (`mid`) references Movie(`id`), -- foreign key constraint between Movie and MovieActor
  FOREIGN KEY (`aid`) references Actor(`id`) -- foreign key constraint between Actor and MovieActor
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `MovieDirector`
--

DROP TABLE IF EXISTS `MovieDirector`;
CREATE TABLE `MovieDirector` (
  `mid` int(11) DEFAULT NULL,
  `did` int(11) DEFAULT NULL,
  FOREIGN KEY (`mid`) references Movie(`id`), -- foreign key constraint between Movie and MovieDirector
  FOREIGN KEY (`did`) references Director(`id`) -- foreign key constraint between Movie and MovieDirector
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `MovieGenre`
--

DROP TABLE IF EXISTS `MovieGenre`;
CREATE TABLE `MovieGenre` (
  `mid` int(11) DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  FOREIGN KEY (`mid`) references Movie(`id`)  -- foreign key constraint between Movie and MovieGenre
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `Review`
--

DROP TABLE IF EXISTS `Review`;
CREATE TABLE `Review` (
  `name` varchar(20) NOT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  FOREIGN KEY (`mid`) references Movie(`id`),  -- foreign key constraint between Movie and Review
  CHECK(`rating` >= 1 AND `rating` <= 5) -- set rating between 1 and 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


