# Internship Management System (IMS)

A full-stack Internship Management System built with **PHP 8**, **MySQL (PDO)**, and a custom **neumorphic design system** using vanilla HTML, CSS, and JavaScript.

## Features
- Role-based authentication (Admin, Student, Company)
- CRUD operations for Students, Companies, Internships, Applications
- Aggregate reports with GROUP BY, HAVING, subqueries
- Search & filter on all list pages
- Three.js cybernetic grid shader landing page
- Glassmorphism UI with responsive bento grid layout

## Tech Stack
- **Backend:** PHP 8, MySQL, PDO prepared statements
- **Frontend:** Vanilla JS, CSS3 (Neumorphic design system), Three.js
- **Server:** XAMPP (Apache + MySQL)

## Setup
1. Start XAMPP (Apache + MySQL)
2. Import SQL files in order:
   - `sql/01_schema.sql`
   - `sql/02_sample_data.sql`
   - `sql/03_views_indexes.sql`
3. Create a junction/symlink: `mklink /J C:\xampp\htdocs\ims <project-path>`
4. Visit `http://localhost/ims/`

## Login Credentials
| Username | Password | Role |
|----------|----------|------|
| admin | password123 | Admin |
| ali_hassan | password123 | Student |
| techcorp_pk | password123 | Company |

## Project Structure
```
ims/
├── assets/css/          # Design system, components, layout, landing
├── assets/js/           # Client-side validation & interactions
├── auth/                # Login/logout handlers
├── includes/            # DB connection, auth helpers, layout partials
├── pages/               # Controllers + views for all modules
├── sql/                 # Schema, sample data, views & indexes
└── index.php            # Landing page with Three.js shader
```
