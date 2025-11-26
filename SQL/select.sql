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
CREATE PROCEDURE [dbo].[GetUserByID]
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
        IF @Type_ID NOT IN (1,2,3,4,5)
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

        IF @Filter = 'Driver'
        BEGIN
            SELECT Driver_ID, COUNT(*) AS Vehicle_Count
            FROM [dbo].[Vehicle]
            GROUP BY Driver_ID;
            RETURN;
        END;

        IF @Filter = 'Type'
        BEGIN
            SELECT Car_Type, COUNT(*) AS Vehicle_Count
            FROM [dbo].[Vehicle]
            GROUP BY Car_Type;
            RETURN;
        END;

        IF @Filter = 'Geofence'
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
    @User_ID INT, -- Driver inserting their vehicle

    @License_Plate VARCHAR(20),
    @Frame_Number VARCHAR(50),
    @Engine_Number VARCHAR(50),
    @Car_Type VARCHAR(50),
    @Load_Space FLOAT,
    @Number_Of_Seats INT,
    @Op_Audits INT = NULL,
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
            @Op_Audits,
            @Geofence_ID
        );
    END;
    GO


-------- 10. Trip Segment
SELECT *
FROM [dbo].[Trip_Segment]
ORDER BY TT_ID, Departure_Time;
GO

-- Get Trip Segments of a Total Trip 
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

-- Insert Trip Segment
CREATE PROCEDURE [dbo].[InsertTripSegment]
        @Distance FLOAT,
        @Drv_ID INT,
        @Psg_ID INT,
        @From_Location_X DECIMAL(9,6),
        @From_Location_Y DECIMAL(9,6),
        @To_Location_X DECIMAL(9,6),
        @To_Location_Y DECIMAL(9,6),
        @Departure_Time DATETIME,
        @Arrival_Time DATETIME,

        @TT_ID INT,
        @Payment_ID INT
    AS
    BEGIN
        SET NOCOUNT ON;

        -- Validate Distance
        IF @Distance < 0
        BEGIN
            RAISERROR('ERROR IN InsertTripSegment: Distance can not be negative', 16, 1)
            RETURN;
        END

        -- Validate Driver ID
        IF NOT EXISTS (
            SELECT 1
            FROM [dbo].[User]
            WHERE User_ID = @Drv_ID
        )
        BEGIN
            RAISERROR('ERROR IN InserTripSegment: Driver ID does not exist', 16, 1)
            RETURN;
        END

        -- Validate Passenger ID
        IF NOT EXISTS (
            SELECT 1
            FROM [dbo].[User]
            WHERE User_ID = @Psg_ID
        )
        BEGIN
            RAISERROR('ERROR IN InserTripSegment: Passenger ID does not exist', 16, 1)
            RETURN;
        END

        -- Validate Departure and Arrival Time
        IF @Arrival_Time <= @Departure_Time
        BEGIN
            RAISERROR('ERROR IN InserTripSegment: Arrival or Departure time invalid', 16, 1)
            RETURN;
        END

        -- Validate Total Trip ID
        IF NOT EXISTS (
            SELECT 1
            FROM [dbo].[Total_Trip]
            WHERE TT_ID = @TT_ID
        )
        BEGIN
            RAISERROR('ERROR IN InserTripSegment: Total Trip ID does not exist', 16, 1)
            RETURN;
        END

        -- Validate Payment ID
        IF NOT EXISTS (
            SELECT 1
            FROM [dbo].[Payment]
            WHERE Payment_ID = @Payment_ID
        )
        BEGIN
            RAISERROR('ERROR IN InserTripSegment: Payment ID does not exist', 16, 1)
            RETURN;
        END

        -- Trip log is tied to a segemnt
        -- Create the segments corresponding trip log
        DECLARE @TL_ID INT;
        INSERT INTO [dbo].[Trip_Log] DEFAULT VALUES;
        SET @TL_ID = SCOPE_IDENTITY();


        INSERT INTO [dbo].[Trip_Segment] (
            Distance,
            Drv_ID,
            Psg_ID,
            From_Location_X,
            From_Location_Y,
            To_Location_X,
            To_Location_Y,
            Departure_Time,
            Arrival_Time,
            TL_ID,
            TT_ID,
            Payment_ID
        )
        VALUES(
            @Distance,
            @Drv_ID,
            @Psg_ID,
            @From_Location_X,
            @From_Location_Y,
            @To_Location_X,
            @To_Location_Y,
            @Departure_Time,
            @Arrival_Time,
            @TL_ID,
            @TT_ID,
            @Payment_ID
        );
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

-- Create a new Payment
CREATE PROCEDURE [dbo].[CreatePayment]
        @Payment_ID INT,
        @Price FLOAT,

        @ST_ID INT
    AS
    BEGIN
        SET NOCOUNT ON;


    END;
    GO


-------- Front-end QOL Misc ------------------------------------------------------------------
-- Get All Dashboard Stats -------------------------------------------------------------------
CREATE PROCEDURE [dbo].[GetDashboardStats]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        (SELECT COUNT(*) FROM [dbo].[User]) AS TotalUsers,
        (SELECT COUNT(*) FROM [dbo].[User] WHERE Type_ID = 3) AS ActiveDrivers,
        (SELECT COUNT(*) FROM [dbo].[Vehicle]) AS VehiclesInService,
        (SELECT COUNT(*) FROM [dbo].[Total_Trip]) AS TotalTrips,
        (SELECT COUNT(*) FROM [dbo].[GDPR_Request_Log]) AS GdprRequests;
END;
GO


