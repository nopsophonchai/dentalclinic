CREATE DATABASE IF NOT EXISTS dentalclinic;
USE dentalclinic;

CREATE TABLE patient(
    patientID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARBINARY(255) NOT NULL,
    lastName VARBINARY(255) NOT NULL,
    gender VARCHAR(255),
    nationalID VARBINARY(255) NOT NULL UNIQUE,
    telephone VARBINARY(255),
    houseAddress VARBINARY(255),
    dateOfBirth DATE
);

CREATE TABLE type(
    typeID INT PRIMARY KEY AUTO_INCREMENT,
    typeName VARCHAR(255) NOT NULL
);

INSERT INTO type (typeName) VALUES ('Dentist'),('Nurse'),('Receptionist'),('Janitor'),('Security Guard'); 


CREATE TABLE staff(
    staffID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARBINARY(255) NOT NULL,
    lastName VARBINARY(255) NOT NULL,
    gender VARCHAR(255),
    nationalID VARBINARY(255) NOT NULL UNIQUE,
    telephone VARCHAR(255),
    houseAddress VARBINARY(255),
    dateOfBirth DATE,
    avaStat INT(1),
    typeID INT NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    salary VARBINARY(255),
    FOREIGN KEY (typeID) REFERENCES type(typeID)
);

CREATE TABLE userAccounts(
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    patientID INT NOT NULL UNIQUE,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);
CREATE TABLE staffAccount(
    accountID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    staffID INT NOT NULL,
    FOREIGN KEY (staffID) REFERENCES staff(StaffID)
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
    reason VARBINARY(255),
    staffID INT NOT NULL,
    patientID INT NOT NULL,
    completion INT DEFAULT 0,
    FOREIGN KEY (patientID) REFERENCES patient(patientID),
    FOREIGN KEY (staffID) REFERENCES staff(staffID)
);



CREATE TABLE billing(
    billingID INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    amount VARBINARY(255) NOT NULL,
    billingTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    patientID INT NOT NULL,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);


CREATE TABLE records(
    recordID INT PRIMARY KEY AUTO_INCREMENT,
    recordTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remarks VARBINARY(255),
    treatment TEXT,
    diagnosis TEXT,
    patientID INT NOT NULL,
    FOREIGN KEY (patientID) REFERENCES patient(patientID)
);
