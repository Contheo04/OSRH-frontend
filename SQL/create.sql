------------------------------------
------------- LEGEND ---------------
-- 1.  User
-- 2.  GDPR_Request_Log
-- 3.  Feedback
-- 4.  Type
-- 5.  Preferences 
-- 6.  Driver Documents
-- 7.  Vehicle Documents
-- 8.  Vehicle Inspection
-- 9.  Vehicle
-- 10. Trip Segment
-- 11. Trip Log
-- 12. In App Message
-- 13. Bridge
-- 14. Service Type
-- 15. Total Trip
-- 16. Payment 
-- 17. Geofence
-- 18. Total trip <-> Bridge
-- 19. Bridge <-> Geofence
-- 20. Vehicle <-> Trip Segment
 


------------------------------------
---------- CREATE TABLES -----------
------------------------------------

-- 1.
CREATE TABLE [dbo].[User] (
    User_ID INT IDENTITY(1,1) NOT NULL,
    Username VARCHAR(30) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(60) NOT NULL CHECK (Email LIKE '%@%.%'),
    F_Name VARCHAR(30) NOT NULL,
    L_Name VARCHAR(30) NOT NULL,
    Phone VARCHAR(25) NOT NULL,
    Gender VARCHAR(40) NOT NULL CHECK (Gender IN ('M', 'F', 'Other')),
    B_Date DATE NOT NULL,
    Address VARCHAR(40) NOT NULL,
    Rating DECIMAL(2,1) NOT NULL CHECK (Rating BETWEEN 0 AND 5),
    PFP VARCHAR(255) NOT NULL,

    -- Foreign Keys
    Type_ID INT NOT NULL,

    PRIMARY KEY (User_ID),
    UNIQUE (Username),
    UNIQUE (Email)
);

-- 2.
CREATE TABLE [dbo].[GDPR_Request_Log] (
    Request_ID INT IDENTITY(1,1) NOT NULL,
    Issue_Date DATE NOT NULL,
    Pending CHAR(1) NOT NULL CHECK (Pending IN ('Y', 'N')),
    Approval CHAR(1) NOT NULL CHECK (Approval IN ('Y', 'N')), 

    -- Foreign Keys
    Managed_By INT,
    Requested_By INT NOT NULL,

    PRIMARY KEY (Request_ID)
);

-- 3.
CREATE TABLE [dbo].[Feedback] (
    Feedback_ID INT IDENTITY(1,1) NOT NULL,
    Comments VARCHAR(250),
    Issue_Date DATE NOT NULL,
    Rating DECIMAL(2,1) NOT NULL,

    --Foreign Keys
    About_User INT NOT NULL,
    By_User INT NOT NULL,
    TT_ID INT NOT NULL,

    PRIMARY KEY (Feedback_ID)
);

-- 4.
CREATE TABLE [dbo].[Type] (
    Type_ID INT NOT NULL,
    Type_Name VARCHAR(30) NOT NULL,

    PRIMARY KEY (Type_ID)
);

-- 5.
CREATE TABLE [dbo].[Preferences] (
    Preference_ID INT IDENTITY(1,1) NOT NULL,
    Dark_Mode_On CHAR(1) NOT NULL CHECK (Dark_Mode_On IN ('Y', 'N')),
    Language VARCHAR(30) NOT NULL,
    Font_Size INT NOT NULL CHECK (Font_Size BETWEEN 8 AND 40),
    Location VARCHAR(30) NOT NULL,
    Notifications CHAR(1) NOT NULL CHECK (Notifications IN ('Y', 'N')),

    -- Foreign Key
    User_ID INT NOT NULL,

    PRIMARY KEY (Preference_ID)
);

-- 6.
CREATE TABLE [dbo].[Driver_Doc] (
    Doc_ID INT IDENTITY(1,1) NOT NULL,
    Doc_Type VARCHAR(50) NOT NULL,
    Issue_Date DATE NOT NULL,

    --Foreign Keys
    Driver_ID INT NOT NULL,
    Operator_ID INT,

    PRIMARY KEY (Doc_ID)
);

