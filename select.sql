-------- 1. User
SELECT *
FROM [dbo].[User];
GO

SELECT COUNT(*)
FROM [dbo].[User] 
GO

SELECT *
FROM [dbo].[User]
WHERE Type_ID = 1;
GO

SELECT *
FROM [dbo].[User]
WHERE Type_ID = 2;
GO

SELECT *
FROM [dbo].[User]
WHERE Type_ID = 3;
GO

SELECT *
FROM [dbo].[User]
WHERE Type_ID = 4;
GO

SELECT *
FROM [dbo].[User]
WHERE Type_ID = 5;
GO

-- Selects Users by their UserID
CREATE PROCEDURE [dbo].[GetUsetByID]
    @User_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[User]
    WHERE User_ID = @User_ID;
END;
GO

-- Selects Users by their Username
CREATE PROCEDURE [dbo].[GetUserByUsername]
    @Username NVARCHAR(225)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[User]
    WHERE Username = @Username
END;
GO

-- Insert User
CREATE PROCEDURE [dbo].[AddUser]
    @Username VARCHAR(30),
    @Password VARCHAR(255),
    @Email VARCHAR(60),
    @F_Name VARCHAR(30),
    @L_Name VARCHAR(30),
    @Phone VARCHAR(25),
    @Gender VARCHAR(40),
    @B_Date DATE,
    @Address VARCHAR(40),
    @Type_ID INT

AS
BEGIN
    SET NOCOUNT ON;
    --Validate the TypeID
    IF @TypeID NOT IN (1,2,3,4,5)
    BEGIN
        RAISERROR('Invalid Type_ID: This User Type does not exist', 16, 1)
        RETURN;
    END

    --Check if Email Is unique
    IF EXISTS (SELECT 1 FROM [dbo].[User] WHERE Email = @Email)
    BEGIN
        RAISERROR('Invalid Email: Email is already taken', 16, 1)
        RETURN;
    END

    --Check if Username is unique
    IF EXISTS (SELECT 1 FROM [dbo].[User] WHERE Username = @Username)
    BEGIN
        RAISERROR('Invalid Username: Username is already taken', 16, 1)
        RETURN;
    END

    

    -- Insert new User 
    INSERT INTO [dbo].[User] 
    (Username, Password, Email, F_Name, L_Name, Phone, Gender, B_Date, Address, Rating, PFP, Type_ID)
    VALUES
    (
        @Username,
        @Password,
        @Email,
        @F_Name,
        @L_Name,
        @Phone,
        @Gender,
        @B_Date,
        @Address,
        0,
        'no_pfp',
        @Type_ID    
    );
END;
GO

-- Update User
CREATE PROCEDURE [dbo].[UpdateUser]
    @User_ID INT,
    @Username VARCHAR(30)   = NULL,
    @Password VARCHAR(255)  = NULL,
    @Email VARCHAR(60)      = NULL,
    @F_Name VARCHAR(30)     = NULL,
    @L_Name VARCHAR(30)     = NULL,
    @Phone VARCHAR(25)      = NULL,
    @Gender VARCHAR(40)     = NULL,
    @B_Date DATE            = NULL,
    @Address VARCHAR(40)    = NULL,
    @PFP VARCHAR(255)       = NULL

AS
BEGIN
    SET NOCOUNT ON;

    -- Valicate User ID
    IF NOT EXISTS (SELECT 1 FROM [dbo].[User] WHERE User_ID = @User_ID)
    BEGIN
        RAISERROR('User does not exist', 16, 1);
        RETURN;
    END

    --Check if Email Is unique
    IF @Email IS NOT NULL 
        AND EXISTS (
            SELECT 1 FROM [dbo].[User] 
            WHERE Email = @Email 
            AND @User_ID != User_ID
            )
    BEGIN
        RAISERROR('Invalid Email: Email is already taken', 16, 1)
        RETURN;
    END

    --Check if Username is unique
    IF @Username IS NOT NULL 
        AND EXISTS (
            SELECT 1 FROM [dbo].[User] 
            WHERE Username = @Username 
            AND @User_ID != User_ID
            )
    BEGIN
        RAISERROR('Invalid Username: Username is already taken', 16, 1)
        RETURN;
    END

    -- Update user (only non-null values)
    UPDATE [dbo].[User]
    SET
        Username    = COALESCE(@Username, Username),
        Password    = COALESCE(@Password, Password),
        Email       = COALESCE(@Email, Email),
        F_Name      = COALESCE(@F_Name, F_Name),
        L_Name      = COALESCE(@L_Name, L_Name),
        Phone       = COALESCE(@Phone, Phone),
        Gender      = COALESCE(@Gender, Gender),
        B_Date      = COALESCE(@B_Date, B_Date),
        Address     = COALESCE(@Address, Address),
        PFP         = COALESCE(@PFP, PFP)
        WHERE @User_ID = User_ID
