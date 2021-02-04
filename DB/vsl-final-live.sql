-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2020 at 12:39 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsl`
--

-- --------------------------------------------------------

--
-- Table structure for table `collect_bills`
--

CREATE TABLE `collect_bills` (
  `id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `collection_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`) VALUES
(1, 'Venture Solution'),
(2, 'Moiur'),
(3, 'Fintech');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`) VALUES
(7, 'Administration'),
(9, 'Creative Design'),
(6, 'Feature & Content'),
(8, 'Fintech Marketing'),
(1, 'Marketing Department'),
(3, 'Operations'),
(4, 'Production And Distribution'),
(2, 'Software Development'),
(5, 'Venture marketing');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `department_id`, `designation_name`) VALUES
(1, 2, 'Software Engineer'),
(2, 1, 'Marketing Manager'),
(3, 2, 'Technical Lead'),
(4, 1, 'Sales Manager'),
(6, 2, 'Junior Software Engineer'),
(7, 2, 'Senior Software Engineer'),
(8, 2, 'Junior Software Engineer (Intern)'),
(9, 3, 'Assistant Manager'),
(10, 4, 'Junior Executive'),
(11, 5, 'Junior Executive'),
(12, 5, 'Sr.Executive, Sales & marketing'),
(13, 6, 'Feature Writer'),
(14, 5, 'Vice President'),
(15, 6, 'Manager,Brand Communication'),
(16, 7, 'Director'),
(17, 7, 'Business Editor'),
(18, 3, 'Jr. Executive'),
(19, 8, 'Marketing Executive,Brand Communication'),
(20, 2, 'Associate Software Engineer'),
(21, 4, 'Junior Executive Production & Distribution'),
(22, 9, 'Creative Lead'),
(23, 6, 'Feature Writer and Reporter'),
(24, 7, 'CTO');

-- --------------------------------------------------------

--
-- Table structure for table `developer_tasks`
--

CREATE TABLE `developer_tasks` (
  `id` int(23) NOT NULL,
  `title` varchar(255) NOT NULL,
  `department_id` int(10) NOT NULL,
  `task_manager` int(10) NOT NULL,
  `assignment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(10) NOT NULL,
  `team_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_date` timestamp NULL DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL,
  `user_updated_date` datetime NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(20) NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spouse_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_married` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `official_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person_relations` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_working_experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `references` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `join_date` date NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `company`, `father_name`, `mother_name`, `spouse_name`, `is_married`, `personal_phone`, `official_phone`, `current_address`, `permanent_address`, `national_id`, `passport_no`, `blood_group`, `emergency_contact_person`, `emergency_contact_person_relations`, `emergency_contact_person_phone`, `previous_working_experience`, `references`, `dob`, `join_date`, `resume`, `photo`, `work_type`, `created_at`) VALUES
(1, 1, '1,2,3', '43543543543', '43543', '435435', '', '45435', '43543', '45435435', '435435', '45435435', '435435435', '435435', '4354354', '435435', '45435', '45', '4354', '2020-02-04', '2018-02-03', 'Book1.xlsx', 'idea-creativity-infographic-png-favpng-X74dA766egipPwLSM6CZJRTrt.jpg', 1, '2020-02-03 07:20:27'),
(56, 7, '1', 'Md. Atiyar Rahman', 'Mst.Tahmina khatun', '', 'unmarried', '01686129484', '', 'Jatrabari,1236 Dhaka (Bangladesh)', 'Ratanganj-7501,Narail sadar, Narail,Bangladesh', '3751885918', '', 'A+', 'Md. Atiyar Rahman', 'father', '01716344781', '0', '', '1996-06-03', '2019-10-16', 'a8e12a72ab465714fd409731820b9e9d.pdf', '639f6ab515b2c59eecc4282312fb2008.jpg', 1, '2020-02-09 08:38:22'),
(58, 10, '2', 'Mir Abdul Hamid', 'Hena Begum', '', 'unmarried', '01684239748', '', '84/2/85 Dhalkanagar, Gandaria, Dhaka', '84/2/85 Dhalkanagar, Gandaria, Dhaka', '8222085485', '', 'O+', 'Mir Abdul Hamid', 'father', '01818794298', '1.0', '', '1992-07-18', '2019-09-21', 'da120a68c4829c8a00f3bed67aadf118.pdf', '0c8708e4dfd170fffaca59de95473771.jpg', 2, '2020-02-09 09:22:11'),
(59, 11, '1', 'Abdul Khalek Sikder', 'Rajiya Begum', '', 'unmarried', '01646442925', '', 'Khilgaon, Dhaka.', 'Barishal, kuakata', '100457815', '', 'A+', 'Jakir', 'Brother', '01677703014', '4.0', '', '1989-05-10', '2019-10-07', '2a2c386860c22d081991e2dc97e5ec47.jpg', '7cafe2f6c27b4de9b2b34c2aaaae3fe5.jpg', 2, '2020-02-09 09:35:49'),
(60, 12, '2', 'Altap Hossain', 'Safura khathun', '', 'unmarried', '01724265446', '88027192901', '174/1A tejkuni para,Tejgoan,Dhaka 1215', 'Gazipur,Sriula, Assasuni, Satkhira,khulana Bangladesh,9460', '8710494595681', 'EA0047085', 'AB+', 'Ashique Iqbal', 'Brother', '01911765220', '2.5', '', '1989-03-20', '2019-07-15', '84f9ad6affdeac3ff037cf4a0dbb7ffa.doc', '0a6d077a7841054d448cea936f66406f.jpg', 2, '2020-02-09 09:53:28'),
(61, 13, '1', 'Md. Rafiqul Islam', 'Hasina Begum', '', 'unmarried', '01859443458', '01624344039', 'Gopibag, Motijheel, Dhaka, Bangladesh', 'Matain Kot, Ali-shor, Sadar South, Cumilla,Bangladesh', '1953364146', '', 'O+', 'Md. Rafiqul Islam', 'Father', '01831659716', '0.7', 'Nazurl Islam (Software Engineer at Venture  Solution)', '1997-04-13', '2019-07-08', '4d5b136ebb90bd71f226b677aaa469d0.pdf', 'df08142fb0fc7d2d6036aee591c1bd2c.png', 2, '2020-02-09 10:03:32'),
(62, 14, '1', 'MD. Yusuf Sarker', 'Bilquis Akter', '', 'unmarried', '01937424217', '', 'Jonotabag Hazi Osim Uddin Road, House: 49/7', 'Same as current address.', '2354968139', '', 'A-', 'Bilquis Akter', 'Mother', '01920476056', '0', '', '1995-05-26', '2019-05-16', '925776ad3ea79d8aa0d1af57965806b7.pdf', 'b5560ce859d3f445149ad1c98aae11a3.jpg', 2, '2020-02-09 10:19:32'),
(63, 15, '2', 'Late Taslim Uddin', 'Farida Yeasmin', '', 'unmarried', '01718149568', '', 'east rampura', 'Vill: Mominpur, Post: Ukhariabari, Upazilla: Dhanbari                                                  District: Tangail', '19909312547000006', '', 'A+', 'M.A. Hojaiffa Noman', 'Brother', '01713329475', '2.0', 'M.A. Hojaiffa Noman', '1990-10-19', '2019-04-11', '4d27f88e1ba037bc09d46247797a0050.doc', 'c35f08240ba9ce984c0db5a98eec70aa.jpg', 2, '2020-02-09 10:39:41'),
(64, 16, '1', 'Sushanta Kumar Biswas', 'Shipra Mazumder', '', 'unmarried', '01521459324', '', '36/3 Masjid Road , Dhankhetermor , Mirpur 1', '36/3 Masjid Road , Dhankhetermor , Mirpur 1', '19966517647000146', '', 'B+', 'Sushanta Kumar Biswas', 'Father', '01728847987', '0', '', '1996-08-08', '2019-05-01', 'f8bc8d43be2758591ae531c324571f0a.pdf', 'f059968f1629389cf4e14f52485476fb.jpg', 2, '2020-02-09 10:47:54'),
(65, 17, '1', 'M.Altaf Hossain', 'Mahmuda sultana', '', '', '01704521264', '', '1598, South Dania, Dhaka', '1598, South Dania, Dhaka', '4642631099', '', 'AB+', 'M.Altaf Hossain', 'Father', '01716512126', '0.6', '', '1990-10-17', '2019-03-20', 'c7f119e5117843fbac5a356505665395.docx', '0fadf144f4a47abf4bde2b4c078c4ed5.jpg', 2, '2020-02-09 11:00:11'),
(66, 18, '1', 'Syed Munsurul Haque', 'Syeda Arefa Haque', '', 'married', '01711206014', '', 'Vill - Karary, Post,- Rakhalgachy,Dist.-Bagerhat', 'Vill - Karary, Post,- Rakhalgachy,Dist.-Bagerhat', '1922779028', '', 'AB+', 'Syeda Rukshana Haque', 'Sister', '01720994515', '8.0', 'Mizan Sir', '1978-12-01', '2019-02-10', 'ac5b3478067b81b5a69234e17b84023c.pdf', '0f7ecae6a5a939093668f801e5686b36.jpg', 2, '2020-02-09 11:24:10'),
(68, 22, '1', 'A. B. M Golam Mostafa', 'Khaleda Mostafa', '', 'married', '01720571129', '01911601026', 'House - 12, Road - 4,  Block - J, Banasree, Rampura. Dhaka - 1219', 'House - 12, Road - 4,  Block - J, Banasree, Rampura. Dhaka - 1219', '8663873266', '', 'B+', 'Dr. Sadia Afrin Bannya', '', '01764484078', '4', 'Name: Shabu Anwar Designation: CEO, Marks and Marker. Address: House No. 20, Road No. 2 Block#C. Banasree, Dhaka. Cell No: 01732807555 Contact: 03772001535 (office) Web site: www.marksandmarker.com www.bloggymedia.com  Name: Nafiul Alam Choudhury  Designation: Managing Director, JadeWits Technologies Limited.  Address: House No. 8, Road No. 3  Block#A. Banasree, Dhaka.  Cell No: 01713204715  Contact: 028399641 (office)  Web site: jadewits.com', '1991-06-12', '2019-03-02', 'd3ad9dfcc59a058e442688df4cd8825a.pdf', '0ff3bd7923ff2aa9c79369a67fa92220.jpg', 2, '2020-02-09 11:50:26'),
(69, 23, '1', 'Maznu Mondol', 'Rabeya Begum', '', 'unmarried', '01902713613', '', 'Jha#48,Road#09,Middle Badda, Gulshan-1, Dhaka', 'Chilimpur,Kalihati, Tangail', '19959312843000123', '', 'B+', 'Ab. Halim', 'Brother', '01756652050', '0', 'Abu Saleh', '1995-09-01', '2018-10-01', '50d7515612fb5556cd96ba13a9f9063e.docx', '8d217f4c24486bed917e93e66170bc15.jpg', 2, '2020-02-09 12:00:42'),
(70, 24, '1', 'Md. Nazrul Islam', 'Hasina Begum', '', 'married', '01911311175', '', 'Flat-21 E4, Sukrabad, Dhaka', 'Vill- Vangagate, Thana- Avoynagor, Jella- Jessore', '19922695017000123', '', 'A+', '', 'Father', '01920639933', '6', '', '1992-12-07', '2018-10-15', 'b9125595b29c935a550f8d3c0583a245.pdf', 'd94188c901e60b1c98f5108a2ad76a83.jpg', 2, '2020-02-09 12:27:25'),
(71, 25, '1', 'Syed Tareq Ahmed', 'Kishwer Jahan', '', '', '01916572338', '', '42/F Indira Road, Forum Apartment A/4, Tejgaon, Dhaka-1215.', '42/F Indira Road, Forum Apartment A/4, Tejgaon, Dhaka-1215.', '5529255563', '', 'B+', 'Kishwer Jahan', 'Mother', '01913151504', '6', '', '1990-02-07', '2018-09-01', 'faaa86f7fbac99f599417afba0ed41ba.docx', '66c102e5586a9dc8b19ef20ebf7ed5f5.png', 2, '2020-02-09 12:36:43'),
(72, 26, '1', 'Md. Khalilur Rahman', 'Mst. Mamataz Begum', '', 'married', '01612126345', '01712126345', 'House No: 1476/3, Khilgaon, Dhaka-1219, Bangladesh', 'Village: Dhipur, Post Office: Goshairhut, Thana: Goshairhut, District: Shawrioutpur, Bangladesh', '19772693623847624', 'BE0442091', 'B+', '', '', '01816811440', '15.0', 'MD. Anisur Rahman    UCBL (United Commercial Bank Ltd).    Branch Manager, (Corporate Banking Division)    Banani Branch, Banani, Dhaka.    +8801714038199    anis.rahman@ucbl.com', '1977-01-03', '2018-07-21', '6fd768cc2d84b7cd61add8611036b3a5.doc', '2304762da6b8275320d003f1ba007e28.jpg', 2, '2020-02-09 12:57:05'),
(73, 27, '1', 'x', 'y', '', '', '0125', '', 'asd', 'asd', '1234', '', 'A+', '', '', '', '', '', '1988-03-09', '2016-09-01', '4b8e029c079dddd50baff4d1a9940ca8.jpeg', '97201c5a78f7873249e5bf082f35732c.jpeg', 2, '2020-02-09 13:13:57'),
(74, 28, '1', 'x', 'y', '', 'married', '01712555117', '', 'addd', 'add', '', '', 'A+', '', '', '', '', '', '1980-07-09', '2017-07-01', '5e045ce4ceb360d36d4a0130e915c7d2.jpeg', 'cb3f5e64e168fd2d85041d22f84aef56.jpeg', 2, '2020-02-09 13:26:32'),
(75, 29, '1', 'x', 'y', '', '', '43434', '', 'road no - 3 , house no - 7 , 4th floor', 'road no - 3 , house no - 7 , 4th floor', '23434', '', '', '', '', '', '', '', '1986-07-16', '2020-02-09', 'b4623ae3bddf3e895c4c5c5628477bc0.jpeg', 'dca68779a09fd401416d58c4d05598b2.jpeg', 2, '2020-02-09 13:32:30'),
(76, 30, '1', 'Fazlur Rahman', 'Mamataz Begum', '', '', '01710877990', '', '120/B, sahjahanpur, Dhaka', '120/B, sahjahanpur, Dhaka', '1234', '', 'B+', 'xyz', '', '1234', '0', '', '1985-07-24', '2018-06-26', '649c94fffb46885d700ef4d1e3335ed1.pdf', '046737e77921a1390c7705afb406e975.png', 2, '2020-02-10 04:23:20'),
(77, 31, '2', 'Md. Laal mia', 'Jahida Begum', '', 'married', '01720819450', '', '120/B/1, Uttar Shajahanpur,Dhaka', 'Village: Vashanee Sarak, Post:mongla-9350, District: Bagerhat', '19810125808000004', '', 'B+', 'Didar', '', '01720819450', '5', '', '1981-10-10', '2016-11-22', '28ebd65a380473c1899de9a4d7218650.docx', '2326384b2c4c8ce937fb1843576c52fa.docx', 2, '2020-02-10 04:36:02'),
(78, 32, '3', 'Kazi Emdadul Haque', 'Taslima Begum', '', 'unmarried', '01710495278', '', 'Balita, Sreenagor, Munshigonj', 'Balita, Sreenagor, Munshigonj', '19925918494000035', '', 'B-', 'Kazi Emdadul Haque', 'Father', '01726737761', '0', '', '1992-01-31', '2018-02-01', '0ad16ec181d97a1d87f3f8e12487308b.doc', '0b6c31604b626cbf9be6330c02a22783.jpg', 2, '2020-02-10 04:47:27'),
(79, 33, '1', 'Motiar Rahman', 'Fahmida Rahman', '', 'unmarried', '01676415198', '01676415198', 'H-168,Road-7, Rafiq Housing ,Shekertek,Mohammadpur,Dhaka,1207', 'H-94,Pabla,Daulatpur,Khulna', '19924792106000126', '', 'O+', 'Fahmida Rahman', 'Mother', '01712625461', '0', '', '1995-07-19', '2016-11-26', '8b8e1ee20c3ad43348787260a4d89ce1.pdf', '6b4dd475d447fac9c33016f36448fc18.jpg', 2, '2020-02-10 04:57:07'),
(80, 34, '1', 'Md. Alim Uddin', 'Hafiza Ferdousi', '', '', '01675461458', '', 'Ka-8 Jagannathpur, Bashundhara r/a dhaka', 'Vill: Borokhali, P.O: Mirzapur, Tha: Gopalpur, District: Tangail', '19936115223000002', '', 'O+', 'Md. Alim Uddin', 'Father', '01716722541', '3.0', 'Zahedul Alam Sr. Software Engineer  Workspace InfoTech', '1988-06-14', '2018-05-03', '56875b96bf422a20830afc7e7e9644ba.pdf', '5d5e681a4cda6037ce59f7781352d713.jpg', 2, '2020-02-10 05:06:51'),
(81, 35, '1', 'Late Mizanur Rahman', 'Nasima Begum', '', 'unmarried', '01928434000', '', '209/B, Lalbagh Road, BDR Gate-2, Azimpur, Dhaka', 'Village: Farmpara, Chuadanga Sadar, Chuadanga P.O.: Chuadanga- 7200 Division: Khulna, Bangladesh', '19951822308000167', '', 'B+', 'Nasima Begum', 'Mother', '01717912968', '0.8', 'i) Azmul Haque Additional District Commissioner, Magura Government of the People Republic of Bangladesh Mobile: +8801712126661 ii)Dr. Md. Samsuzzaman  Dept. of CCE, Faculty of CSE  Associate Professor  Patuakhali Science and Technology University, Dumki, Patuakhali - 8602  Mobile:01712653210', '1995-07-01', '2017-09-03', 'bcda8aab3d3261e836c8c52057493b2a.pdf', 'bdbd0ef65c2da8e8052a9f4bb21941c5.jpg', 2, '2020-02-10 05:13:33'),
(82, 36, '1', 'Dr. Md Alee Murtuza', 'Anwara Ferdousi', '', '', '01854562919', '', 'Dakkhin Hawa, Apartment-2B, House- 48 Road- 3A, Dhaka', 'Dakkhin Hawa, Apartment-2B, House- 48 Road- 3A, Dhaka', '133465', '', 'A+', 'ggjym', '', '13', '9.0', '', '1983-03-02', '2018-06-03', '652c304c7f3ae11e1f22170779af4132.jpg', '752afece56890e826f7399b1d91ed4a9.jpg', 2, '2020-02-10 05:20:47'),
(87, 41, '1', 'Md. Motalib Khalifa', 'Mst. Tasmilma', '', '', '1234', '', '123/2, West Jurain, Tula Bagicha Road, Faridabad, Shampur, Dhaka- 1204', 'same the current address', '297690562539', '', 'A+', '', '', '', '3', 'K. M. Faisal  IT Executive, SBAC Bank Ltd, Head Office', '1995-07-19', '2018-06-03', '1ef5a05af4d7d29f3c11ad50407d5da5.jpg', 'd1b5b5b929809eaa2149da302e818f10.jpg', 2, '2020-02-10 06:00:45'),
(88, 42, '1', 'Late Md. Mehtab Uddin Chowdhury', 'Aysha Akhter Begum', '', '', '01915172892', '', 'B/68 South Banasree, Gorun (1st Floor), Dhaka- 1214', 'Same the current address', '7750597085', '', 'A+', '', 'Mother', '01715028344', '8', '', '1988-03-26', '2016-12-01', 'c13397d9ac31ce3ce27ca1598b90d34a.jpg', '528253af025b3ab892ea0b6ebc093e0b.jpg', 2, '2020-02-10 06:13:25'),
(89, 43, '1', 'Late Golam Haider', 'Hosne Ara Begom', '', 'married', '01715601625', '', 'Eastern Banabithi Apartment Flat- 615, Plot- L-1/A, Main Road, South Banasree,  Dhaka- 1219', '3B.K.Road, jashore, Bangladesh', '2695435719482', '', 'A+', '', 'Wife', '01787718944', '15', '', '1980-03-12', '2016-09-03', '0f8fd0b7a1f72d80e8593bb8a8c17e77.jpg', '1f9dc8734089966b0db00a61a443dc05.jpg', 2, '2020-02-10 06:23:15'),
(91, 47, '1', 'Md. Abdur Razzak', 'Runa Parvin', '', '', '01717600424', '', '2/15-16, Tajmahol Road, Mohammadpu', '2/15-16, Tajmahol Road, Mohammadpu', '', '', 'O+', 'Md. Abdur Razzak', 'father', '01711392850', '7', '', '1988-01-01', '2016-12-18', 'c49ba66fc5a0161a476527b7d4499078.docx', 'ac9984eeb749684f1dd2ffdf224bfaaa.jpg', 2, '2020-02-10 07:13:27'),
(92, 48, '1', 'Md Mizanur Rahman', 'Ferdous Ara', 'Fahmina Sultana', 'married', '01819430692', '', '1st Floor, House 42, Road 3, Block E Banasree, Rampura Dhaka 1219', '1st Floor, House 42, Road 3, Block E Banasree, Rampura Dhaka 1219', '123', '', 'B-', 'Fahmina Sultana', '', '01833085207', '8', '', '1984-06-20', '2018-01-01', 'adb78f769ec985c1a6ec4575864b5ebd.pdf', '7441325d87f905bebc485a28e5a9804a.jpg', 2, '2020-02-10 07:21:00'),
(93, 49, '1', 'Sana ullah', 'Nasima akter', '', 'unmarried', '01854109774', '', 'adabor,Mohammmadpur,Dhaka', 'sonagazi,Feni', '', '', 'O+', 'Nasima akter', 'Mother', '01866086025', '0', '', '1999-02-11', '2020-01-01', 'a16d31dd78a1b25488c09ac5423b593a.pdf', 'ea0c5fea15b2f62f26af19d7c8eae9c3.jpg', 2, '2020-02-10 07:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `file_link` varchar(100) NOT NULL,
  `page_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `file_link`, `page_name`) VALUES
