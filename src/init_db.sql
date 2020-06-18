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
id int NOT NULL AUTO_INCREMENT,
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

ALTER TABLE Application AUTO_INCREMENT = 1000;

CREATE TABLE Send(
university_name varchar(20),
application_id int,
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
	application_id int(20),
	PRIMARY KEY(recruiter_id, application_id),
	FOREIGN KEY (recruiter_id)  REFERENCES Recruiter(id),
	FOREIGN KEY (application_id)  REFERENCES Application(id)
);

INSERT INTO 
University(name)
VALUES
('UBC'),
('SFU'),
('UOT'),
('MIT'),
('UOW');

INSERT INTO 
Login (username, password) 
VALUES 
('A', 'a'),
('B', 'b'),
('C','c'),
('D', 'd'),
('E','e'),
('F', 'f'),
('G', 'g'),
('H', 'h'),
('I', 'i'),
('K', 'j'),
('J', 'k'),
('L', 'l'),
('M', 'm'),
('N', 'n'),
('O', 'o');




INSERT INTO
 Course (number ,department ,name)
 VALUES
('001','MATH','CALCULUS 1'),
('002','ENGL', 'Kafka Analysis'),
('003','MUSC','Advanced Scales'),
('004','PHYS','Quantum Mechanics'),
('005','CHEM','Orbitals');


INSERT INTO 
Faculty (name, university_name, application_Instructions)
VALUES
('Faculty of Education', 'UBC', 'none'),
('Faculty of Science', 'UBC', 'CH12, PHYS12, MATH12'),
('Faculty of Art','UBC','none'),
('Faculty of Medicine','UBC','please contact direct to us'),
('Department of Dentistry','UBC','please contact direct to us'),
('Faculty of Education', 'SFU', 'none'),
('Faculty of Science', 'SFU', 'CH12, PHYS12, MATH12'),
('Faculty of Art','SFU','none'),
('Faculty of Medicine','SFU','please contact direct to us'),
('Department of Dentistry','SFU','please contact direct to us'),
('Faculty of Education', 'MIT', 'none'),
('Faculty of Science', 'MIT', 'CH12, PHYS12, MATH12'),
('Faculty of Art','MIT','none'),
('Faculty of Medicine','MIT','please contact direct to us'),
('Department of Dentistry','MIT','please contact direct to us'),
('Faculty of Education', 'UOT', 'none'),
('Faculty of Science', 'UOT', 'CH12, PHYS12, MATH12'),
('Faculty of Art','UOT','none'),
('Faculty of Medicine','UOT','please contact direct to us'),
('Department of Dentistry','UOT','please contact direct to us'),
('Faculty of Education', 'UOW', 'none'),
('Faculty of Science', 'UOW', 'CH12, PHYS12, MATH12'),
('Faculty of Art','UOW','none'),
('Faculty of Medicine','UOW','please contact direct to us'),
('Department of Dentistry','UOW','please contact direct to us');

INSERT INTO
	Local_Address(contact_info_address, postal_code)
VALUES
	('street1', 'ZZZ ZZ1'),
('street2', 'ZZZ ZZ2'),
('street3', 'ZZZ ZZ3'),
('street4', 'ZZZ ZZ4'),
('street5', 'ZZZ ZZ5'),
('street6', 'ZZZ ZZ6'),
('street7', 'ZZZ ZZ7'),
('street8', 'ZZZ ZZ8'),
('street9', 'ZZZ ZZ9'),
('street10', 'ZZZ Z10'),
('street11', 'ZZZ Z11'),
('street12', 'ZZZ Z12'),
('street13', 'ZZZ Z13'),
('street14', 'ZZZ Z14'),
('street15', 'ZZZ Z15');

INSERT INTO 
Contact_info(phone_number,address, email) 
VALUES
('123 456 7890', 'street1', 'A@mail.com'),
('123 456 7890', 'street2', 'B@mail.com'),
('123 456 7890', 'street3', 'C@mail.com'),
('123 456 7890','street4', 'D@mail.com'),
('123 456 7890’', 'street5', 'E@mail.com'),
('123 456 7890', 'street6', 'F@mail.com'),
('123 456 7890', 'street7', 'G@mail.com'),
('123 456 7890', 'street8', 'H@mail.com'),
('123 456 7890','street9', 'I@mail.com'),
('123 456 7890’', 'street10', 'J@mail.com'),
('123 456 7890', 'street11', 'K@mail.com'),
('123 456 7890', 'street12', 'L@mail.com'),
('123 456 7890', 'street13', 'M@mail.com'),
('123 456 7890','street14', 'N@mail.com'),
('123 456 7890', 'street15', 'O@mail.com');

INSERT INTO 
Recruiter (id ,name ,university_name, contact_info_email,login_username) 
VALUES
('R1','NAME1','UBC','A@mail.com','A'),
('R2','NAME2','SFU','B@mail.com','B'),
('R3','NAME3','UOT','C@mail.com','C'),
('R4','NAME4','MIT','D@mail.com','D'),
('R5','NAME5','UOW','E@mail.com','E');




INSERT INTO
	Student(id, name, contact_info_email, login_username)
VALUES
('S1','sname1','F@mail.com','F'),
('S2','sname2','G@mail.com','G'),
('S3','sname3','H@mail.com','H'),
('S4','sname4','I@mail.com','I'),
('S5','sname5','J@mail.com','J'),
('S6','sname6','K@mail.com','K'),
('S7','sname7','L@mail.com','L'),
('S8','sname8','M@mail.com','M'),
('S9','sname9','N@mail.com','N'),
('S10','sname10','O@mail.com','O');

INSERT INTO 
	Agency(name)
VALUES
('agency1'),
('agency2'),
('agency3'),
('agency4'),
('agency5');


INSERT INTO
	HighSchoolStudent(school,student_id,agency_name)
VALUES
	('ahighschool','S1','agency1'),
	('bhighschool','S2','agency2'),
	('chighschool','S3','agency3'),
	('dhighschool','S4','agency4'),
	('ehighschool','S5','agency5');

INSERT INTO
	TransferStudent(university_name ,student_id)
VALUES
	('UBC','S6'),
	('SFU','S7'),
	('UOT','S8'),
	('MIT','S9'),
	('UOW','S10');

INSERT INTO
	Taken(mark,year,student_id,course_number,course_department)
VALUES
	('90','2019','S1','001','MATH'),
	('90','2019','S2','001','MATH'),
	('90','2019','S3','001','MATH'),
	('90','2019','S4','001','MATH'),
	('90','2019','S5','001','MATH');

INSERT INTO
	Application(text,offer,accepted,university_name, faculty_name, student_id)
VALUES
	('text1','accepted','pending','UBC','Faculty of Education','S1'),
	('text2','rejected','pending','UOW','Department of Dentistry','S1'),
	('text3','pending','pending','SFU','Faculty of Science','S1'),
	('text4','pending','pending','MIT','Faculty of Medicine','S1'),
	('text5','pending','pending','UOT','Faculty of Art','S2');


INSERT INTO
	Send(university_name ,application_id ,student_id)
VALUES
	('UBC',1000,'S1'),
	('SFU',1001,'S2'),
	('UOT',1002,'S3'),
	('MIT',1003,'S4'),
	('UOW',1004,'S5');

INSERT INTO
	Review(recruiter_id,application_id)
VALUES
	('R1',1000),
	('R2',1001),
	('R3',1002),
	('R4',1003),
	('R5',1004);