END;
GO

-- DELETE USER TODO -----------------------------------------



-------- 2. GDPR
SELECT *
FROM [dbo].[GDPR_Request_Log];
GO

-------- 6. Driver Documents
-- Adds a new Driver doc to the table
CREATE PROCEDURE [dbo].[AddDriverDoc]
    @Doc_Type VARCHAR(50),
    @Driver_ID INT,
    @Issue_Date DATE
AS
BEGIN
    SET NOCOUNT ON;
    --Validate Document Type
    IF @Doc_Type NOT IN (
        'ID', 
        'Passport', 
        'Residence Permit', 
        'Drivers Licence',
        'MOT',
        'Criminal Record',
        'Doctor Certificate',
        'Psychologist Certificate'
        )
    BEGIN
        RAISERROR('ERROR IN AddDriverDoc: Invalid Driver Document Type', 16, 1)
        RETURN;
    END

    -- Check if user exists, and is a Driver
    IF NOT EXISTS (SELECT 1 FROM [dbo].[User] WHERE @Driver_ID = User_ID AND Type_ID = 3)
    BEGIN
      RAISERROR('ERROR IN AddDriverDoc: This Driver is not valid, or does not exist', 16, 1)
        RETURN;  
    END

    -- Checks if this Ducument already exists for this Driver
    IF EXISTS (
        SELECT 1
        FROM [dbo].[Driver_Doc] DD
        WHERE Driver_ID = @Driver_ID AND Doc_Type = @Doc_Type
        )
    BEGIN
      RAISERROR('ERROR IN AddDriverDoc: This Document already exists for this Driver', 16, 1)
        RETURN;  
    END  

INSERT INTO [dbo].[Driver_Doc] (
    Doc_Type,
    Issue_Date,
    Driver_ID,
    Operator_ID
)
VALUES(
    @Doc_Type,
    @Issue_Date,
    @Driver_ID,
    NULL
);
END;
GO


-------- 7. Vehicle Documents
-- Selects all Vehicle Docs for a specific Vehicle ID
CREATE PROCEDURE [dbo].[GetVehicleDocs]
    @License_Plate NVARCHAR(50),
    @Frame_Number NVARCHAR(50),
    @Engine_Number NVARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[Vehicle_Doc]
    WHERE License_Plate = @License_Plate AND 
            Frame_Number = @Frame_Number AND 
            Engine_Number = @Engine_Number;
END;
GO

-- Adds a new Vehicle doc to the table
CREATE PROCEDURE [dbo].[AddVehicleDoc]
    @Doc_Type VARCHAR(50),
    @Issue_Date DATE,
    @Exp_Date DATE,
    @License_Plate VARCHAR(20),
    @Frame_Number VARCHAR(50),
    @Engine_Number VARCHAR(50)

AS 
BEGIN
    SET NOCOUNT ON;

    -- Check if Document Type is valid
    IF @Doc_Type NOT IN (
        'Vehicle Registration',
        'MOT',
        'Vehicle Classification',
        'Vehicle Images'
    )
    BEGIN
        RAISERROR('ERROR IN AddVehicleDoc: Invalide Document Type', 16, 1)
        RETURN;
    END

    -- Check if car exists
    IF NOT EXISTS (
            SELECT 1
            FROM [dbo].[Vehicle]
            WHERE License_Plate = @License_Plate
            AND Frame_Number = @Frame_Number
            AND Engine_Number = @Engine_Number
        )
    BEGIN
        RAISERROR('ERROR IN AddVehicleDoc: Vehicle does not exist', 16, 1)
        RETURN;
    END

    -- Check if the same document already exists
    IF EXISTS (
        SELECT 1
        FROM [dbo].[Vehicle_Doc]
        WHERE Doc_Type = @Doc_Type
        AND License_Plate = @License_Plate
        AND Frame_Number = @Frame_Number
        AND Engine_Number = @Engine_Number
    )
    BEGIN
        RAISERROR('ERROR IN AddVehicleDoc: This Document already exists for this vehicel', 16, 1)
        RETURN;
    END

    INSERT INTO [dbo].[Vehicle_Doc] (
    Doc_Type,
    Issue_Date,
    Exp_Date,
    License_Plate,
    Frame_Number,
    Engine_Number,
    Operator_ID
    )
    VALUES (
        @Doc_Type,
        @Issue_Date,
        @Exp_Date,
        @License_Plate,
        @Frame_Number,
        @Engine_Number,
        NULL
    );
