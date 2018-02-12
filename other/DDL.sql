DROP TRIGGER IF EXISTS Insert_Manufacturer_UUID;
DROP TRIGGER IF EXISTS Insert_Architecture_UUID;
DROP TRIGGER IF EXISTS Insert_Product_UUID;
DROP TRIGGER IF EXISTS Update_Manufacturer_UUID;
DROP TRIGGER IF EXISTS Update_Architecture_UUID;
DROP TRIGGER IF EXISTS Update_Product_UUID;

DROP TABLE IF EXISTS ProductImages;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS Processors;
DROP TABLE IF EXISTS GraphicAccelerators;
DROP TABLE IF EXISTS HardDrives;
DROP TABLE IF EXISTS Memories;
DROP TABLE IF EXISTS ProductTranslations;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS ProcessorArchitectures;
DROP TABLE IF EXISTS GraphicAcceleratorArchitectures;
DROP TABLE IF EXISTS HardDriveArchitectures;
DROP TABLE IF EXISTS MemoryArchitectures;
DROP TABLE IF EXISTS ArchitectureTranslations;
DROP TABLE IF EXISTS Architectures;
DROP TABLE IF EXISTS Manufacturers;
DROP TABLE IF EXISTS Locales;

# Tables
CREATE TABLE Locales(
  idLocale BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(10) NOT NULL
);

ALTER TABLE Locales
  ADD CONSTRAINT UK_Locales_name
  UNIQUE (name);

CREATE TABLE Manufacturers(
  idManufacturer BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  urlKey VARBINARY(16) NOT NULL,
  name VARCHAR(30) NOT NULL
);

ALTER TABLE Manufacturers
  ADD CONSTRAINT UK_Manufacturers_urlKey
  UNIQUE (urlKey);

ALTER TABLE Manufacturers
  ADD CONSTRAINT UK_Manufacturers_name
  UNIQUE (name);

CREATE TABLE Architectures(
  idArchitecture BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  urlKey VARBINARY(16) NOT NULL,
  nameDefault VARCHAR(50) NOT NULL
);

ALTER TABLE Architectures
  ADD CONSTRAINT UK_Architectures_nameDeafault
  UNIQUE (nameDefault);

ALTER TABLE Architectures
  ADD CONSTRAINT UK_Architectures_urlKey
  UNIQUE (urlKey);

CREATE TABLE ArchitectureTranslations(
  idArchitecture BIGINT UNSIGNED,
  idLocale BIGINT UNSIGNED,
  name VARCHAR(50) NOT NULL
);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT FK_ArchitectureTranslations_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT FK_ArchitectureTranslations_Locales
  FOREIGN KEY (idLocale)
  REFERENCES Locales(idLocale);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT PK_ArchitectureTranslations_idArchitecture_idLocale
  PRIMARY KEY (idArchitecture, idLocale);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT UK_ArchitectureTranslations_name
  UNIQUE (name);

CREATE TABLE MemoryArchitectures(
  idArchitecture BIGINT UNSIGNED PRIMARY KEY
);

ALTER TABLE MemoryArchitectures
  ADD CONSTRAINT FK_MemoryArchitectures_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

CREATE TABLE HardDriveArchitectures(
  idArchitecture BIGINT UNSIGNED PRIMARY KEY
);

ALTER TABLE HardDriveArchitectures
  ADD CONSTRAINT FK_HardDriveArchitectures_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

CREATE TABLE GraphicAcceleratorArchitectures(
  idArchitecture BIGINT UNSIGNED PRIMARY KEY
);

ALTER TABLE GraphicAcceleratorArchitectures
  ADD CONSTRAINT FK_GraphicAcceleratorArchitectures_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

CREATE TABLE ProcessorArchitectures(
  idArchitecture BIGINT UNSIGNED PRIMARY KEY
);

ALTER TABLE ProcessorArchitectures
  ADD CONSTRAINT FK_ProcessorArchitectures_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

CREATE TABLE Products(
  idProduct BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  idManufacturer BIGINT UNSIGNED NOT NULL,
  urlKey VARBINARY(16) NOT NULL,
  name VARCHAR(100) NOT NULL
);

ALTER TABLE Products
  ADD CONSTRAINT UK_Products_urlKey
  UNIQUE (urlKey);

ALTER TABLE Products
  ADD CONSTRAINT UK_Products_name
  UNIQUE (name);

ALTER TABLE Products
  ADD CONSTRAINT FK_Products_Manufacturers
  FOREIGN KEY (idManufacturer)
  REFERENCES Manufacturers(idManufacturer);

CREATE TABLE ArchitectureTranslations(
  idArchitecture BIGINT UNSIGNED,
  idLocale BIGINT UNSIGNED,
  name VARCHAR(50) NOT NULL
);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT FK_ArchitectureTranslations_Architectures
  FOREIGN KEY (idArchitecture)
  REFERENCES Architectures(idArchitecture);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT FK_ArchitectureTranslations_Locales
  FOREIGN KEY (idLocale)
  REFERENCES Locales(idLocale);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT PK_ArchitectureTranslations_idArchitecture_idLocale
  PRIMARY KEY (idArchitecture, idLocale);

