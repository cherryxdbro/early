IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = "early")
BEGIN
    CREATE DATABASE early;
END;
GO

USE early;
GO

IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = "organizations")
BEGIN
    CREATE TABLE organizations (
        id INT PRIMARY KEY IDENTITY(1,1),
        name NVARCHAR(64) NOT NULL,
        address NVARCHAR(256) NOT NULL,
        phone NVARCHAR(64) NOT NULL
    );
END;
GO

IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = "organization_divisions")
BEGIN
    CREATE TABLE organization_divisions (
        organization_id INT NOT NULL,
        division_id INT NOT NULL,
        CONSTRAINT FK_Organization FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
        CONSTRAINT FK_Division FOREIGN KEY (division_id) REFERENCES organizations(id) ON DELETE CASCADE,
        PRIMARY KEY (organization_id, division_id)
    );
END;
GO