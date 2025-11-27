
-- TEST 1
-- EXEC [dbo].[InsertVehicle]
--     @User_ID = 13, -- User inserting their vehicle

--     @License_Plate = 'LCP125',
--     @Frame_Number  = 'FRN125',
--     @Engine_Number  = 'ENG125',
--     @Car_Type = 'Corola',
--     @Load_Space = 3.4,
--     @Number_Of_Seats = 2,
--     @Geofence_ID =2;

-- SELECT * FROM [dbo].[Vehicle]


-- TEST 2
-- EXEC [dbo].[AddDriverDoc]
--     @Doc_Type = 'ID',
--     @Driver_ID = 2,
--     @Issue_Date = '2025-4-4';

-- SELECT * FROM [dbo].[Driver_Doc]

-- TEST 3
-- EXEC [dbo].[AddUser]
--     @Username = 'Gribs',
--     @Password = 'hashgrib',
--     @Email = 'grib@mail.com',
--     @F_Name = 'gribby',
--     @L_Name = 'gribs',
--     @Phone = '77777777',
--     @Gender = 'M',
--     @B_Date = '2004-4-22',
--     @Address = 'The Ocean',
--     @Type_ID = 1;

-- SELECT * FROM [dbo].[User] WHERE Username = 'Gribs'

-- TEST 4
-- EXEC [dbo].[AddVehicleDoc]
--     @Doc_Type = 'MOT',
--     @Issue_Date = '2025-4-4',
--     @Exp_Date = '2030-4-4',
--     @License_Plate = 'LCP125',
--     @Frame_Number = 'FRN125',
--     @Engine_Number = 'ENG125';

-- SELECT * FROM [dbo].[Vehicle_Doc]

-- TEST 5
-- EXEC [dbo].[CountVehicles];

-- TEST 6
-- EXEC [dbo].[UpdateUser]
--     @User_ID = 856 ,
--     @Username = 'NewGrib',
--     @Password  = NULL,
--     @Email = NULL,
--     @F_Name  = NULL,
--     @L_Name = NULL,
--     @Phone = NULL,
--     @Gender = 'F',
--     @B_Date = NULL,
--     @Address = NULL,
--     @PFP = NULL;

-- SELECT TOP 1 * FROM [dbo].[User] ORDER BY User_ID DESC

-- TEST 7 
-- EXEC [dbo].[InsertTripSegment]
--     @Distance = 1.0,
--     @Drv_ID = 2,
--     @Psg_ID = 3,
--     @From_Location = 'Tembria',
--     @To_Location = 'Kojinohorka',
--     @Departure_Time = '2025-5-5 12:12:12',
--     @Arrival_Time = '2025-5-5 14:12:12',

--     @TT_ID = NULL, --had to temprarily replcae these in CREATE
--     @Payment_ID = NULL;

-- SELECT * FROM [dbo].[Trip_Segment]
-- SELECT * FROM [dbo].[Trip_Log]







------- What even is this
-- Sample Trip_Segment data
-- Example: Insert Trip Segments via stored procedure

-- EXEC [dbo].[InsertTripSegment] @Distance = 10.5,@Drv_ID = 1, @Psg_ID = 2,@From_Location = 'Downtown',@To_Location = 'Airport',@Departure_Time = '2025-11-20 08:00:00',@Arrival_Time = '2025-11-20 08:25:00',@TT_ID = NULL,@Payment_ID = NULL;
-- EXEC [dbo].[InsertTripSegment] @Distance = 5.2,@Drv_ID = 1,@Psg_ID = 2,@From_Location = 'Airport',@To_Location = 'Hotel', @Departure_Time = '2025-11-20 09:00:00',@Arrival_Time = '2025-11-20 09:15:00',@TT_ID = NULL,@Payment_ID = NULL;
-- EXEC [dbo].[InsertTripSegment] @Distance = 7.8,@Drv_ID = 1,@Psg_ID = 2,@From_Location = 'Hotel',@To_Location = 'Museum',@Departure_Time = '2025-11-21 10:00:00', @Arrival_Time = '2025-11-21 10:20:00',@TT_ID = NULL,@Payment_ID = NULL;
-- EXEC [dbo].[InsertTripSegment] @Distance = 12.3,@Drv_ID = 2,@Psg_ID = 1,@From_Location = 'Station',@To_Location = 'Downtown',@Departure_Time = '2025-11-21 11:00:00',@Arrival_Time = '2025-11-21 11:30:00',@TT_ID = NULL,@Payment_ID = NULL;
-- EXEC [dbo].[InsertTripSegment] @Distance = 8.5,@Drv_ID = 2, @Psg_ID = 1,@From_Location = 'Downtown',@To_Location = 'University',@Departure_Time = '2025-11-22 14:00:00',@Arrival_Time = '2025-11-22 14:25:00', @TT_ID = NULL,@Payment_ID = NULL;
-- EXEC [dbo].[InsertTripSegment] @Distance = 3.0,@Drv_ID = 1,@Psg_ID = 2,@From_Location = 'Museum',@To_Location = 'Café',@Departure_Time = '2025-11-22 15:00:00',@Arrival_Time = '2025-11-22 15:10:00',@TT_ID = NULL,@Payment_ID = NULL;

-- SELECT * FROM Trip_Segment

-- EXEC [dbo].[TripStatisticsReport]
--     @GroupBy = 'service';

EXEC [dbo].[NewTrip]
    @PassengerID = 3,
    @Desired_Service_Type = "Premium",
    @From_Location_X = 2.5,
    @From_Location_Y = 2.5,
    @To_Location_X = 0.5,
    @To_Location_Y = 1.5,
    @Payment_Method = "Card";


    -------------------------
    -- |   7  |  8   |  9   |
    -------------------------
    -- |   4  |  5   |  6   |
    -------------------------
    -- |  1   |  2   |   3  |
    -------------------------