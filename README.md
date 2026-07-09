<div align="center">
  <img src="https://img.icons8.com/color/96/000000/graduation-cap.png" alt="Logo" width="80"/>

  # InternBridge PK 🌉
  **Internship Management System (IMS)**

  *Connecting Pakistani talent with opportunity. A centralized platform bridging the gap between education and industry.*

  [![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](#)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](#)
  [![Vanilla JS](https://img.shields.io/badge/Vanilla_JS-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](#)
  [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](#)
</div>

---

## 📖 Overview

**InternBridge PK** is a comprehensive, production-ready Internship Management System (IMS) designed to streamline the internship placement process. Built to solve the manual tracking challenges faced by universities and companies, this platform centralizes student applications, company listings, and internship tracking into one seamless ecosystem.

With a **role-based architecture (Admin, Student, Company)** and a completely custom **Minimal Formal Neumorphism** design system, the application delivers a premium, institutional-grade user experience.

---

## ✨ Key Features & Functions

### 🎓 For Students
- **Profile Building:** Create a comprehensive profile featuring education, skills, and CV uploads.
- **Advanced Filtering:** Browse internships dynamically by city, field, domain, and stipend.
- **Application Tracking:** Apply with personalized cover letters and track status updates (Pending, Shortlisted, Accepted, Rejected) in real-time.
- **Company Ratings:** Provide feedback and rate companies post-internship.

### 🏢 For Companies
- **Listing Management:** Post and manage internship opportunities effortlessly.
- **Applicant Tracking System (ATS):** Review, shortlist, and accept applicants from a centralized dashboard.
- **Trust & Verification:** Gain a "Verified" badge after admin approval, building trust with potential applicants.
- **Placement Insights:** Track open positions, applications received, and successful placements.

### 🛡️ For Administrators
- **Platform Analytics:** View comprehensive reports including Application Trends, Placements by Department, and GPA statistics.
- **User Management:** Oversee all platform activities, verify company accounts, and moderate student profiles.
- **Action Oversight:** Full authority to intervene, verify, or close listings globally.

---

## 🏗️ Architecture & Technology Stack

The project is built on a robust, dependency-free LAMP/WAMP stack, prioritizing fundamental web technologies for maximum performance and educational clarity.

- **Backend:** Raw PHP 8+ using PDO (PHP Data Objects) for secure, prepared SQL statements.
- **Database:** MySQL relational database in 3NF (Third Normal Form) featuring 8 highly optimized tables (Users, Students, Companies, Internships, Applications, Placements, Departments, Supervisors).
- **Frontend Logic:** Vanilla JavaScript (ES6+) for DOM manipulation, live search debouncing, and Three.js for interactive landing page hero graphics.
- **Styling:** Custom CSS3 leveraging a robust **Bento Box Grid** layout and a meticulously crafted **Neumorphic Design System**. *Zero CSS frameworks were used.*

### Database Design Highlight
The database is strictly normalized and incorporates advanced SQL features:
- Complete constraints (Foreign Keys, `CHECK`, `UNIQUE`, `NOT NULL`).
- Complex indexing for performance (`CREATE INDEX` on search fields).
- Dedicated Views (`CREATE VIEW`) for simplified backend reporting.

---

## 🎨 UI/UX Design System

The platform's aesthetic is governed by a strict **Minimal Formal Neumorphism** theme. 
- **Palette:** Institutional shades of Electric Blue (`#3D5AFE`), Teal-Green (`#00C896`), and clean slate grays.
- **Typography:** Premium pairings of *DM Serif Display* (Headings), *Outfit* (Body), and *JetBrains Mono* (Data/Code).
- **Responsiveness:** Fluid scaling using `clamp()` functions, transitioning seamlessly from a desktop bento grid to stacked mobile cards without a single horizontal scrollbar.

---

## 🚀 Getting Started (Local Setup)

1. **Install XAMPP** (or any AMP stack).
2. Clone or copy the `ims` folder into your `htdocs` directory.
3. Open `http://localhost/phpmyadmin` and create a database named: `ims_db`.
4. Import the SQL files located in `/sql/` **in order**:
   - `01_schema.sql`
   - `02_sample_data.sql`
   - `03_views_indexes.sql`
   - *Any subsequent migration or extra data files.*
5. Open `includes/db.php` and configure your credentials:
   ```php
   $host = 'localhost';
   $db   = 'ims_db';
   $user = 'root';
   $pass = ''; // Leave blank for default XAMPP
   ```
6. Visit `http://localhost/ims/` in your browser.

### 🔑 Demo Credentials
- **Admin:** `admin` / `password123`
- **Student:** `ali_hassan` / `password123`
- **Company:** `techcorp_pk` / `password123`

---

## 🎯 Use Case

InternBridge PK was conceived as a scalable solution for local universities in Pakistan (e.g., FAST-NUCES, NUST, LUMS) to bridge the digital gap between their students and the booming tech industry in cities like Karachi, Lahore, and Islamabad. It serves as an out-of-the-box institutional portal that replaces messy spreadsheets and disjointed email threads with a clean, unified dashboard.

---
<div align="center">
  <i>Designed and Built for the Future of Pakistani Tech Talent.</i>
</div>
