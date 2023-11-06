CREATE DATABASE IF NOT EXISTS dentalclinic;
USE dentalclinic;

CREATE TABLE patient(
    patientID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    gender VARCHAR(255),
    nationalID VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(255),
    houseAddress TEXT,
    dateOfBirth DATE
);

CREATE TABLE type(
    typeID INT PRIMARY KEY AUTO_INCREMENT,
    typeName VARCHAR(255) NOT NULL
);

INSERT INTO type (typeName) VALUES ('Dentist'),('Nurse'),('Receptionist'),('Janitor'),('Security Guard'); 


CREATE TABLE staff(
    staffID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    gender VARCHAR(255),
    nationalID VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(255),
    houseAddress VARCHAR(255),
    dateOfBirth DATE,
    avaStat VARCHAR(255),
    typeID INT NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    FOREIGN KEY (typeID) REFERENCES type(typeID)
);

CREATE TABLE userAccounts(
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    patientID INT NOT NULL UNIQUE,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);

CREATE TABLE staffAccounts(
    accountID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);


INSERT INTO staffAccounts(Username, Password) VALUES ('Admin', 'Admin123'); 

CREATE TABLE appointment(
    appointmentID INT PRIMARY KEY AUTO_INCREMENT,
    appointmentDate DATE NOT NULL,
    appointmentTime TIME NOT NULL,
    reason TEXT,
    staffID INT NOT NULL,
    patientID INT NOT NULL,
    FOREIGN KEY (patientID) REFERENCES patient(patientID),
    FOREIGN KEY (staffID) REFERENCES staff(staffID)
);

CREATE TABLE salary(
    salaryID INT PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(10,2) NOT NULL,
    staffID INT NOT NULL,
    FOREIGN KEY (staffID) REFERENCES staff(staffID)
);

CREATE TABLE billing(
    billingID INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    amount DECIMAL(10,2) NOT NULL,
    billingTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    patientID INT NOT NULL,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);


CREATE TABLE records(
    recordID INT PRIMARY KEY AUTO_INCREMENT,
    recordTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remarks TEXT,
    treatment TEXT,
    diagnosis TEXT,
    patientID INT NOT NULL,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);