END;
GO

-------- 8. Vehicle Inspection
-- Selects all Vehicle Inspections for a specific vehicle
CREATE PROCEDURE [dbo].[GetVehicleInspections]
    @License_Plate NVARCHAR(50),
    @Frame_Number NVARCHAR(50),
    @Engine_Number NVARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[Vehicle_Inspection]
    WHERE License_Plate = @License_Plate AND 
            Frame_Number = @Frame_Number AND 
            Engine_Number = @Engine_Number;
END;
GO  

-------- 9. Vehicle 
-- Selects all vehicles for a specific Driver_ID
CREATE PROCEDURE [dbo].[GetVehicleByDriver]
    @Driver_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[Vehicle]
    WHERE Driver_ID = @Driver_ID
END;
GO

-- Count the ammount of vehicles depending of each Driver, Type,
-- or in each Geofence depending on the filter
-- Filter is either "Driver", "Type" and "Geofence"
CREATE PROCEDURE [dbo].[CountVehicles]
    @Filter NVARCHAR(50) = NULL
    
AS
BEGIN
    SET NOCOUNT ON;

    IF @Filter = "Driver"
    BEGIN
        SELECT Driver_ID, COUNT(*) AS Vehicle_Count
        FROM [dbo].[Vehicle]
        GROUP BY Driver_ID;
        RETURN;
    END;

    IF @Filter = "Type"
    BEGIN
        SELECT Vehicle_Type, COUNT(*) AS Vehicle_Count
        FROM [dbo].[Vehicle]
        GROUP BY Vehicle_Type;
        RETURN;
    END;

    IF @Filter = "Geofence"
    BEGIN
        SELECT Geofence_ID, COUNT(*) AS Vehicle_Count
        FROM [dbo].[Vehicle]
        GROUP BY Geofence_ID;
        RETURN;
    END;

    SELECT *
    FROM [dbo].[Vehicle];
END;
GO

-- Insert Vehicle
CREATE PROCEDURE [dbo].[InsertVehicle]
    @User_ID INT, -- User inserting their vehicle

    @License_Plate VARCHAR(20),
    @Frame_Number VARCHAR(50),
    @Engine_Number VARCHAR(50),
    @Car_Type VARCHAR(50),
    @Load_Space FLOAT,
    @Number_Of_Seats INT,
    @Geofence_ID INT
    
AS
BEGIN
    SET NOCOUNT ON;

    -- Validate Vehicle ID
    IF EXISTS (
        SELECT 1
        FROM [dbo].[Vehicle]
        WHERE @License_Plate = License_Plate
        AND @Frame_Number = Frame_Number
        AND @Engine_Number = Engine_Number
    )
    BEGIN
        RAISERROR('ERROR IN InsertVehicle: Vehicle already exists', 16, 1)
        RETURN;
    END

    -- Check if Geofence Exists
    IF NOT EXISTS (
        SELECT 1
        FROM [dbo].[Geofence]
        WHERE Geofence_ID = @Geofence_ID
    )
    BEGIN
        RAISERROR('ERROR IN InsertVehicle: This Geofence does not exist', 16, 1)
        RETURN;
    END

    DECLARE @Driver_ID INT
    DECLARE @Company_Rep_ID INT
    DECLARE @Type_ID INT
    SET @Type_ID = (SELECT Type_ID FROM [dbo].[User] WHERE User_ID = @User_ID)

    -- Check if the user inserting the car is a Driver or a Company Rep
    IF @Type_ID = 3
    BEGIN
        SET @Driver_ID = @User_ID
        SET @Company_Rep_ID = NULL
    END

    ELSE IF @Type_ID = 5
    BEGIN
        SET @Driver_ID = NULL
        SET @Company_Rep_ID = @User_ID
    END

    ELSE
    BEGIN
        RAISERROR('ERROR IN InsertVehicle: This user type is not allowed to insert a vehicle', 16, 1)
        RETURN;
    END
    
    

    INSERT INTO [dbo].[Vehicle] (
        License_Plate, 
        Frame_Number, 
        Engine_Number, 
        Car_Type, 
        Load_Space,
        Number_Of_Seats,
        Driver_ID, 
        Company_Rep_ID, 
        Op_Audits, 
        Geofence_ID 
    )
    VALUES(
        @License_Plate,
        @Frame_Number,
        @Engine_Number,
        @Car_Type,
        @Load_Space,
        @Number_Of_Seats,
        @Driver_ID, 
        @Company_Rep_ID, 
        NULL,
        @Geofence_ID
    );