-- 7.
CREATE TABLE [dbo].[Vehicle_Doc] (
    Doc_ID INT IDENTITY(1,1) NOT NULL,
    Doc_Type VARCHAR(50) NOT NULL,
    Issue_Date DATE NOT NULL,
    Exp_Date DATE,

    -- Foreign Keys
    License_Plate VARCHAR(20) NOT NULL,
    Frame_Number VARCHAR(50) NOT NULL,
    Engine_Number VARCHAR(50) NOT NULL,
    Operator_ID INT,

    PRIMARY KEY (Doc_ID)
);

-- 8.
CREATE TABLE [dbo].[Vehicle_Inspection] (
    Insp_ID INT IDENTITY(1,1) NOT NULL,
    Result VARCHAR(20) NOT NULL CHECK (Result IN ('Pass', 'Fail')),
    Insp_Date DATE NOT NULL,
    Description VARCHAR(255),

    -- Foreign Keys
    License_Plate VARCHAR(20) NOT NULL,
    Frame_Number VARCHAR(50) NOT NULL,
    Engine_Number VARCHAR(50) NOT NULL,
    Operator_ID INT NOT NULL,

    PRIMARY KEY (Insp_ID)
);

-- 9.
CREATE TABLE [dbo].[Vehicle] (
    License_Plate VARCHAR(20) NOT NULL,
    Frame_Number VARCHAR(50) NOT NULL,
    Engine_Number VARCHAR(50) NOT NULL,

    Car_Type VARCHAR(50) NOT NULL,
    Load_Space FLOAT NOT NULL,
    Number_Of_Seats INT NOT NULL,

    -- Foreign Keys
    Driver_ID INT,
    Company_Rep_ID INT,
    Op_Audits INT,
    Geofence_ID INT NOT NULL,

    PRIMARY KEY (License_Plate, Frame_Number, Engine_Number)
);

-- 10.
CREATE TABLE [dbo].[Trip_Segment] (
    Trip_ID INT IDENTITY(1,1) NOT NULL,
    Distance FLOAT NOT NULL,
    Drv_ID INT NOT NULL, -- Duplicates for convenience
    Psg_ID INT NOT NULL,
    -- From_Location VARCHAR(50) NOT NULL,
    -- To_Location VARCHAR(50) NOT NULL,
    From_Location_X DECIMAL(9,6) NOT NULL,
    From_Location_Y DECIMAL(9,6) NOT NULL,
    To_Location_X DECIMAL(9,6) NOT NULL,
    To_Location_Y DECIMAL(9,6) NOT NULL,
    Departure_Time DATETIME NOT NULL,
    Arrival_Time DATETIME NOT NULL,

    -- Foreign Keys
    TL_ID INT NOT NULL,
    TT_ID INT NOT NULL,
    Payment_ID INT NOT NULL,

    PRIMARY KEY (Trip_ID)
);

-- 11.
CREATE TABLE [dbo].[Trip_Log] (
    TL_ID INT IDENTITY(1,1) NOT NULL,
    PRIMARY KEY (TL_ID)
);

-- 12.
CREATE TABLE [dbo].[In_App_Message] (
    Session_ID INT IDENTITY(1,1) NOT NULL,
    Chat_Log VARCHAR(1000) NOT NULL,

    -- Foreign Keys
    Trip_ID INT NOT NULL,

    PRIMARY KEY (Session_ID)
);

-- 13.
CREATE TABLE [dbo].[Bridge] (
    Bridge_ID INT IDENTITY(1,1) NOT NULL,
    Name VARCHAR(50) NOT NULL,
    Coordinate_X FLOAT NOT NULL,
    Coordinate_Y FLOAT NOT NULL,
    
    GeofenceA_ID INT NOT NULL,
    GeofenceB_ID INT NOT NULL

    PRIMARY KEY (Bridge_ID)
);

-- 14.
CREATE TABLE [dbo].[Service_Type] (
    ST_ID INT IDENTITY(1,1) NOT NULL,
    S_Type_Name VARCHAR(50) NOT NULL,
    Tariff FLOAT NOT NULL,

    -- Foreign Keys
    License_Plate VARCHAR(20) NOT NULL,
    Frame_Number VARCHAR(50) NOT NULL,
    Engine_Number VARCHAR(50) NOT NULL,

    PRIMARY KEY (ST_ID)
);

