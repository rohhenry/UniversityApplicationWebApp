CREATE TABLE Student(
Id varchar(20), 
name varchar(20),
contact_info_email varchar(20) UNIQUE, 
PRIMARY KEY(id), 
FOREIGN KEY (contact_info_email) references Contact_Info ON DELETE SET NULL
)

 
CREATE TABLE HighSchoolStudent (
school varchar(20),
student_id  varchar(20),
FOREIGN KEY(student_id) references Student ON DELETE CASCADE
)

CREATE TABLE TransferStudent (
student_id varchar(20),
university_name varchar(20), 
FOREIGN KEY(student_id) references Student ON DELETE CASCADE,
FOREIGN KEY(university_name) references University ON DELETE SET NULL
)

CREATE TABLE Course (
name varchar(20),
PRIMARY KEY(name)
ON DELETE CASCADE
ON UPDATE CASCADE
)

CREATE TABLE Taken (
mark varchar(20),
year varchar(20),
student_id varchar(20),
course_name varchar(20),
Course_number varchar(20), 
PRIMARY KEY(student_id, course_name),
Foreign Key(student_id) references Student ON DELETE CASCADE,
Foreign Key(course_name) references Student ON DELETE CASCADE,
)



CREATE TABLE Faculty(
faculty_name varchar(20),
University_name varchar(20),
Application_Instructions varchar(20)
PRIMARY KEY (faculty_name, University_name)
FOREIGN KEY (University_name) REFERENCES University
	ON DELETE CASCADE
	ON UPDATE CASCADE
)

CREATE TABLE University(
university_name varchar(20) PRIMARY KEY
)



CREATE TABLE Recruiter(
id varchar(20),
name varchar(20),
university_name varchar(20),
contact_info_email varchar(20) UNIQUE,
PRIMARY KEY (id)
FOREIGN KEY (university_name) REFERENCE University
	ON DELETE CASCADE
	ON UPDATE CASCADE
FOREIGN KEY (contact_info_email) REFERENCES Contact_Info
	ON DELETE CASCADE
	ON UPDATE CASCADE
)


CREATE TABLE Contact_Info(
phone_number varchar(20),
address varchar(20),
email varchar(20),
PRIMARY KEY(Email)
)

CREATE TABLE Local_address (
address: varchar(20),
postal_code: varchar(20),
Primary Key: address
Foregin Key: (address) reference Contact_info
Candidate Key: address


CREATE TABLE Application(
application_id varchar(20)
text varchar(20),
offer varchar(20),
accepted varchar(20),
university_name varchar(20),
student_id varchar(20),
PRIMARY KEY(AID)
FOREIGN KEY(University_name) REFERENCE University
ON DELETE CASCADE
ON UPDATE CASCADE
FOREIGN KEY(student_id) REFERENCE Student
ON DELETE CASCADE
ON UPDATE CASCADE
)

CREATE TABLE Send(
University_name varchar(20)
Application_id varchar(20),
Stduent_id varchar(20),
PRIMARY KEY(university_name, application_id, student_id)
FOREIGN KEY(University_name) REFERENCE University
	ON DELETE CASCADE
ON UPDATE CASCADE
FOREIGN KEY(student_id) REFERENCE Student
ON DELETE CASCADE
ON UPDATE CASCADE
FOREIGN KEY(application_id) REFERENCE Application
ON DELETE CASCADE
ON UPDATE CASCADE 
)

CREATE TABLE Review(
	recruiter_id varchar(20),
	application_id varchar(20),
	Primary Key(recruiter_id, application_id),
	Foreign Key(recruiter_id) references Recruiter,
	Foreign Key(application_id) references Application
)

