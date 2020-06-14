CREATE TABLE University(
name varchar(20) PRIMARY KEY
);

CREATE TABLE Login (
username varchar(20),
password varchar(20), 
PRIMARY KEY(username)
);

CREATE TABLE Course (
	number varchar(20),
	department varchar(20),
name varchar(20),
PRIMARY KEY(number, department)
);

CREATE TABLE Faculty(
name varchar(20),
university_name varchar(20),
Application_Instructions varchar(20),
PRIMARY KEY (name, university_name),
FOREIGN KEY (university_name) REFERENCES University(name) 
ON DELETE CASCADE
ON UPDATE CASCADE	
);

CREATE TABLE Local_Address (
contact_info_address varchar(20),
postal_code varchar(20),
PRIMARY KEY (contact_info_address)
);

CREATE TABLE Contact_Info(
phone_number varchar(20),
address varchar(20),
email varchar(20),
PRIMARY KEY(email),
FOREIGN KEY (address) REFERENCES Local_Address (contact_info_address)
ON DELETE CASCADE

);

CREATE TABLE Recruiter(
id varchar(20),
name varchar(20),
university_name varchar(20),
contact_info_email varchar(20) UNIQUE,
login_username varchar(20) UNIQUE, 
PRIMARY KEY (id),
FOREIGN KEY (university_name) REFERENCES University(name)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (contact_info_email) REFERENCES Contact_Info(email) 
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (login_username) REFERENCES Login(username) 
ON DELETE CASCADE
ON UPDATE CASCADE	
);

CREATE TABLE Student(
id varchar(20), 
name varchar(20),
contact_info_email varchar(20) UNIQUE, 
login_username varchar(20) UNIQUE,
PRIMARY KEY(id), 
FOREIGN KEY (contact_info_email) REFERENCES Contact_Info(email) 
ON DELETE CASCADE,
 FOREIGN KEY(login_username) REFERENCES Login(username) 
ON DELETE CASCADE
);

CREATE TABLE Agency(
name varchar(20),
PRIMARY KEY(name));

CREATE TABLE HighSchoolStudent (
school varchar(20) NOT NULL,
student_id  varchar(20),
agency_name varchar(20),
FOREIGN KEY(student_id) REFERENCES Student(id) 
ON DELETE CASCADE,
FOREIGN KEY (agency_name) REFERENCES Agency(name)
ON DELETE SET NULL
);

CREATE TABLE TransferStudent (
student_id varchar(20),
university_name varchar(20), 
FOREIGN KEY(student_id) REFERENCES Student(id) 
ON DELETE CASCADE,
FOREIGN KEY(university_name) REFERENCES University(name) 
ON DELETE SET NULL
);

CREATE TABLE Taken (
mark varchar(20),
year varchar(20),
student_id varchar(20),
course_number varchar(20), 
course_department varchar(20),
PRIMARY KEY(student_id, course_number, course_department),
FOREIGN KEY(student_id) REFERENCES Student(id) 
ON DELETE CASCADE,
FOREIGN KEY(course_number, course_department) REFERENCES Course(number, department)
ON DELETE CASCADE
);

CREATE TABLE Application(
id varchar(20),
text varchar(20),
offer varchar(20),
accepted varchar(20),
university_name varchar(20),
faculty_name varchar(20),
student_id varchar(20),
PRIMARY KEY(id),
FOREIGN KEY(University_name) REFERENCES University(name) 
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(faculty_name, university_name) REFERENCES Faculty(name, university_name)
ON DELETE CASCADE
ON UPDATE CASCADE, 
FOREIGN KEY(student_id) REFERENCES Student(id) 
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE Send(
university_name varchar(20),
application_id varchar(20),
student_id varchar(20),
PRIMARY KEY(university_name, application_id, student_id),
FOREIGN KEY(university_name) REFERENCES University(name) 
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(student_id) REFERENCES Student(id) 
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(application_id) REFERENCES Application(id) 
ON DELETE CASCADE
);

CREATE TABLE Review(
	recruiter_id varchar(20),
	application_id varchar(20),
	PRIMARY KEY(recruiter_id, application_id),
	FOREIGN KEY (recruiter_id)  REFERENCES Recruiter(id),
	FOREIGN KEY (application_id)  REFERENCES Application(id)
);
