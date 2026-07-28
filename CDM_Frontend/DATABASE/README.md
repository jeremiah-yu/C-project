# CDM Portal Database

## Overview

This folder contains the official database files for the CDM Portal project.

The database is centralized, meaning all modules share the same database instead of creating separate databases.

Modules:

* Admission
* Enrollment
* Grading
* Academic Monitoring
* Document Request / Appointment
* Student Management
* Event Management with QR Attendance

---

# Folder Structure

```
database/
│
├── schema.sql          # Database structure
├── seed.sql            # Sample data
├── README.md           # Documentation
└── docs/
    ├── ERD.png
    ├── ERD.drawio
    └── DatabaseDesign.md
```

---

# Database Name

```
cdm_portal
```

---

# Requirements

* XAMPP
* MySQL 8+
* phpMyAdmin

---

# Setup

1. Start Apache and MySQL using XAMPP.
2. Open phpMyAdmin.
3. Create a database named:

```
cdm_portal
```

4. Import:

```
schema.sql
```

5. Import:

```
seed.sql
```

---

# Official Database Owner

The database schema is maintained by the Database Team.

Do not modify the database structure without approval.

If your module requires:

* a new table
* a new column
* a new relationship

please create an issue or discuss it with the Database Team first.

---

# Modules

| Module              | Main Tables                                           |
| ------------------- | ----------------------------------------------------- |
| Admission           | applicants, admission_documents                       |
| Student Management  | students, professors, departments, courses, sections  |
| Enrollment          | enrollments, enrollment_subjects, subjects, schedules |
| Grading             | grades, grade_details, grade_components               |
| Academic Monitoring | risk_assessments, consultations, study_plans          |
| Document Request    | document_requests, document_types                     |
| Event Management    | events, event_attendance                              |

---

# Naming Convention

Tables:

* plural
* lowercase
* snake_case

Examples:

```
students
course_subjects
document_requests
```

Columns:

```
student_number
course_id
created_at
updated_at
```

Primary Key:

```
id
```

Foreign Key:

```
student_id
course_id
subject_id
```

---

# Database Rules

* One centralized database only.
* No duplicate tables.
* Every table has a primary key.
* Foreign keys must be enforced.
* Do not delete shared tables.
* Keep the schema normalized.

---

# Version History

| Version | Description             |
| ------- | ----------------------- |
| v1.0    | Initial database design |
| v1.1    | Added Enrollment module |
| v1.2    | Added Grading module    |
| v1.3    | Added Monitoring module |

---

# Last Updated

Database Version: **1.0**

Maintained by: **Database Team**
