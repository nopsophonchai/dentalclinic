
CREATE DATABASE dentalclinic;
USE dentalclinic; 
CREATE TABLE gender(
    genderID INT PRIMARY KEY AUTO_INCREMENT,
    genderName VARCHAR(255)
);
CREATE TABLE patient(
    patientID INT PRIMARY KEY AUTO_INCREMENT,
    firstName varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    gender varchar(255) NOT NULL,
    nationalID INT NOT NULL,
    telephone VARCHAR(255),
    houseAddress VARCHAR(255),
    dataOfBirth DATE
);
CREATE TABLE type(
    typeID INT PRIMARY KEY AUTO_INCREMENT,
    typeName VARCHAR(255) NOT NULL
);
CREATE TABLE staff(
    staffID INT PRIMARY KEY AUTO_INCREMENT,
    firstName varchar(255) NOT NULL,
    lastName varchar(255) NOT NULL,
    genderID INT NOT NULL,
    nationalID INT NOT NULL,
    telephone VARCHAR(255),
    houseAddress VARCHAR(255),
    dataOfBirth DATE,
    avaStat VARCHAR(255),
    typeID INT NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    CONSTRAINT typeName FOREIGN KEY (typeID) REFERENCES type(typeID),
    CONSTRAINT genderStaff FOREIGN KEY (genderID) REFERENCES gender(genderID)
);
CREATE TABLE userAccounts(
    UserID INT PRIMARY KEY NOT NULL,
    Username VARCHAR(255),
    Password VARCHAR(255),
    CONSTRAINT user FOREIGN KEY (UserID) REFERENCES patient(PatientID)
);
CREATE TABLE appointment(
    appointmentID INT PRIMARY KEY AUTO_INCREMENT,
    appointmentDate DATE,
    reason TEXT,
    staffID INT NOT NULL,
    patientID INT NOT NULL,
    CONSTRAINT appPatient FOREIGN KEY (patientID) REFERENCES patient(patientID),
    CONSTRAINT appStaff FOREIGN KEY (staffID) REFERENCES staff(staffID)
);
CREATE TABLE salary(
    salaryID INT PRIMARY KEY AUTO_INCREMENT,
    amount INT,
    staffID INT,
    CONSTRAINT salStaff FOREIGN KEY (staffID) REFERENCES staff(staffID)
);
CREATE TABLE billing(
    billingID INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    amount INT,
    billingTime DATE,
    patientID INT,
    CONSTRAINT billPatient FOREIGN KEY (patientID) REFERENCES patient(patientID)
);
CREATE TABLE records(
    recordID INT PRIMARY KEY AUTO_INCREMENT,
    recordTime DATE,
    remarks TEXT,
    treatment TEXT,
    diagnosis TEXT,
    patientID INT NOT NULL,
    CONSTRAINT recordPatient FOREIGN KEY (patientID) REFERENCES patient(patientID)
);