-- 15.
CREATE TABLE [dbo].[Total_Trip] (
    TT_ID INT IDENTITY(1,1) NOT NULL,
    Payment_Time DATETIME NOT NULL,
    Payment_Method VARCHAR(20) NOT NULL,

    -- Foreign Keys
    User_ID INT NOT NULL,
    Payment_ID INT NOT NULL,

    PRIMARY KEY (TT_ID)
);

-- 16.
CREATE TABLE [dbo].[Payment] (
    Payment_ID INT IDENTITY(1,1) NOT NULL,
    Price FLOAT NOT NULL CHECK (Price >= 0),

    -- Foreign Keys
    ST_ID INT NOT NULL,

    PRIMARY KEY (Payment_ID)
);

-- 17.
CREATE TABLE [dbo].[Geofence] (
    Geofence_ID INT IDENTITY(1,1) NOT NULL,

    --Bottom left corner
    C1_X DECIMAL(9,6) NOT NULL,
    C1_Y DECIMAL(9,6) NOT NULL,

    --Bottom right corner
    C2_X DECIMAL(9,6) NOT NULL,
    C2_Y DECIMAL(9,6) NOT NULL,

    --Top right corner
    C3_X DECIMAL(9,6) NOT NULL,
    C3_Y DECIMAL(9,6) NOT NULL,

    --Top left corner
    C4_X DECIMAL(9,6) NOT NULL,
    C4_Y DECIMAL(9,6) NOT NULL,

    PRIMARY KEY (Geofence_ID)
);

---- Many To Many Tables
-- 18.
CREATE TABLE [dbo].[TotalTrip_Bridge] (

    -- Foreign Keys
    TT_ID INT NOT NULL,
    Bridge_ID INT NOT NULL,

    PRIMARY KEY (TT_ID, Bridge_ID)
);

-- 19.
CREATE TABLE [dbo].[Bridge_Geofence] (

    -- Foreign Keys
    Bridge_ID INT NOT NULL,
    Geofence_ID INT NOT NULL,

    PRIMARY KEY (Bridge_ID, Geofence_ID)
);

-- 20.
CREATE TABLE [dbo].[Vehicle_TripSegment] (

    -- Foreign Keys
    License_Plate VARCHAR(20) NOT NULL,
    Frame_Number VARCHAR(50) NOT NULL,
    Engine_Number VARCHAR(50) NOT NULL,
    Trip_ID INT NOT NULL,

    PRIMARY KEY (License_Plate, Frame_Number, Engine_Number, Trip_ID)
);


------------------------------------
---------- ALTER TABLES ------------
------------------------------------

---- 1. User Foreign Keys
-- User -> isOf -> Type
ALTER TABLE [dbo].[User]
ADD CONSTRAINT FK_User_Type
    FOREIGN KEY (Type_ID) REFERENCES [dbo].[Type](Type_ID);

---- 2. GDPR Request Log Foreign Keys
-- GDPR -> Requested By -> User (Passenger)
ALTER TABLE [dbo].[GDPR_Request_Log]
ADD CONSTRAINT FK_GDPR_User_RequestedBy
    FOREIGN KEY (Requested_By) REFERENCES [dbo].[User](User_ID);

-- GDPR -> Managed By -> User (Admin)
ALTER TABLE [dbo].[GDPR_Request_Log]
ADD CONSTRAINT FK_GDPR_User_ManagedBy
    FOREIGN KEY (Managed_By) REFERENCES [dbo].[User](User_ID);

---- 3. Feedback Foreign Keys
-- Feedback -> About -> User (Driver/Company Representative)
ALTER TABLE [dbo].[Feedback]
ADD CONSTRAINT FK_Feedback_About_User
    FOREIGN KEY (About_User) REFERENCES [dbo].[User](User_ID);

-- Feedback -> By -> User
ALTER TABLE [dbo].[Feedback]
ADD CONSTRAINT FK_Feedback_By_User
    FOREIGN KEY (By_User) REFERENCES [dbo].[User](User_ID);

-- Feedback <- Is Given <- Trip Segment
ALTER TABLE [dbo].[Feedback]
ADD CONSTRAINT FK_Feedback_Trip
    FOREIGN KEY (TT_ID) REFERENCES [dbo].[Total_Trip](TT_ID);

