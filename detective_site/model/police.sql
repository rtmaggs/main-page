CREATE TABLE IF NOT EXISTS suspects (
	suspect_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        firstname VARCHAR(20) DEFAULT NULL,
        lastname VARCHAR(20) DEFAULT NULL,
        address VARCHAR(150) DEFAULT NULL,
        dob VARCHAR(10) DEFAULT NULL,
        eye_color VARCHAR(15) DEFAULT NULL,
        height VARCHAR(10) DEFAULT NULL,
        weight VARCHAR(10) DEFAULT NULL, 
        wanted_level int DEFAULT NULL, 
        arrest_time VARCHAR(20) DEFAULT NULL,
        photo VARCHAR(200) DEFAULT NULL,
        case_id INT(7) NOT NULL
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS employees (
	employee_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        firstname VARCHAR(20) DEFAULT NULL,
        lastname VARCHAR(20) DEFAULT NULL,
        job_title VARCHAR(20) DEFAULT NULL,
        email VARCHAR(50) DEFAULT NULL,
        pwd VARCHAR(300) DEFAULT NULL, 
        phone VARCHAR(15) DEFAULT NULL,
        photo VARCHAR(200) DEFAULT NULL,
        case_id INT(7) NOT NULL

        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS cases (
        case_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        case_title VARCHAR(100) DEFAULT NULL, 
        case_description VARCHAR(2000) DEFAULT NULL,
        is_active VARCHAR(20) DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS witnesses (
	witness_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        firstname VARCHAR(20) DEFAULT NULL,
        lastname VARCHAR(20) DEFAULT NULL,
        phone VARCHAR(12) DEFAULT NULL,
        witness_statement VARCHAR(2000) DEFAULT NULL, 
        photo VARCHAR(200) DEFAULT NULL,
        case_id INT(7) NOT NULL

        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS announcements (
        announcement_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        announcement_title VARCHAR(100) DEFAULT NULL,
        announcement VARCHAR(2000) DEFAULT NULL,
        post_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS evidence (
        evidence_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        evidence_title VARCHAR(100) DEFAULT NULL,
        evidence VARCHAR(2000) DEFAULT NULL,
        case_id int(10) NOT NULL

        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;