END;
GO

-------- 10. Trip Segment
SELECT *
FROM [dbo].[Trip_Segment]
ORDER BY TT_ID, Departure_Time;
GO

CREATE PROCEDURE [dbo].[GetSegmentDetails]
    @TT_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        TS.*, DU.Username AS Driver_Username,
        PU.Username AS Passenger_Username
    FROM [dbo].[Trip_Segment] TS,  [dbo].[User] DU, [dbo].[User] PU
    WHERE TS.TT_ID = @TT_ID 
    AND DU.User_ID = TS.Drv_ID
    AND PU.User_ID = TS.Psg_ID
    ORDER BY TS.Departure_Time
END;
GO

-------- 12. In App Message 
-- Get the In App Messages for a specific TripID
CREATE PROCEDURE [dbo].[GetMessagesByTrip]
    @Trip_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        IAM.*
        FROM [dbo].[In_App_Message] IAM
        WHERE IAM.Trip_ID = @Trip_ID
    END;
GO

-------- 14. Service Type
-- Selects all the service types a specific vehicle provides
CREATE PROCEDURE [dbo].[GetServiceTypesForVehicle]
    @License_Plate NVARCHAR(50),
    @Frame_Number NVARCHAR(50),
    @Engine_Number NVARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[Service_Type]
    WHERE License_Plate = @License_Plate AND 
            Frame_Number = @Frame_Number AND 
            Engine_Number = @Engine_Number;
END;
GO  

-------- 15. Total Trip
SELECT *
FROM [dbo].[Total_Trip];
GO

-- Get a specific Users list of Total_Trips
CREATE PROCEDURE [dbo].[GetTotalTripsByUser]
    @User_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT *
    FROM [dbo].[Total_Trip]
    WHERE User_ID = @User_ID
END;
GO

-------- 16. Payment
-- Get the PaymentID of the transaction of a specific Total_Trip
CREATE PROCEDURE [dbo].[GetPaymentForTrip]
    @TT_ID INT

AS
BEGIN
    SET NOCOUNT ON;

    SELECT P.*
    FROM [dbo].[Payment] P, [dbo].[Total_Trip] TT
    WHERE @TT_ID = TT.TT_ID AND P.Payment_ID = TT.Payment_ID
END;
GO

-- Get All Payments of a specific User
CREATE PROCEDURE [dbo].[GetPaymentsByUser]
    @User_ID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT P.*
    FROM [dbo].[Payment] P, [dbo].[Total_Trip] TT 
    WHERE @User_ID = TT.User_ID AND TT.Payment_ID = P.Payment_ID
END;
GO

-------- Front-end QOL Misc
-- Get All Dashboard Stats
CREATE PROCEDURE GetDashboardStats
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        (SELECT COUNT(*) FROM [dbo].[User]) AS TotalUsers,
        (SELECT COUNT(*) FROM [dbo].[User] WHERE Type_ID = 2) AS ActiveDrivers,
        (SELECT COUNT(*) FROM [dbo].[Vehicle]) AS VehiclesInService,
        (SELECT COUNT(*) FROM [dbo].[Total_Trip]) AS TotalTrips,
        (SELECT COUNT(*) FROM [dbo].[GDPR_Request_Log]) AS GdprRequests;
END;