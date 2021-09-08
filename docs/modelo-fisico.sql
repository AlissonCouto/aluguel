CREATE DATABASE vehicleRent
	DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;
    
USE vehicleRent;

# CREATE TABLES

CREATE TABLE tbBrands (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description varchar(191) NOT NULL UNIQUE
) engine = InnoDb;

CREATE TABLE tbModels (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description varchar(191) NOT NULL UNIQUE,
    brandId INT(10) UNSIGNED,
    CONSTRAINT fk_model_brand FOREIGN KEY (brandId) REFERENCES tbBrands (id)
) engine = InnoDb;

CREATE TABLE tbVehicles (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    licensePlate varchar(191) NOT NULL UNIQUE,
    year YEAR NOT NULL,
    dailyRate decimal(5, 2) NOT NULL,
    status ENUM('rented', 'available') NOT NULL,
    modelId INT(10) UNSIGNED,
    CONSTRAINT fk_vehicle_model FOREIGN KEY (modelId) REFERENCES tbModels (id)
) engine = InnoDb;

CREATE TABLE tbClients (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(191) NOT NULL,
    CNH VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255)
) engine = InnoDb;

CREATE TABLE tbEmployees (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(191) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) engine = InnoDb;

CREATE TABLE tbRents (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    initialDate date NOT NULL,
    finalDate date NOT NULL,
    status ENUM('progress', 'concluded'),
    vehicleId INT(10) UNSIGNED UNIQUE,
    clientId INT(10) UNSIGNED,
    employeeId INT(10) UNSIGNED,
    CONSTRAINT fk_rent_vehicle FOREIGN KEY (vehicleId) REFERENCES tbVehicles(id),
    CONSTRAINT fk_rent_client FOREIGN KEY (clientId) REFERENCES tbClients(id),
    CONSTRAINT fk_rent_employee FOREIGN KEY (employeeId) REFERENCES tbEmployees(id)
) engine InnoDb;