---- 4. Type: No Foreign Keys

---- 5. Preferences Foreign Keys
-- Preferences <- Prefers <- User
ALTER TABLE [dbo].[Preferences]
ADD CONSTRAINT FK_Preferences_User
    FOREIGN KEY (User_ID) REFERENCES [dbo].[User](User_ID);

---- 6. Driver Doc Foreign Keys
-- Driver Doc <- Provides <- User (Driver)
ALTER TABLE [dbo].[Driver_Doc]
ADD CONSTRAINT FK_Driver_Doc_User_Driver
    FOREIGN KEY (Driver_ID) REFERENCES [dbo].[User](User_ID) ON DELETE CASCADE;

-- Driver Doc <- Checks <- User (Operator)
ALTER TABLE [dbo].[Driver_Doc]
ADD CONSTRAINT FK_Driver_Doc_User_Operator
    FOREIGN KEY (Operator_ID) REFERENCES [dbo].[User](User_ID);

---- 7. Vehicle Doc Foreign Keys
-- Vehicle Doc <- Provides <- Vehicle
ALTER TABLE [dbo].[Vehicle_Doc]
ADD CONSTRAINT FK_Doc_Vehicle_ID
    FOREIGN KEY (License_Plate, Frame_Number, Engine_Number)
    REFERENCES [dbo].[Vehicle](License_Plate, Frame_Number, Engine_Number) ON DELETE CASCADE; 

-- Vehicle Doc <- Checks <- User (Operator)
ALTER TABLE [dbo].[Vehicle_Doc]
ADD CONSTRAINT FK_Vehicle_Doc_User_Operator
    FOREIGN KEY (Operator_ID) REFERENCES [dbo].[User](USER_ID);

---- 8. Vehicle Inspection Foreign Keys
--Vehicle Inspection <- Operator Performs <- User
ALTER TABLE [dbo].[Vehicle_Inspection]
ADD CONSTRAINT FK_Vehicle_Inspection_User_Operator
    FOREIGN KEY (Operator_ID) REFERENCES [dbo].[User](User_ID);

-- Vehicle Inspection <- Undergoes <- Vehicle
ALTER TABLE [dbo].[Vehicle_Inspection]
ADD CONSTRAINT FK_Vehicle_Inspection_Vehicle
    FOREIGN KEY (License_Plate, Frame_Number, Engine_Number)
    REFERENCES [dbo].[Vehicle](License_Plate, Frame_Number, Engine_Number) ON DELETE CASCADE;

---- 9. Vehicle Foreign Keys
-- Vehicle <- Owns <- User (Driver)
ALTER TABLE [dbo].[vehicle] 
ADD CONSTRAINT FK_Vehicle_Driver
    FOREIGN KEY (Driver_ID) REFERENCES [dbo].[User](User_ID);

-- Vehicle <- In_Charge_Of <- User (Company Representative)
ALTER TABLE [dbo].[vehicle] 
ADD CONSTRAINT FK_Vehicle_Company_Rep
    FOREIGN KEY (Company_Rep_ID) REFERENCES [dbo].[User](User_ID);

-- Vehicle <- Op_Audits <- User (Operator)
ALTER TABLE [dbo].[vehicle] 
ADD CONSTRAINT FK_Vehicle_Op_Audits
    FOREIGN KEY (Op_Audits) REFERENCES [dbo].[User](User_ID);

-- Vehicle -> Moves_In -> Geofence
ALTER TABLE [dbo].[vehicle] 
ADD CONSTRAINT FK_Vehicle_Geofence
    FOREIGN KEY (Geofence_ID) REFERENCES [dbo].[Geofence](Geofence_ID);

---- 10. Trip Segment Foreign Keys
-- Trip Segment -> Archived In -> Trip Log
ALTER TABLE [dbo].[Trip_Segment]
ADD CONSTRAINT FK_TL_ID
    FOREIGN KEY (TL_ID) REFERENCES [dbo].[Trip_Log](TL_ID);