ALTER TABLE ArchitectureTranslations
  ADD CONSTRAINT UK_ArchitectureTranslations_name
  UNIQUE (name);

CREATE TABLE Memories(
  idProduct BIGINT UNSIGNED PRIMARY KEY,
  idArchitecture BIGINT UNSIGNED NOT NULL,
  size INT UNSIGNED NOT NULL
);

ALTER TABLE Memories
  ADD CONSTRAINT FK_Memories_Products
  FOREIGN KEY (idProduct)
  REFERENCES Products(idProduct);

ALTER TABLE Memories
  ADD CONSTRAINT FK_Memories_MemoryArchitectures
  FOREIGN KEY (idArchitecture)
  REFERENCES MemoryArchitectures(idArchitecture);

CREATE TABLE HardDrives(
  idProduct BIGINT UNSIGNED PRIMARY KEY,
  idArchitecture BIGINT UNSIGNED NOT NULL,
  size INT UNSIGNED NOT NULL
);

ALTER TABLE HardDrives
  ADD CONSTRAINT FK_HardDrives_Products
  FOREIGN KEY (idProduct)
  REFERENCES Products(idProduct);

ALTER TABLE HardDrives
  ADD CONSTRAINT FK_HardDrives_HardDriveArchitectures
  FOREIGN KEY (idArchitecture)
  REFERENCES HardDriveArchitectures(idArchitecture);

CREATE TABLE GraphicAccelerators(
  idProduct BIGINT UNSIGNED PRIMARY KEY,
  idArchitecture BIGINT UNSIGNED NOT NULL
);

ALTER TABLE GraphicAccelerators
  ADD CONSTRAINT FK_GraphicAccelerators_Products
  FOREIGN KEY (idProduct)
  REFERENCES Products(idProduct);

ALTER TABLE GraphicAccelerators
  ADD CONSTRAINT FK_GraphicAccelerators_GraphicAcceleratorArchitectures
  FOREIGN KEY (idArchitecture)
  REFERENCES GraphicAcceleratorArchitectures(idArchitecture);

CREATE TABLE Processors(
  idProduct BIGINT UNSIGNED PRIMARY KEY,
  idArchitecture BIGINT UNSIGNED NOT NULL,
  idGraphicAccelerator BIGINT UNSIGNED NULL,
  frequency DOUBLE NOT NULL,
  cacheSize INT UNSIGNED,
  isHyperthreaded BOOL NOT NULL,
  nbCores INT UNSIGNED NOT NULL
);

ALTER TABLE Processors
  ADD CONSTRAINT FK_Processors_Products
  FOREIGN KEY (idProduct)
  REFERENCES Products(idProduct);

ALTER TABLE Processors
  ADD CONSTRAINT FK_Processors_ProcessorArchitectures
  FOREIGN KEY (idArchitecture)
  REFERENCES ProcessorArchitectures(idArchitecture);
  
ALTER TABLE Processors
  ADD CONSTRAINT FK_Processors_GraphicAccelerators
  FOREIGN KEY (idGraphicAccelerator)
  REFERENCES GraphicAccelerators(idProduct);

CREATE TABLE Images(
  idImage BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(500)
);

ALTER TABLE Images
  ADD CONSTRAINT UK_Images_filename
  UNIQUE (filename);

CREATE TABLE ProductImages(
  idImage BIGINT UNSIGNED NOT NULL,
  idProduct BIGINT UNSIGNED NOT NULL
);

ALTER TABLE ProductImages
  ADD CONSTRAINT FK_MemoryImages_Images
  FOREIGN KEY (idImage)
  REFERENCES Images(idImage);
  
ALTER TABLE ProductImages
  ADD CONSTRAINT FK_MemoryImages__Products
  FOREIGN KEY (idProduct)
  REFERENCES Memories(idProduct);
  
ALTER TABLE ProductImages
  ADD CONSTRAINT PK_MemoryImages_idImage_idProduct
  PRIMARY KEY (idImage, idProduct);

# Triggers
CREATE TRIGGER Insert_Manufacturer_UUID
  BEFORE INSERT ON Manufacturers
  FOR EACH ROW
  SET NEW.urlKey = UUID();

CREATE TRIGGER Insert_Architecture_UUID
  BEFORE INSERT ON Architectures
  FOR EACH ROW
  SET NEW.urlKey = UUID();

CREATE TRIGGER Insert_Product_UUID
  BEFORE INSERT ON Products
  FOR EACH ROW
  SET NEW.urlKey = UUID();
  
CREATE TRIGGER Update_Manufacturer_UUID
  BEFORE UPDATE ON Manufacturers
  FOR EACH ROW
  SET NEW.urlKey = OLD.urlKey;
  
CREATE TRIGGER Update_Architecture_UUID
  BEFORE UPDATE ON Architectures
  FOR EACH ROW
  SET NEW.urlKey = OLD.urlKey;
  
CREATE TRIGGER Update_Product_UUID
  BEFORE UPDATE ON Products
  FOR EACH ROW
  SET NEW.urlKey = OLD.urlKey;