(1, 'task/create_developer_task.php', 'Create New Task'),
(3, 'mytask/my-marketing-task.php', 'My Marketing Task'),
(4, 'index.php', ''),
(5, 'dashboard.php', 'Home Page'),
(6, 'employee/edit_emp.php', ''),
(7, 'employee/index.php', 'All Employee Lists'),
(8, 'employee/new_employee.php', 'Add New Employee'),
(9, 'bills/collect_bill.php', 'Collect Bill'),
(10, 'bills/create_bill.php', 'Create New Bill'),
(11, 'bills/index-bill.php', 'All Bill List'),
(12, 'bills/index-bill-collection.php', 'Bill collection'),
(13, 'mytask/my-developer-task.php', 'My Developer Task'),
(14, 'task/developer-task-detail.php', ''),
(15, 'task/marketing-task-detail.php', ''),
(16, 'task/index-marketing.php', 'All Marketing Task'),
(17, 'All Developer Task', 'index-developer.php'),
(18, 'task/index-developer.php', 'All Developer Task'),
(19, 'employee/emp_detail.php', ''),
(20, 'mytask/my-created-task.php', 'My Created Task'),
(21, 'mytask/my-created-task-details.php', 'my-created-task-details'),
(22, 'mytask/edit_task.php', 'edit_task'),
(23, 'employee/myprofile.php', 'My Profile'),
(24, 'task/user-assigned-task-list.php', 'My Assigned Task List'),
(25, 'mytask/user-assigned-task-details.php', 'User Assigned Task Details');