-- Trip Segment -> Composes -> Total Trip
ALTER TABLE [dbo].[Trip_Segment]
ADD CONSTRAINT FK_TT_ID
    FOREIGN KEY (TT_ID) REFERENCES [dbo].[Total_Trip](TT_ID) ON DELETE CASCADE;

-- Trip Segment -> Includes -> Payment
ALTER TABLE [dbo].[Trip_Segment]
ADD CONSTRAINT FK_Trip_Segment_Payment_ID
    FOREIGN KEY (Payment_ID) REFERENCES [dbo].[Payment](Payment_ID);

---- 11. Trip Log: No Foreign Keys

---- 12. In App Message
-- In App Message <- Has <- Trip Segment
ALTER TABLE [dbo].[In_App_Message]
ADD CONSTRAINT FK_In_App_Message_Trip_Segment
    FOREIGN KEY (Trip_ID) REFERENCES [dbo].[Trip_Segment](Trip_ID)

---- 13. Bridge: No Foreign Keys (Only Many to Many, see 18 & 19)

---- 14. Service Type Foreign Keys
-- Service Type <- Offers <- Vehicle
ALTER TABLE [dbo].[Service_Type]
ADD CONSTRAINT FK_Service_Type_Vehicle
    FOREIGN KEY (License_Plate, Frame_Number, Engine_Number)
    REFERENCES [dbo].[Vehicle](License_Plate, Frame_Number, Engine_Number);

---- 15. Total Trip Foreign Keys
-- Total Trip <- Requests <- User
ALTER TABLE [dbo].[Total_Trip]
ADD CONSTRAINT FK_Total_Trip_User
    FOREIGN KEY (User_ID) REFERENCES [dbo].[User](User_ID);

-- Total Trip -> Includes -> Payment
ALTER TABLE [dbo].[Total_Trip]
ADD CONSTRAINT FK_Total_Trip_Payment
    FOREIGN KEY (Payment_ID) REFERENCES [dbo].[Payment](Payment_ID);

---- 16. Payment Foreign Keys
-- Payment <- Determines <- Service Type
ALTER TABLE [dbo].[Payment]
ADD CONSTRAINT FK_Payment_Service_Type
    FOREIGN KEY (ST_ID) REFERENCES [dbo].[Service_Type](ST_ID);

---- 17. Geofence: No Foreign Keys (Only many to many, see 19)

---- 18. TotalTrip_Bridge Foreign Keys
-- Total Trip <- this -> Bridge
ALTER TABLE [dbo].[TotalTrip_Bridge]
ADD CONSTRAINT FK_M2M_TT_Bridge_TT_ID
    FOREIGN KEY (TT_ID) REFERENCES [dbo].[Total_Trip](TT_ID);

ALTER TABLE [dbo].[TotalTrip_Bridge]
ADD CONSTRAINT FK_M2M_TT_Bridge_BID
    FOREIGN KEY (Bridge_ID) REFERENCES [dbo].[Bridge](Bridge_ID);

---- 19. Bridge_Geofence Foreign Keys
-- Bridge <- this -> Geofence
ALTER TABLE [dbo].[Bridge_Geofence]
ADD CONSTRAINT FK_M2M_Bridge_Geofence_BID
    FOREIGN KEY (Bridge_ID) REFERENCES [dbo].[Bridge](Bridge_ID);

ALTER TABLE [dbo].[Bridge_Geofence]
ADD CONSTRAINT FK_M2M_Bridge_Geofence_GID
    FOREIGN KEY (Geofence_ID) REFERENCES [dbo].[Geofence](Geofence_ID);

---- 20. Vehicle_TripSegment Foreign Keys
-- Vehicle <- this -> Trip Segment  
ALTER TABLE [dbo].[Vehicle_TripSegment]
ADD CONSTRAINT FK_M2M_Vehicle_TS_VID
    FOREIGN KEY (License_Plate, Frame_Number, Engine_Number)
    REFERENCES [dbo].[Vehicle](License_Plate, Frame_Number, Engine_Number);

ALTER TABLE [dbo].[Vehicle_TripSegment]
ADD CONSTRAINT FK_M2M_Vehicle_TS_TripID
    FOREIGN KEY (Trip_ID) REFERENCES [dbo].[Trip_Segment](Trip_ID);

----------------------------------<< EOF >>----------------------------------