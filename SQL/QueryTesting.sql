
-- ---------------------------------------------------------
-- -- 1. USER & AUTHENTICATION
-- ---------------------------------------------------------

-- -- Login: fetch user by username
-- SELECT * FROM [User]
-- WHERE Username = 'admin';

-- -- Fetch password hash
-- SELECT Password
-- FROM [User]
-- WHERE Username = 'admin';

-- -- Get full user info after login
-- SELECT User_ID, Username, Email, F_Name, L_Name, Type_ID
-- FROM [User]
-- WHERE User_ID = 1;

-- -- Load user preferences
-- SELECT *
-- FROM Preferences
-- WHERE User_ID = 1;


---------------------------------------------------------
-- 2. PASSENGER OPERATIONS
---------------------------------------------------------

-- List available service types (Passenger, Luxury Passenger, Light Cargo ...)
SELECT ST_ID, S_Type_Name, Tariff, License_Plate
FROM Service_Type;

-- -- Add A new Payment
-- INSERT INTO Payment
-- (Payment_ID, Price, ST_ID)
-- VALUES (2, 10.0, 1)

-- -- Create a Total Trip
-- INSERT INTO Total_Trip
-- (TT_ID, Payment_Time, Payment_Method, User_ID, Payment_ID)
-- VALUES (2, '2024-01-01 16:32:00.000', 'Cash', 4, 2);


-- -- Create a Trip Segment
-- INSERT INTO Trip_Segment
-- (Trip_ID, Distance, Drv_ID, Psg_ID, From_Location, To_Location,
--  Departure_Time, Arrival_Time, TL_ID, TT_ID, Payment_ID)
-- VALUES (2, 10.0, 3, 4, 'UCY', 'HDS', '2024-02-01 14:40:00.000', '2024-02-01 14:50:00.000', 1, 2, 2);

-- Passenger trip history
SELECT T.TT_ID, T.Payment_Time, T.Payment_Method,
       TS.From_Location, TS.To_Location,
       TS.Departure_Time, TS.Arrival_Time,
       TS.Drv_ID
FROM Total_Trip T
JOIN Trip_Segment TS ON T.TT_ID = TS.TT_ID
WHERE T.User_ID = 4
ORDER BY T.Payment_Time ASC;

-- Get detailed trip information
SELECT *
FROM Trip_Segment
WHERE Trip_ID = 2;

-- Get driver info for a trip
SELECT U.User_ID, U.F_Name, U.L_Name, U.Rating, U.Phone
FROM Trip_Segment TS
JOIN [User] U ON TS.Drv_ID = U.User_ID
WHERE TS.Trip_ID = 2;