-- --------------------------------------------------------

--
-- Table structure for table `page_roles`
--

CREATE TABLE `page_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pages_id_list` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `page_roles`
--

INSERT INTO `page_roles` (`id`, `user_id`, `pages_id_list`) VALUES
(1, 1, '1,2,4,4,5,6,7,8,9,10,11,12,14,15,17,18,19,20,21,23'),
(6, 7, '5,23'),
(7, 10, '5,23'),
(8, 11, '5,23'),
(9, 12, '5,23'),
(10, 13, '5,23'),
(11, 14, '5,23'),
(12, 15, '5,23'),
(13, 16, '5,23'),
(14, 17, '5,23'),
(15, 18, '5,23'),
(16, 22, '5,23'),
(17, 23, '5,23'),
(18, 24, '5,23'),
(19, 25, '5,23'),
(20, 26, '5,23'),
(21, 27, '5,23'),
(22, 28, '5,23'),
(23, 29, '5,23'),
(24, 30, '5,23'),
(25, 31, '5,23'),
(26, 32, '5,23'),
(27, 33, '5,23'),
(28, 34, '5,23'),
(29, 35, '5,23,18,1'),
(30, 36, '5,23'),
(31, 41, '5,23'),
(32, 42, '5,23'),
(33, 43, '5,23'),
(34, 47, '5,23'),
(35, 48, '5,23'),
(36, 49, '5,23,24');

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE `project_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_status`
--

