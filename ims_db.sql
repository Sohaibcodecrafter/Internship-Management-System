-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 09:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `internship_id` int(11) NOT NULL,
  `applied_at` datetime DEFAULT current_timestamp(),
  `status` enum('pending','shortlisted','accepted','rejected') DEFAULT 'pending',
  `cover_note` text DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `student_id`, `internship_id`, `applied_at`, `status`, `cover_note`, `reviewed_at`) VALUES
(1, 1, 1, '2026-04-24 02:51:28', 'accepted', 'I am passionate about web development.', '2024-05-10 10:00:00'),
(2, 1, 3, '2026-04-24 02:51:28', 'accepted', 'ERP interests me greatly.', '2026-04-26 17:54:57'),
(3, 2, 1, '2026-04-24 02:51:28', 'shortlisted', 'I have Laravel experience.', '2024-05-11 11:00:00'),
(4, 2, 5, '2026-04-24 02:51:28', 'accepted', 'Cloud is my focus area.', '2026-04-29 19:10:01'),
(6, 4, 3, '2026-04-24 02:51:28', 'accepted', 'I want to learn ERP systems.', '2024-05-12 14:00:00'),
(7, 5, 5, '2026-04-24 02:51:28', 'accepted', 'I have AWS certification.', '2024-05-13 09:00:00'),
(8, 3, 5, '2026-04-24 02:51:28', 'pending', 'Interested in cloud infrastructure.', '2026-04-26 17:54:39'),
(9, 6, 5, '2026-04-26 21:43:49', 'pending', 'i want to apply in this specific internship aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2026-04-29 19:10:19'),
(10, 7, 6, '2026-04-27 00:14:51', 'pending', 'I am passionate about PHP backend development. I have built 3 Laravel projects during my CS degree at FAST-NUCES Karachi and have strong MySQL skills.', NULL),
(11, 7, 8, '2026-04-27 00:14:51', 'shortlisted', 'Digital marketing aligns with my business skills. I have managed the social media pages for my university tech society for two semesters.', NULL),
(12, 8, 7, '2026-04-27 00:14:51', 'shortlisted', 'As a React developer I have built 3 full-stack projects. I am proficient in modern JavaScript, TypeScript, and CSS-in-JS solutions.', NULL),
(13, 8, 12, '2026-04-27 00:14:51', 'accepted', 'Data science is my career goal. I have completed 2 Kaggle competitions in NLP and scored in the top 15% in both challenges.', NULL),
(14, 9, 6, '2026-04-27 00:14:51', 'rejected', 'I have strong MySQL and PHP skills developed through my final year project ??? a hospital management system built with pure PHP.', NULL),
(15, 10, 10, '2026-04-27 00:14:51', 'pending', 'Networking and IT support are my strengths. I hold a Cisco CCNA certification and have interned at a local ISP for 6 weeks.', NULL),
(16, 11, 11, '2026-04-27 00:14:51', 'shortlisted', 'Business analysis experience from my internship simulation course at IBA. I create data-driven requirement docs using Confluence.', NULL),
(17, 12, 14, '2026-04-27 00:14:51', 'pending', 'I have used Figma professionally in my engineering design projects and won a national UI design competition at GIKI.', NULL),
(18, 13, 12, '2026-04-27 00:14:51', 'pending', 'My data analysis project using Python and Pandas won first place in QAU science fair. I also know SQL and Tableau.', NULL),
(19, 14, 6, '2026-04-27 00:14:51', 'shortlisted', 'I built 2 published apps on Google Play Store using PHP backends. I am comfortable with RESTful APIs and database optimization.', NULL),
(20, 15, 13, '2026-04-27 00:14:51', 'accepted', 'ML research intern role perfectly fits my LUMS coursework in deep learning and reinforcement learning. Published 1 conference paper.', NULL),
(21, 16, 12, '2026-04-27 00:14:51', 'shortlisted', 'Power BI dashboards and SQL analysis are my core skills from my data science degree. I have analyzed 5 real-world datasets at ITU.', NULL),
(22, 6, 9, '2026-04-28 13:32:39', 'accepted', 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddxdxdx dxdxdx dxdxdxd dxdxdxdx dxdxdx dxdx', '2026-04-28 13:33:29'),
(23, 6, 16, '2026-04-29 19:07:25', 'rejected', 'i want to Build and maintain web applications using MERN stack; work on frontend UI, backend APIs, and database integration; basic debugging and testing required.', '2026-04-30 13:31:09'),
(24, 6, 14, '2026-04-30 12:21:23', 'pending', 'i want t o apply Design user interfaces and prototypes in Figma.Design user interfaces and prototypes in Figma.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `established_year` year(4) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `verification_requested` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `user_id`, `company_name`, `industry`, `city`, `contact_email`, `contact_phone`, `established_year`, `verified`, `verification_requested`) VALUES
(1, 7, 'TechCorp PK', 'Software Development', 'Lahore', 'hr@techcorppk.com', '04299887766', '2010', 1, 0),
(2, 8, 'NetSol Technologies', 'ERP Solutions', 'Lahore', 'careers@netsol.com', '04288776655', '1995', 1, 0),
(3, 9, 'Systems Ltd', 'IT Consulting', 'Islamabad', 'jobs@systems.com', '05199887766', '2005', 1, 0),
(4, 21, 'TechVentures PK', 'Software Development', 'Karachi', 'hr@techventures.pk', '02199001122', '2012', 1, 0),
(5, 22, 'NexaDigital', 'Digital Marketing', 'Lahore', 'jobs@nexadigital.pk', '04299003344', '2016', 1, 0),
(6, 23, 'SoftBridge', 'IT Consulting', 'Islamabad', 'careers@softbridge.pk', '05199005566', '2008', 1, 0),
(7, 24, 'DataMinds', 'Data Science', 'Karachi', 'intern@dataminds.pk', '02199007788', '2019', 1, 0),
(8, 25, 'PixelForge', 'UI/UX Design', 'Lahore', 'hr@pixelforge.pk', '04299009900', '2020', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `dept_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`, `dept_code`) VALUES
(1, 'Computer Science', 'CS'),
(2, 'Software Engineering', 'SE'),
(3, 'Information Technology', 'IT'),
(4, 'Electrical Engineering', 'EE'),
(5, 'Business Administration', 'BA');

-- --------------------------------------------------------

--
-- Table structure for table `internships`
--

CREATE TABLE `internships` (
  `internship_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `domain` varchar(100) NOT NULL,
  `stipend` decimal(10,2) DEFAULT 0.00,
  `duration_months` int(11) NOT NULL CHECK (`duration_months` > 0),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `slots` int(11) DEFAULT 1,
  `status` enum('open','closed','completed') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internships`
--

INSERT INTO `internships` (`internship_id`, `company_id`, `supervisor_id`, `title`, `description`, `domain`, `stipend`, `duration_months`, `start_date`, `end_date`, `slots`, `status`) VALUES
(1, 1, 1, 'Web Development Intern', 'Build and maintain web apps using Laravel.', 'Web Development', 25000.00, 3, '2024-06-01', '2024-08-31', 3, 'open'),
(2, 1, 2, 'Mobile App Intern', 'Develop cross-platform mobile apps.', 'Mobile Dev', 20000.00, 2, '2024-07-01', '2024-08-31', 2, 'closed'),
(3, 2, 3, 'ERP Module Intern', 'Work on NetSol ERP customizations.', 'ERP', 30000.00, 6, '2024-05-01', '2024-10-31', 4, 'open'),
(4, 2, 4, 'Business Analysis Intern', 'Gather requirements and create docs.', 'Business', 15000.00, 3, '2024-06-01', '2024-08-31', 2, 'closed'),
(5, 3, 5, 'Cloud Infrastructure Intern', 'Manage AWS/Azure cloud setups.', 'Cloud Computing', 35000.00, 4, '2024-07-01', '2024-10-31', 2, 'open'),
(6, 4, NULL, 'PHP Backend Intern', 'Build REST APIs using PHP and Laravel.', 'Web Development', 25000.00, 3, '2026-06-01', '2026-08-31', 3, 'open'),
(7, 4, NULL, 'React Frontend Intern', 'Build responsive UI components in React.', 'Frontend', 20000.00, 3, '2026-06-15', '2026-09-15', 2, 'open'),
(8, 5, NULL, 'Digital Marketing Intern', 'SEO optimization and social media campaign management.', 'Digital Marketing', 15000.00, 2, '2026-06-01', '2026-07-31', 3, 'open'),
(9, 5, NULL, 'Content Writing Intern', 'Write engaging blogs and web copy.', 'Content', 10000.00, 2, '2026-07-01', '2026-08-31', 2, 'open'),
(10, 6, NULL, 'IT Support Intern', 'Helpdesk tickets and network troubleshooting.', 'IT Support', 18000.00, 3, '2026-06-01', '2026-08-31', 2, 'open'),
(11, 6, NULL, 'Business Analyst Intern', 'Gather requirements and document solutions.', 'Business Analysis', 12000.00, 2, '2026-07-01', '2026-08-31', 2, 'open'),
(12, 7, NULL, 'Data Science Intern', 'Clean datasets and build analytics dashboards.', 'Data Science', 30000.00, 4, '2026-06-01', '2026-09-30', 3, 'open'),
(13, 7, NULL, 'ML Research Intern', 'Implement ML models for production use.', 'Machine Learning', 35000.00, 4, '2026-07-01', '2026-10-31', 2, 'open'),
(14, 8, NULL, 'UI/UX Design Intern', 'Design user interfaces and prototypes in Figma.', 'UI/UX Design', 15000.00, 2, '2026-06-15', '2026-08-15', 2, 'open'),
(15, 8, NULL, 'Graphic Design Intern', 'Create brand identity and marketing assets.', 'Graphic Design', 12000.00, 2, '2026-07-01', '2026-08-31', 2, 'open'),
(16, 3, NULL, 'Full Stack Developer Intern', 'Build and maintain web applications using MERN stack; work on frontend UI, backend APIs, and database integration; basic debugging and testing required.', 'Web Dev, JavaScript, Node.js, React, MongoDB', 30000.00, 3, '2026-06-15', '2026-09-15', 5, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 9, 'New application received for \"Cloud Infrastructure Intern\" from sohaib kamran', 1, '2026-04-26 16:43:49'),
(2, 10, 'Your application for \"Cloud Infrastructure Intern\" has been accepted.', 1, '2026-04-26 16:48:22'),
(3, 10, 'Your application for \"Cloud Infrastructure Intern\" has been pending.', 1, '2026-04-26 16:49:10'),
(4, 10, 'Your application for \"Cloud Infrastructure Intern\" has been accepted.', 1, '2026-04-26 16:49:26'),
(5, 10, 'Your application for \"Cloud Infrastructure Intern\" has been accepted.', 1, '2026-04-26 18:24:04'),
(6, 11, 'Your application for \"PHP Backend Intern\" is under review.', 0, '2026-04-26 19:14:51'),
(7, 12, 'Your application for \"Data Science Intern\" has been accepted! ????', 0, '2026-04-26 19:14:51'),
(8, 13, 'Your application for \"PHP Backend Intern\" was not selected.', 1, '2026-04-26 19:14:51'),
(9, 19, 'Your application for \"ML Research Intern\" has been accepted! ????', 0, '2026-04-26 19:14:51'),
(10, 21, 'New application received for \"PHP Backend Intern\" from Ahmed Ali.', 0, '2026-04-26 19:14:51'),
(11, 21, 'New application received for \"PHP Backend Intern\" from Bilal Hassan.', 1, '2026-04-26 19:14:51'),
(12, 24, 'New application received for \"Data Science Intern\" from Sara Khan.', 0, '2026-04-26 19:14:51'),
(13, 25, 'New application received for \"UI/UX Design Intern\" from Hina Noor.', 0, '2026-04-26 19:14:51'),
(14, 22, 'New application received for \"Content Writing Intern\" from sohaib kamran', 1, '2026-04-28 08:32:39'),
(15, 10, 'Your application for \"Content Writing Intern\" has been pending.', 1, '2026-04-28 08:33:24'),
(16, 10, 'Your application for \"Content Writing Intern\" has been accepted.', 1, '2026-04-28 08:33:29'),
(17, 9, 'New application received for \"Full Stack Developer Intern\" from sohaib kamran', 1, '2026-04-29 14:07:25'),
(18, 10, 'Your application for \"Full Stack Developer Intern\" has been pending.', 1, '2026-04-29 14:09:49'),
(19, 10, 'Your application for \"Full Stack Developer Intern\" has been accepted.', 1, '2026-04-29 14:09:54'),
(20, 3, 'Your application for \"Cloud Infrastructure Intern\" has been accepted.', 0, '2026-04-29 14:10:02'),
(21, 10, 'Your application for \"Cloud Infrastructure Intern\" has been pending.', 1, '2026-04-29 14:10:19'),
(22, 10, 'Your application for \"Full Stack Developer Intern\" has been rejected.', 1, '2026-04-29 14:10:33'),
(23, 10, 'Your application for \"Full Stack Developer Intern\" has been accepted.', 1, '2026-04-29 14:22:09'),
(24, 10, 'Your application for \"Full Stack Developer Intern\" has been rejected.', 1, '2026-04-29 19:07:44'),
(25, 25, 'New application received for \"UI/UX Design Intern\" from sohaib kamran', 0, '2026-04-30 07:21:23'),
(26, 10, 'Your application for \"Full Stack Developer Intern\" has been accepted.', 1, '2026-04-30 07:23:20'),
(27, 10, 'Your application for \"Full Stack Developer Intern\" has been rejected.', 1, '2026-04-30 08:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE `placements` (
  `placement_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `actual_stipend` decimal(10,2) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `placements`
--

INSERT INTO `placements` (`placement_id`, `application_id`, `start_date`, `end_date`, `actual_stipend`, `grade`, `feedback`, `completed`) VALUES
(1, 1, '2024-06-01', '2024-08-31', 25000.00, 'A', 'Excellent performance, highly recommended.', 0),
(2, 6, '2024-05-01', '2024-10-31', 30000.00, 'B+', 'Good contribution to the ERP module.', 0),
(3, 7, '2024-07-01', '2024-10-31', 35000.00, NULL, NULL, 0),
(4, 2, '2024-05-01', '2024-10-31', 30000.00, NULL, NULL, 0),
(5, 9, '2024-07-01', '2024-10-31', 35000.00, NULL, NULL, 0),
(6, 13, '2026-06-01', '2026-09-30', 30000.00, NULL, NULL, 0),
(7, 20, '2026-07-01', '2026-10-31', 35000.00, NULL, NULL, 0),
(8, 22, '2026-07-01', '2026-08-31', 10000.00, NULL, NULL, 0),
(9, 23, '2026-06-15', '2026-09-15', 30000.00, NULL, NULL, 0),
(10, 4, '2024-07-01', '2024-10-31', 35000.00, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `student_id`, `company_id`, `rating`, `comment`, `created_at`) VALUES
(1, 6, 5, 4, 'i have the best experience as i am able to work with real world problems', '2026-04-29 14:08:08'),
(2, 6, 3, 4, NULL, '2026-04-30 07:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL CHECK (`gpa` >= 0.00 and `gpa` <= 4.00),
  `enrollment_year` year(4) NOT NULL,
  `status` enum('active','graduated','dropped') DEFAULT 'active',
  `cv_file` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `dept_id`, `full_name`, `email`, `phone`, `gpa`, `enrollment_year`, `status`, `cv_file`, `profile_pic`) VALUES
(1, 2, 1, 'Ali Hassan', 'ali.hassan@student.edu', '03001234567', 3.75, '2021', 'active', NULL, NULL),
(2, 3, 1, 'Sara Iqbal', 'sara.iqbal@student.edu', '03009876543', 3.50, '2021', 'active', NULL, NULL),
(3, 4, 2, 'Bilal Khan', 'bilal.khan@student.edu', '03331234567', 3.20, '2022', 'active', NULL, NULL),
(4, 5, 3, 'Zara Malik', 'zara.malik@student.edu', '03451234567', 3.80, '2022', 'active', NULL, NULL),
(5, 6, 4, 'Usman Ch', 'usman.ch@student.edu', '03111234567', 2.90, '2020', 'graduated', NULL, NULL),
(6, 10, 1, 'sohaib kamran', 'sohaibkamran.1122@gmail.com', '03336486080', 3.02, '2023', 'active', '6_1777221726.pdf', '6_photo_1777221726.png'),
(7, 11, 1, 'Ahmed Ali', 'ahmed.ali@fast.edu.pk', '03001234501', 3.75, '2022', 'active', NULL, NULL),
(8, 12, 1, 'Sara Khan', 'sara.khan@nust.edu.pk', '03001234502', 3.50, '2021', 'active', NULL, NULL),
(9, 13, 2, 'Bilal Hassan', 'bilal.h@uet.edu.pk', '03001234503', 3.20, '2022', 'active', NULL, NULL),
(10, 14, 3, 'Zainab Malik', 'zainab.m@comsats.edu.pk', '03001234504', 3.80, '2023', 'active', NULL, NULL),
(11, 15, 5, 'Usman Tariq', 'usman.t@iba.edu.pk', '03001234505', 3.60, '2021', 'active', NULL, NULL),
(12, 16, 4, 'Hina Noor', 'hina.n@giki.edu.pk', '03001234506', 3.45, '2022', 'active', NULL, NULL),
(13, 17, 1, 'Faisal Iqbal', 'faisal.i@qau.edu.pk', '03001234507', 3.10, '2023', 'active', NULL, NULL),
(14, 18, 2, 'Ayesha Raza', 'ayesha.r@uop.edu.pk', '03001234508', 3.55, '2022', 'active', NULL, NULL),
(15, 19, 1, 'Omar Sheikh', 'omar.s@lums.edu.pk', '03001234509', 3.90, '2021', 'active', NULL, NULL),
(16, 20, 3, 'Maryam Baig', 'maryam.b@itu.edu.pk', '03001234510', 3.70, '2023', 'active', NULL, NULL),
(17, 27, 1, 'hammad ali shah', 'hammad@nu.edu.pk', '03021234567', 3.50, '2021', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `supervisor_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`supervisor_id`, `company_id`, `full_name`, `email`, `designation`, `salary`) VALUES
(1, 1, 'Kamran Arif', 'kamran@techcorppk.com', 'Senior Developer', 180000.00),
(2, 1, 'Nadia Saeed', 'nadia@techcorppk.com', 'Project Manager', 220000.00),
(3, 2, 'Hassan Raza', 'hassan@netsol.com', 'Technical Lead', 250000.00),
(4, 2, 'Ayesha Tariq', 'ayesha@netsol.com', 'HR Manager', 195000.00),
(5, 3, 'Omar Farooq', 'omar@systems.com', 'Solutions Architect', 270000.00),
(6, 4, 'Tariq Mehmood', 'tariq@techventures.pk', 'CTO', 350000.00),
(7, 5, 'Sana Ahmed', 'sana@nexadigital.pk', 'Director Marketing', 280000.00),
(8, 6, 'Imran Qureshi', 'imran@softbridge.pk', 'Senior Architect', 320000.00),
(9, 7, 'Fatima Zahra', 'fatima@dataminds.pk', 'Lead Data Scientist', 300000.00),
(10, 8, 'Hamza Ali', 'hamza@pixelforge.pk', 'Creative Director', 290000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','student','company') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `is_active`, `created_at`) VALUES
(1, 'admin', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'admin', 1, '2026-04-24 02:51:28'),
(2, 'ali_hassan', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'student', 1, '2026-04-24 02:51:28'),
(3, 'sara_iqbal', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'student', 1, '2026-04-24 02:51:28'),
(4, 'bilal_khan', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'student', 1, '2026-04-24 02:51:28'),
(5, 'zara_malik', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'student', 1, '2026-04-24 02:51:28'),
(6, 'usman_ch', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'student', 1, '2026-04-24 02:51:28'),
(7, 'techcorp_pk', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'company', 1, '2026-04-24 02:51:28'),
(8, 'netsol_tech', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'company', 1, '2026-04-24 02:51:28'),
(9, 'systems_ltd', '$2y$10$UDEzqDRsngtT4cu2twyWY.hE.sL0hkksSlIE1fEi6m98c7jR9deUm', 'company', 1, '2026-04-24 02:51:28'),
(10, 'sohaib', '$2y$10$OiM3aH4cTzCqqmQ/6Xp1r.KRU4n7R4msecJxIn1Ty2qtnD/iX8OWq', 'student', 1, '2026-04-26 13:28:32'),
(11, 'ahmed_ali', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(12, 'sara_khan', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(13, 'bilal_hassan2', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(14, 'zainab_malik', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(15, 'usman_tariq', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(16, 'hina_noor', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(17, 'faisal_iqbal', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(18, 'ayesha_raza', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(19, 'omar_sheikh', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(20, 'maryam_baig', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1, '2026-04-27 00:14:51'),
(21, 'techventures', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1, '2026-04-27 00:14:51'),
(22, 'nexadigital', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1, '2026-04-27 00:14:51'),
(23, 'softbridge', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1, '2026-04-27 00:14:51'),
(24, 'dataminds', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1, '2026-04-27 00:14:51'),
(25, 'pixelforge', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1, '2026-04-27 00:14:51'),
(26, 'admin2', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'admin', 1, '2026-04-27 00:14:51'),
(27, 'hammad', '$2y$10$1/2aFnH5h2SggNZMuhC8IuEh.MxodlhW.SkCkMJDkV5obYmKNidnG', 'student', 1, '2026-04-29 19:48:48');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_company_summary`
-- (See below for the actual view)
--
CREATE TABLE `vw_company_summary` (
`company_name` varchar(150)
,`industry` varchar(100)
,`city` varchar(100)
,`total_internships` bigint(21)
,`total_applications` bigint(21)
,`accepted_count` bigint(21)
,`avg_stipend` decimal(14,6)
,`max_stipend` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_placement_report`
-- (See below for the actual view)
--
CREATE TABLE `vw_placement_report` (
`placement_id` int(11)
,`student_name` varchar(100)
,`company_name` varchar(150)
,`internship_title` varchar(150)
,`supervisor_name` varchar(100)
,`start_date` date
,`end_date` date
,`duration_months` bigint(21)
,`actual_stipend` decimal(10,2)
,`grade` varchar(5)
,`completed` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_student_applications`
-- (See below for the actual view)
--
CREATE TABLE `vw_student_applications` (
`student_id` int(11)
,`student_name` varchar(100)
,`dept_name` varchar(100)
,`internship_title` varchar(150)
,`company_name` varchar(150)
,`application_status` enum('pending','shortlisted','accepted','rejected')
,`applied_at` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `vw_company_summary`
--
DROP TABLE IF EXISTS `vw_company_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_company_summary`  AS SELECT `c`.`company_name` AS `company_name`, `c`.`industry` AS `industry`, `c`.`city` AS `city`, count(distinct `i`.`internship_id`) AS `total_internships`, count(distinct `a`.`application_id`) AS `total_applications`, count(distinct case when `a`.`status` = 'accepted' then `a`.`application_id` end) AS `accepted_count`, avg(`i`.`stipend`) AS `avg_stipend`, max(`i`.`stipend`) AS `max_stipend` FROM ((`companies` `c` left join `internships` `i` on(`c`.`company_id` = `i`.`company_id`)) left join `applications` `a` on(`i`.`internship_id` = `a`.`internship_id`)) GROUP BY `c`.`company_id`, `c`.`company_name`, `c`.`industry`, `c`.`city` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_placement_report`
--
DROP TABLE IF EXISTS `vw_placement_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_placement_report`  AS SELECT `p`.`placement_id` AS `placement_id`, `s`.`full_name` AS `student_name`, `c`.`company_name` AS `company_name`, `i`.`title` AS `internship_title`, `sup`.`full_name` AS `supervisor_name`, `p`.`start_date` AS `start_date`, `p`.`end_date` AS `end_date`, timestampdiff(MONTH,`p`.`start_date`,`p`.`end_date`) AS `duration_months`, `p`.`actual_stipend` AS `actual_stipend`, `p`.`grade` AS `grade`, `p`.`completed` AS `completed` FROM (((((`placements` `p` join `applications` `a` on(`p`.`application_id` = `a`.`application_id`)) join `students` `s` on(`a`.`student_id` = `s`.`student_id`)) join `internships` `i` on(`a`.`internship_id` = `i`.`internship_id`)) join `companies` `c` on(`i`.`company_id` = `c`.`company_id`)) left join `supervisors` `sup` on(`i`.`supervisor_id` = `sup`.`supervisor_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_student_applications`
--
DROP TABLE IF EXISTS `vw_student_applications`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_student_applications`  AS SELECT `s`.`student_id` AS `student_id`, `s`.`full_name` AS `student_name`, `d`.`dept_name` AS `dept_name`, `i`.`title` AS `internship_title`, `c`.`company_name` AS `company_name`, `a`.`status` AS `application_status`, `a`.`applied_at` AS `applied_at` FROM ((((`applications` `a` join `students` `s` on(`a`.`student_id` = `s`.`student_id`)) join `internships` `i` on(`a`.`internship_id` = `i`.`internship_id`)) join `companies` `c` on(`i`.`company_id` = `c`.`company_id`)) join `departments` `d` on(`s`.`dept_id` = `d`.`dept_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD UNIQUE KEY `uq_student_internship` (`student_id`,`internship_id`),
  ADD KEY `idx_applications_student` (`student_id`),
  ADD KEY `idx_applications_internship` (`internship_id`),
  ADD KEY `idx_applications_status` (`status`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `contact_email` (`contact_email`),
  ADD KEY `idx_companies_city` (`city`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`),
  ADD UNIQUE KEY `dept_name` (`dept_name`),
  ADD UNIQUE KEY `dept_code` (`dept_code`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`internship_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `idx_internships_domain` (`domain`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`placement_id`),
  ADD UNIQUE KEY `application_id` (`application_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `uq_student_company` (`student_id`,`company_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_students_dept` (`dept_id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`supervisor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `internship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `placements`
--
ALTER TABLE `placements`
  MODIFY `placement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `supervisor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`internship_id`) REFERENCES `internships` (`internship_id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`supervisor_id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `placements`
--
ALTER TABLE `placements`
  ADD CONSTRAINT `placements_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD CONSTRAINT `supervisors_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