-- ORDERING A NEW TRIP
CREATE PROCEDURE [dbo].[NewTrip]
    @PassengerID INT,
    @Desired_Service_Type VARCHAR(50),
    @From_Location_X DECIMAL(9,6),
    @From_Location_Y DECIMAL(9,6),
    @To_Location_X DECIMAL(9,6),
    @To_Location_Y DECIMAL(9,6),
    @Payment_Method VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;

-- First we validate all of the info
    -- If the passenger doesn't exists, or has the wrong TypeID
    IF NOT EXISTS (
        SELECT 1 FROM [dbo].[User]
        WHERE @PassengerID = User_ID AND Type_ID = 4
    )
    BEGIN
        RAISERROR('ERROR IN NewTrip: Invalid User (Passenger)', 16, 1)
        RETURN;
    END

    IF @Payment_Method NOT IN ('Card', 'Cash', 'Apple Pay', 'PayPal', 'Google Pay', 'CashApp', 'Crypto')
    BEGIN
        RAISERROR('ERROR IN NewTrip: Payment Method not supported', 16, 1)
        RETURN;
    END

    IF (@From_Location_X IS NULL) OR (@From_Location_Y IS NULL)
    BEGIN
        RAISERROR('ERROR IN NewTrip: From_Location can not be NULL', 16, 1)
        RETURN;
    END

    --------- Find the IDs of the Geofences FromLocation and ToLocation are in ---------
    DECLARE @From_GeofenceID INT
    DECLARE @To_GeofenceID INT

    SET @From_GeofenceID = (
            SELECT Geofence_ID -- Geofences will not overlap, no need to TOP
            FROM [dbo].[Geofence] G
            WHERE @From_Location_X BETWEEN G.C1_X AND G.C3_X
            AND @From_Location_Y BETWEEN G.C1_Y AND G.C3_Y
            )
    -- Validate the result of the above subquery
    IF @From_GeofenceID IS NULL
    BEGIN
        RAISERROR('ERROR IN NewTrip: From_Location is not on the map (Outside of all Geofences)', 16, 1)
        RETURN;
    END
    
    -- If we have a destination, find in which geofence it belongs to
    IF (@To_Location_X IS NULL) OR (@To_Location_Y IS NULL)
    BEGIN
        SET @To_GeofenceID = NULL
    END
    ELSE
    BEGIN
        SET @To_GeofenceID = (
            SELECT Geofence_ID
            FROM [dbo].[Geofence] G
            WHERE @To_Location_X BETWEEN G.C1_X AND G.C3_X
            AND @To_Location_Y BETWEEN G.C1_Y AND G.C3_Y
            )
    END

    -- DFS to find the path (bridges) to the destination
    -- Start a CTE 
    ;WITH DFS AS(
        -- ANCHOR STEP
        -- We start from the GeofenceID of the Starting coordinates
        -- Create a Path Variable to record our route
        SELECT @From_GeofenceID AS GID, CAST(@From_GeofenceID AS VARCHAR(MAX)) AS Path
        
        UNION ALL -- Expands the recursive rows to our anchor table

        -- RECURSIVE STEP
        SELECT
            -- If we find a bridge that connects our current location
            -- to a new geofence, expand the path
            CASE WHEN B.GeofenceA_ID = D.GID 
                    THEN B.GeofenceB_ID     
                    ELSE B.GeofenceA_ID END,
                D.Path + ',' 
                    + CAST(CASE WHEN B.GeofenceA_ID = D.GID 
                        THEN B.GeofenceB_ID 
                        ELSE B.GeofenceA_ID 
                        END AS VARCHAR(10))
        FROM DFS D
            JOIN [dbo].[Bridge] B
            ON B.GeofenceA_ID = D.GID OR B.GeofenceB_ID = D.GID

        -- Ensure we don't visit a geofence we've already been to
        WHERE D.Path NOT LIKE '%' + 
                            CAST(CASE WHEN B.GeofenceA_ID = D.GID   
                                THEN B.GeofenceB_ID 
                                ELSE B.GeofenceA_ID 
                                END AS VARCHAR(10))
                            + '%'
    )   
    -- Select the top path that ends at our destination
    -- Save it to a temporary table
    SELECT TOP 1 Path 
    INTO #PathTemp
    FROM DFS
    WHERE GID = @To_GeofenceID; 

    -- And move the path to its own variable
    DECLARE @Path VARCHAR(MAX);
    SELECT @Path = Path
    FROM #PathTemp 
    PRINT @Path;

END;
GO

-------------------------
-------- REPORTS --------
-------------------------

-- Trip Statistics Report (UNFINISHED)
CREATE PROCEDURE [dbo].[TripStatisticsReport]
    @FromDate DATETIME          = NULL,
    @ToDate DATETIME            = NULL,
    @ServiceType VARCHAR(50)    = NULL,
    @Location VARCHAR(50)       = NULL,
    @GroupBy VARCHAR(200)       = NULL
AS
BEGIN
    SET NOCOUNT ON;

    IF @ServiceType IS NOT NULL
    BEGIN
        SET @ServiceType = LOWER(@ServiceType)
    END

    IF @GroupBy = 'service'
    BEGIN
        SELECT ST.S_Type_Name, COUNT(*) AS TripCount
        FROM [dbo].[Trip_Segment] TS, [dbo].[Payment] P, [dbo].[Service_Type] ST
        WHERE TS.Payment_ID = P.Payment_ID AND P.ST_ID = ST.ST_ID 
            AND (@FromDate IS NULL OR @FromDate <= TS.Departure_Time) --FromDate Filter
            AND (@ToDate IS NULL OR @ToDate >= TS.Departure_Time)   --ToDate Filter
            AND (@ServiceType IS NULL OR @ServiceType = LOWER(ST.S_Type_Name))
        GROUP BY ST.S_Type_Name;
        RETURN;
    END
    
END;
GO