INSERT INTO `project_status` (`id`, `status_name`) VALUES
(1, 'In Progress'),
(2, 'Completed'),
(3, 'Rejected'),
(4, 'Cancel'),
(5, 'Extension');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_role` int(100) NOT NULL,
  `department_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation_id` int(11) NOT NULL,
  `user_status` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `employee_id`, `password`, `employee_role`, `department_id`, `designation_id`, `user_status`, `created_at`) VALUES
(1, 'Siphar Ahmed', 'admin@gmail.com', 'emp01', '1bbd886460827015e5d605ed44252251', 1, '1,2', 1, 1, '2020-02-03 04:56:37'),
(7, 'Ariful Islam juwel', 'juwelariful1@gmail.com', 'emp_01', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 8, 1, '2020-02-09 08:38:22'),
(10, 'Mir Hasibur Rahman Ovi', 'ovixyan@gmail.com', 'emp_02', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '3', 9, 1, '2020-02-09 09:22:11'),
(11, 'Mahabub Alam', 'mahabub@gmail.com', 'emp_03', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '4', 10, 1, '2020-02-09 09:35:49'),
(12, 'Azharul Islam', 'azharulsojib@gmail.com', 'emp_04', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '5', 11, 1, '2020-02-09 09:53:28'),
(13, 'Md. Rabiul Hasan', 'rabiul.fci@gmail.com', 'emp_05', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 6, 1, '2020-02-09 10:03:32'),
(14, 'MD Eyakub Sorkar', 'eyakubsorkar@gmail.com', 'emp_06', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 6, 1, '2020-02-09 10:19:32'),
(15, 'Faqhrul Hasan', 'emon.bubt@gmail.com', 'emp_07', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '5', 12, 1, '2020-02-09 10:39:41'),
(16, 'Diganta Protic Biswas', 'digantaprotik@gmail.com', 'emp_08', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 6, 1, '2020-02-09 10:47:54'),
(17, 'Kamrun Nahar', 'evauiu@gmail.com', 'emp_09', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 13, 1, '2020-02-09 11:00:11'),
(18, 'Syed Maruful Haque', 'sagor202@gmail.com', 'emp_10', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '5', 12, 1, '2020-02-09 11:24:10'),
(22, 'Khalid Mostafa', 'khalidisamit@gmail.com', 'emp_11', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '5', 11, 1, '2020-02-09 11:50:26'),
(23, 'Nazrul Islam', 'nazrulcst@gmail.com', 'emp_12', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 6, 1, '2020-02-09 12:00:42'),
(24, 'Monirul Islam', 'monirjss@gmail.com', 'emp_13', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 1, 1, '2020-02-09 12:27:25'),
(25, 'Shaquib Tayeem Ahmed', 'shaqwork@outlook.com', 'emp_14', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 13, 1, '2020-02-09 12:36:43'),
(26, 'Khaled Mahmud Shopon', 'kmshopon@venturenxt.com', 'emp_15', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '5', 14, 1, '2020-02-09 12:57:05'),
(27, 'Tanveer Ahmed', 'asdasd@gg.om', 'emp_16', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 15, 1, '2020-02-09 13:13:57'),
(28, 'Sipar Ahmed', 'ahmed2sipar@gmail.com', 'emp_17', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '7', 16, 1, '2020-02-09 13:26:32'),
(29, 'Sakib Sharker', 'asd2323@g.com', 'emp_18', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 13, 1, '2020-02-09 13:32:30'),
(30, 'Ashiqur Rahman', 'landlbd@gmail.com', 'emp_19', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '7', 17, 1, '2020-02-10 04:23:20'),
(31, 'Md. Didarul alom', 'didarul0220@gmail.com', 'emp_20', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '3', 18, 1, '2020-02-10 04:36:02'),
(32, 'kazi Abdullah Al Mamun', 'mamun.fintech@gmail.com', 'emp_21', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '8', 19, 1, '2020-02-10 04:47:27'),
(33, 'Hasnain Rahman', 'hrahman.2k11@gmail.com', 'emp_22', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 20, 1, '2020-02-10 04:57:07'),
(34, 'Ferdous Bin Alim', 'ferdous@venturenxt.com', 'emp_23', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '2', 3, 1, '2020-02-10 05:06:51'),
(35, 'Md. Montasir Tasneem', 'nishad@venturenxt.com', 'emp_24', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '2', 1, 1, '2020-02-10 05:13:33'),
(36, 'Faisal Mahmud', 'faisalmahmud06@yahoo.com', 'emp_25', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 13, 1, '2020-02-10 05:20:47'),
(41, 'Emran Hossain Khokon', 'hvk@gmail.com', 'emp_26', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '4', 21, 1, '2020-02-10 06:00:45'),
(42, 'Arif Mahmud Riad', 'ony.cse@gmil.com', 'emp_27', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '3', 18, 1, '2020-02-10 06:13:25'),
(43, 'Md. Abdur Rob (Pappu)', 'pappurob@gmail.com', 'emp_28', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '9', 22, 1, '2020-02-10 06:23:15'),
(47, 'Anonno Ibne Razzak', 'anonnoraz@gmail.com', 'emp_29', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '6', 23, 1, '2020-02-10 07:13:27'),
(48, 'Md Imranur Rahman', 'imran@venturenxt.com', 'emp_30', '75bc7f11cb533e0c2a85bc5251b612ba', 2, '7', 24, 1, '2020-02-10 07:21:00'),
(49, 'Abdul halim hasan', 'halimkhanfeni7@gmail.com', 'emp_31', '75bc7f11cb533e0c2a85bc5251b612ba', 3, '2', 8, 1, '2020-02-10 07:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(33) NOT NULL,
  `role_name` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collect_bills`
--
ALTER TABLE `collect_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developer_tasks`
--
ALTER TABLE `developer_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_link` (`file_link`);

--
-- Indexes for table `page_roles`
--
ALTER TABLE `page_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collect_bills`
--
ALTER TABLE `collect_bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `developer_tasks`
--
ALTER TABLE `developer_tasks`
  MODIFY `id` int(23) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `page_roles`
--
ALTER TABLE `page_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
