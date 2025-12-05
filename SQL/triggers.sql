
-- Prevent a driver from having Rating > 5
CREATE TRIGGER [dbo].[TRG_Check_Rating]
ON [dbo].[User]
FOR INSERT, UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    IF EXISTS (SELECT 1
               FROM inserted 
               WHERE Rating > 5 OR Rating < 0)
    BEGIN
        RAISERROR ('Rating must be between 0 and 5', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO


-- Prevent Expired Drivers Documents
CREATE TRIGGER [dbo].[TRG_DriverDoc_NoExpiredDocs]
ON [dbo].[Driver_Doc]
FOR INSERT, UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    IF EXISTS (
        SELECT 1
        FROM inserted
        WHERE Issue_Date < DATEADD(YEAR, -3, GETDATE())
    )
    BEGIN
        RAISERROR ('Driver document is expired. Update with a valid document.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
Go

-- Prevent Drivers Aged under 18
CREATE TRIGGER [dbo].[TRG_User_MinDriverAge]
ON [dbo].[User]
FOR INSERT, UPDATE
AS
BEGIN
    SET NOCOUNT ON

    IF EXISTS (
        SELECT 1
        FROM inserted
        WHERE Type_ID =3
        AND DATEDIFF(YEAR, B_Date, GETDATE()) < 18
    )
    BEGIN
        RAISERROR ('Drive has not reached the minimum age (18)', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO

-- Prevent Impossible Trip Times
CREATE TRIGGER [dbo].[TRG_TripSegment_IllegalTime]
ON [dbo].[Trip_Segment]
FOR INSERT, UPDATE
AS
BEGIN
    IF EXISTS (
        SELECT 1
        FROM inserted
        WHERE Departure_Time >= Arrival_Time
    )
    BEGIN
        RAISERROR ('Departure time must be before the Arrival Time.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO


-- Checks if a the a single driver has multiple vehicles of the same service type
CREATE TRIGGER [dbo].[TRG_OneVehiclePerServiceType]
ON [dbo].[Service_Type]
FOR INSERT
AS
BEGIN

    IF EXISTS (
        SELECT 1
        FROM inserted I

        -- We get the Service type of the vehicle
        JOIN Vehicle V1 
            ON V1.License_Plate = I.License_Plate 
            AND V1.Frame_Number = I.Frame_Number
            AND V1.Engine_Number = I.Engine_Number

        -- We chose a 2nd vehicle of the same driver, different from the first
        JOIN Vehicle V2 ON V2.Driver_Id = V1.Driver_ID
            AND NOT (
                V2.License_Plate = V1.License_Plate AND
                V2.Frame_Number = V1.Frame_Number AND
                V2.Engine_Number = V1.Engine_Number
            )
        
        -- as well as the 2nd vehicles service type
        JOIN Service_Type ST
            ON V2.License_Plate = ST.License_Plate
            AND V2.Frame_Number = ST.Frame_Number
            AND V2.Engine_Number = ST.Engine_Number
            
        -- If the 2 vehicles have do the same service
        WHERE ST.S_Type_Name = I.S_Type_Name
    )
    BEGIN --Raise Error and rollback
        RAISERROR('A Driver can only have 1 Vehicle per Service Type', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO

