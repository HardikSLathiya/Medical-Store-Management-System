-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2018 at 07:22 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: medshop1
--

-- --------------------------------------------------------

--
-- Table structure for table employee
--

CREATE TABLE employee (
  empid int(5) NOT NULL,
  name varchar(15) NOT NULL,
  phone text NOT NULL,
  address varchar(255) NOT NULL,
  salary decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table employee
--

INSERT INTO employee VALUES(2, 'hardik lathiya', '8154076097', 'C1-304 Golden City , opp.Utran Power house,Utran, Motavarachha', '15000.00');
INSERT INTO employee VALUES(3, 'Milan Zadfiya', '5684123541', 'C-304,GOLDEN CITY APPARTMENT  UTRAN', '15000.00');

-- --------------------------------------------------------

--
-- Table structure for table medicine
--

CREATE TABLE medicine (
  mname varchar(15) NOT NULL,
  exdate varchar(10) NOT NULL,
  chamt varchar(10) NOT NULL,
  qty int(5) UNSIGNED NOT NULL,
  cp decimal(4,2) NOT NULL,
  sp decimal(4,2) NOT NULL,
  c1 varchar(15) NOT NULL,
  c2 varchar(15) NOT NULL,
  c3 varchar(15) NOT NULL,
  pname varchar(20) NOT NULL,
  notes varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table medicine
--

INSERT INTO medicine VALUES('asprin', '12-2019', '500mg', 521, '1.00', '2.30', 'asprin', '-', '-', 'HSL Pharmacies', '-');
INSERT INTO medicine VALUES('cipla', '01-2019', '500mg', 440, '2.00', '2.00', 'cipla', '-', '-', 'HSL Pharmacies', '-');
INSERT INTO medicine VALUES('paracetamol', '23-2025', '500mg', 500, '1.30', '2.50', 'paracetamol', '-', '-', 'HSL Pharmacies', 'Pain Killer');
INSERT INTO medicine VALUES('tavist', '23-2025', '500mg', 352, '1.00', '1.50', 'tavist', '-', '-', 'HSL Pharmacies', '-');

-- --------------------------------------------------------

--
-- Table structure for table medsell
--

CREATE TABLE medsell (
  id int(5) NOT NULL,
  cname varchar(30) NOT NULL,
  medsell int(5) NOT NULL,
  selldate date NOT NULL,
  qty int(5) NOT NULL,
  total decimal(5,2) NOT NULL,
  notes varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table medsell
--

INSERT INTO medsell VALUES(1, 'Hardik Lathiya', 1, '2018-04-16', 10, '20.00', '-');
INSERT INTO medsell VALUES(2, 'Hardik Lathiya', 1, '2018-04-16', 10, '20.00', '-');
INSERT INTO medsell VALUES(3, 'Hardik Lathiya', 1, '2018-04-16', 50, '100.00', '-');
INSERT INTO medsell VALUES(4, 'Hardik Lathiya', 1, '2018-04-16', 10, '20.00', '-');

-- --------------------------------------------------------

--
-- Table structure for table supplier
--

CREATE TABLE supplier (
  phname varchar(30) NOT NULL,
  sname varchar(30) NOT NULL,
  phone text NOT NULL,
  address varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id int(11) NOT NULL,
  username varchar(15) NOT NULL,
  password varchar(20) NOT NULL,
  role varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table users
--

INSERT INTO users VALUES(1, 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table employee
--
ALTER TABLE employee
  ADD PRIMARY KEY (empid);

--
-- Indexes for table medicine
--
ALTER TABLE medicine
  ADD PRIMARY KEY (mname);

--
-- Indexes for table medsell
--
ALTER TABLE medsell
  ADD PRIMARY KEY (id);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table employee
--
ALTER TABLE employee
  MODIFY empid int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table medsell
--
ALTER TABLE medsell
  MODIFY id int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
