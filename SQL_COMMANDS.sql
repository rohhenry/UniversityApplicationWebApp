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
student_id varchar(20),
PRIMARY KEY(id),
FOREIGN KEY(University_name) REFERENCES University(name) 
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

INSERT INTO 
University(name)
VALUES
('AAA'),
('BBB'),
('CCC'),
('DDD'),
('EEE');

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
('001','AAAA','MATH'),
('002','BBBB', 'ENGLISH'),
('003','CCCC','MUSIC'),
('004','DDDD','PHYSICS'),
('005','EEEE','CHEMISTRY');


INSERT INTO 
Faculty (name, university_name, application_Instructions)
VALUES
 	('Faculty of Education', 'AAA', 'none'),
('Faculty of Science', 'BBB', 'CH12, PHYS12, MATH12'),
('Faculty of Art','CCC','none'),
('Faculty of Medicine','DDD','please contact direct to us'),
('Department of Dentistry','EEE','please contact direct to us');

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
('R1','NAME1','AAA','A@mail.com','A'),
('R2','NAME2','BBB','B@mail.com','B'),
('R3','NAME3','CCC','C@mail.com','C'),
('R4','NAME4','DDD','D@mail.com','D'),
('R5','NAME5','EEE','E@mail.com','E');




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
	('AAA','S1'),
	('BBB','S2'),
	('CCC','S3'),
	('DDD','S4'),
	('EEE','S5');

INSERT INTO
	Taken(mark,year,student_id,course_number,course_department)
VALUES
	('90','2019','S1','001','AAAA'),
	('90','2019','S2','001','AAAA'),
	('90','2019','S3','001','AAAA'),
	('90','2019','S4','001','AAAA'),
	('90','2019','S5','001','AAAA');

INSERT INTO
	Application(id,text,offer,accepted,university_name,student_id)
VALUES
	('A1','text1','offer1','pending','AAA','S1'),
	('A2','text2','offer2','pending','AAA','S2'),
	('A3','text3','offer3','pending','BBB','S3'),
	('A4','text4','offer4','pending','DDD','S4'),
	('A5','text5','offer5','pending','CCC','S5');


INSERT INTO
	Send(university_name ,application_id ,student_id)
VALUES
	('AAA','A1','S1'),
	('BBB','A2','S2'),
	('CCC','A3','S3'),
	('DDD','A4','S4'),
	('EEE','A5','S5');

INSERT INTO
	Review(recruiter_id,application_id)
VALUES
	('R1','A1'),
	('R2','A2'),
	('R3','A3'),
	('R4','A4'),
	('R5','A5');
