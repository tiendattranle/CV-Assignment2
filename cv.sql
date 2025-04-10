CREATE DATABASE IF NOT EXISTS cv;
USE cv;

-- Table structure for table cv_info
CREATE TABLE IF NOT EXISTS cv_info (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  address VARCHAR(200) NOT NULL,
  phone VARCHAR(11) NOT NULL,
  email VARCHAR(50) NOT NULL,
  birthday DATE NOT NULL,
  gender VARCHAR(10) NOT NULL,
  language VARCHAR(20) NOT NULL,
  skill VARCHAR(500) NOT NULL,
  companyname VARCHAR(100) NOT NULL,
  cstartdate DATE NOT NULL,
  cposition VARCHAR(150) NOT NULL,
  varsityname VARCHAR(100) NOT NULL,
  cgpa VARCHAR(5) NOT NULL,
  varsitypyear DATE NOT NULL,
  collegename VARCHAR(100) NOT NULL,
  hscgpa VARCHAR(5) NOT NULL,
  clgpyear DATE NOT NULL,
  schoolname VARCHAR(100) NOT NULL,
  sscgpa VARCHAR(5) NOT NULL,
  sclpyear DATE NOT NULL,
  image VARCHAR(100) NOT NULL,
  username VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cv_info
-- INSERT INTO cv_info (id, name, address, phone, email, birthday, gender, language, skill, companyname, cstartdate, cposition, varsityname, cgpa, varsitypyear, collegename, hscgpa, clgpyear, schoolname, sscgpa, sclpyear, image, username) VALUES
-- (1, 'Raihan Mahmud', 'Dhamondi', '01750675743', 'raihan35-1542@diu.edu.bd', '1995-12-18', 'male', 'English', 'C, C#, Dot net MVC', 'Softcare IT', '2017-12-02', 'Dot net Developer', 'Daffodil International University', '3.25', '2019-12-31', 'Brindaban Govt. Collage', '4.00', '2015-04-14', 'Rajar Bazar Govt. High School', '5.00', '2013-03-14', 'images/my.jpg', 'raihan'),
-- (2, 'Rony Mahmud', 'Sylhet', '01743527252', 'mahmudrony95@gmail.com', '1996-12-15', 'male', 'English', 'C, php', '', '0000-00-00', '', 'DIU', '3.25', '2019-12-31', 'Brindaban Govt. Collage', '4.00', '2015-04-14', 'Rajar Bazar Govt. High School', '5.00', '2013-03-14', 'images/my2.jpg', 'raihan1542'),
-- (3, 'Rony', 'Sylhet', '017', 'mahmudrony95@gmail.com', '1995-12-18', 'male', 'English', 'C#', '', '0000-00-00', '', '', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', 'images/', 'rony');

-- Table structure for table login
CREATE TABLE IF NOT EXISTS login (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login
-- INSERT INTO login (id, username, email, password) VALUES
-- (1, 'raihan', 'raihan35-1542@diu.edu.bd', '1055'),
-- (2, 'raihan1542', 'mahmudrony95@gmail.com', '1542'),
-- (3, 'rony', 'mahmudrony95@gmail.com', '105500');