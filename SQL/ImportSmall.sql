INSERT INTO [dbo].[Type] (Type_ID, Type_Name) VALUES
(1, 'Admin'),
(2, 'Operator'),
(3, 'Driver'),
(4, 'Passenger'),
(5, 'Company Representative');

INSERT INTO [dbo].[User] 
(Username, Password, Email, F_Name, L_Name, Phone, Gender, B_Date, Address, Rating, PFP, Type_ID)
VALUES
-- Admin (1-5)
('contheo', 'hash00', 'contheo@mail.com', 'Con', 'Theoph', '09614073', 'M', '1981-10-08', 'Lefkosia', 4.1, 'no-pfp', 1),
('alice1', 'hash01', 'alice.smith1@mail.com', 'Alice', 'Smith', '09123456', 'F', '1990-05-12', 'Nicosia', 4.3, 'no-pfp', 1),
('bob1', 'hash02', 'bob.jones1@mail.com', 'Bob', 'Jones', '09234567', 'Other', '1985-11-23', 'Limassol', 4.0, 'no-pfp', 1),
('carol1', 'hash03', 'carol.davis1@mail.com', 'Carol', 'Davis', '09345678', 'F', '1992-08-30', 'Larnaca', 4.7, 'no-pfp', 1),
('dave1', 'hash04', 'dave.miller1@mail.com', 'Dave', 'Miller', '09456789', 'M', '1988-02-14', 'Paphos', 4.2, 'no-pfp', 1),

-- Operator (6-9)
('emma2', 'hash10', 'emma.wilson2@mail.com', 'Emma', 'Wilson', '09567890', 'F', '1991-09-10', 'Nicosia', 4.5, 'no-pfp', 2),
('frank2', 'hash11', 'frank.moore2@mail.com', 'Frank', 'Moore', '09678901', 'M', '1983-03-22', 'Limassol', 4.1, 'no-pfp', 2),
('grace2', 'hash12', 'grace.taylor2@mail.com', 'Grace', 'Taylor', '09789012', 'Other', '1987-12-05', 'Larnaca', 4.6, 'no-pfp', 2),
('henry2', 'hash13', 'henry.anderson2@mail.com', 'Henry', 'Anderson', '09890123', 'M', '1995-07-19', 'Paphos', 4.0, 'no-pfp', 2),

-- Driver (10-18)
('ian3', 'hash20', 'ian.thomas3@mail.com', 'Ian', 'Thomas', '09901234', 'M', '1989-01-15', 'Nicosia', 4.2, 'no-pfp', 3),
('julia3', 'hash21', 'julia.jackson3@mail.com', 'Julia', 'Jackson', '09112345', 'F', '1993-06-11', 'Limassol', 4.4, 'no-pfp', 3),
('kevin3', 'hash22', 'kevin.white3@mail.com', 'Kevin', 'White', '09223456', 'M', '1980-10-03', 'Larnaca', 4.1, 'no-pfp', 3),
('linda3', 'hash23', 'linda.harris3@mail.com', 'Linda', 'Harris', '09334567', 'F', '1996-03-27', 'Paphos', 4.5, 'no-pfp', 3),
('steve1', 'hash05', 'steve.johnson1@mail.com', 'Steve', 'Johnson', '09567891', 'Other', '1984-03-11', 'Nicosia', 4.3, 'no-pfp', 3),
('laura1', 'hash06', 'laura.white1@mail.com', 'Laura', 'White', '09678912', 'F', '1990-06-22', 'Limassol', 4.5, 'no-pfp', 3),
('nathan1', 'hash07', 'nathan.hall1@mail.com', 'Nathan', 'Hall', '09789023', 'M', '1987-09-15', 'Larnaca', 4.2, 'no-pfp', 3),
('sophia1', 'hash08', 'sophia.lee1@mail.com', 'Sophia', 'Lee', '09890134', 'F', '1992-12-05', 'Paphos', 4.6, 'no-pfp', 3),
('ethan1', 'hash09', 'ethan.king1@mail.com', 'Ethan', 'King', '09101245', 'M', '1985-07-19', 'Nicosia', 4.1, 'no-pfp', 3),

-- Passenger (19-22)
('mike4', 'hash30', 'mike.martin4@mail.com', 'Mike', 'Martin', '09445678', 'M', '1982-11-08', 'Nicosia', 4.3, 'no-pfp', 4),
('nina4', 'hash31', 'nina.thompson4@mail.com', 'Nina', 'Thompson', '09556789', 'F', '1994-04-17', 'Limassol', 4.7, 'no-pfp', 4),
('oliver4', 'hash32', 'oliver.garcia4@mail.com', 'Oliver', 'Garcia', '09667890', 'M', '1986-09-25', 'Larnaca', 4.0, 'no-pfp', 4),
('paula4', 'hash33', 'paula.martinez4@mail.com', 'Paula', 'Martinez', '09778901', 'Other', '1992-12-02', 'Paphos', 4.6, 'no-pfp', 4),

-- Company Representative (23-26)
('quinn5', 'hash40', 'quinn.robinson5@mail.com', 'Quinn', 'Robinson', '09889012', 'M', '1988-07-30', 'Nicosia', 4.5, 'no-pfp', 5),
('rachel5', 'hash41', 'rachel.clark5@mail.com', 'Rachel', 'Clark', '09990123', 'F', '1990-01-09', 'Limassol', 4.6, 'no-pfp', 5),
('sam5', 'hash42', 'sam.lewis5@mail.com', 'Sam', 'Lewis', '09101234', 'M', '1983-08-14', 'Larnaca', 4.1, 'no-pfp', 5),
('tina5', 'hash43', 'tina.walker5@mail.com', 'Tina', 'Walker', '09212345', 'F', '1995-05-21', 'Paphos', 4.4, 'no-pfp', 5);


INSERT INTO [dbo].[Driver_Doc] (Doc_Type, Issue_Date, Driver_ID, Approver_ID)
VALUES
('ID', '2025-11-11',                    13, NULL),
('ID', GETDATE(),                       14, NULL),
('ID', GETDATE(),                       11, NULL),
('Passport', GETDATE(),                 11, NULL),
('Residence Permit', GETDATE(),         11, NULL),
('Drivers Licence', GETDATE(),          11, NULL),
('MOT', GETDATE(),                      11, NULL),
('Criminal Record', GETDATE(),          11,NULL),
('Doctor Certificate', GETDATE(),       11, NULL),
('Psychologist Certificate', GETDATE(), 11, NULL),
('ID', GETDATE(),                       12, NULL),
('Passport', GETDATE(),                 12, NULL),
('Residence Permit', GETDATE(),         12, NULL),
('Drivers Licence', GETDATE(),          12, NULL),
('MOT', GETDATE(),                      12, NULL),
('Criminal Record', GETDATE(),          12, NULL),
('Doctor Certificate', GETDATE(),       12, NULL),
('Psychologist Certificate', GETDATE(), 12, NULL);


INSERT INTO [dbo].[Geofence] (C1_X, C1_Y, C2_X, C2_Y, C3_X, C3_Y, C4_X, C4_Y)
VALUES
-- Row 1 (bottom)
(0.000000,0.000000, 1.000000,0.000000, 1.000000,1.000000, 0.000000,1.000000),   -- 1
(1.000000,0.000000, 2.000000,0.000000, 2.000000,1.000000, 1.000000,1.000000),   -- 2
(2.000000,0.000000, 3.000000,0.000000, 3.000000,1.000000, 2.000000,1.000000),   -- 3

-- Row 2
(0.000000,1.000000, 1.000000,1.000000, 1.000000,2.000000, 0.000000,2.000000),   -- 4
(1.000000,1.000000, 2.000000,1.000000, 2.000000,2.000000, 1.000000,2.000000),   -- 5
(2.000000,1.000000, 3.000000,1.000000, 3.000000,2.000000, 2.000000,2.000000),   -- 6

-- Row 3
(0.000000,2.000000, 1.000000,2.000000, 1.000000,3.000000, 0.000000,3.000000),   -- 7
(1.000000,2.000000, 2.000000,2.000000, 2.000000,3.000000, 1.000000,3.000000),   -- 8
(2.000000,2.000000, 3.000000,2.000000, 3.000000,3.000000, 2.000000,3.000000);   -- 9


INSERT INTO [dbo].[Bridge] (Name, Coordinate_X, Coordinate_Y , GeofenceA_ID, GeofenceB_ID)
VALUES
-- Horizontal row 1
('B_1_2', 1.000000,0.500000, 1,2),
('B_2_3', 2.000000,0.500000, 2,3),

-- Horizontal row 2
('B_4_5', 1.000000,1.500000, 4,5),
('B_5_6', 2.000000,1.500000, 5,6),

-- Horizontal row 3
('B_7_8', 1.000000,2.500000, 7,8),
('B_8_9', 2.000000,2.500000, 8,9),

-- Vertical column 1
('B_1_4', 0.500000,1.000000, 1,4),
('B_4_7', 0.500000,2.000000, 4,7),

-- Vertical column 2
('B_2_5', 1.500000,1.000000, 2,5),
('B_5_8', 1.500000,2.000000, 5,8),

-- Vertical column 3
('B_3_6', 2.500000,1.000000, 3,6),
('B_6_9', 2.500000,2.000000, 6,9);


INSERT INTO [dbo].[GDPR_Request_Log] (Issue_Date, Pending, Approval, Managed_By, Requested_By)
VALUES
('2025-05-05', 'Y', 'N', 1, 2);


INSERT INTO [dbo].[Vehicle] 
(License_Plate, Frame_Number, Engine_Number, Car_Type,
 Load_Space, Number_Of_Seats, Driver_ID, Company_Rep_ID, Op_Audits, Geofence_ID)
VALUES
('PRM001', 'FR001', 'EN001', 'Sedan',     450.0, 4, 10, NULL, NULL, 4),
('PRM002', 'FR002', 'EN002', 'SUV',       600.0, 5, 11, NULL, NULL, 3),
('PRM003', 'FR003', 'EN003', 'Hatchback', 350.0, 4, 12, NULL, NULL, 2),
('PRM004', 'FR004', 'EN004', 'Sedan',     450.0, 4, 13, NULL, NULL, 7),
('PRM005', 'FR005', 'EN005', 'SUV',       650.0, 6, 14, NULL, NULL, 1),
('PRM006', 'FR006', 'EN006', 'Sedan',     450.0, 4, 15, NULL, NULL, 9),
('PRM007', 'FR007', 'EN007', 'Mini',      300.0, 4, 16, NULL, NULL, 5),
('PRM008', 'FR008', 'EN008', 'Sedan',     450.0, 4, 17, NULL, NULL, 8),
('PRM009', 'FR009', 'EN009', 'Van',       700.0, 6, 18, NULL, NULL, 6);


INSERT INTO [dbo].[Service_Type] 
(S_Type_Name, Tariff, License_Plate, Frame_Number, Engine_Number)
VALUES
('Premium', 15.00, 'PRM001', 'FR001', 'EN001'),
('Premium', 15.00, 'PRM002', 'FR002', 'EN002'),
('Premium', 15.00, 'PRM003', 'FR003', 'EN003'),
('Premium', 15.00, 'PRM004', 'FR004', 'EN004'),
('Premium', 15.00, 'PRM005', 'FR005', 'EN005'),
('Premium', 15.00, 'PRM006', 'FR006', 'EN006'),
('Premium', 15.00, 'PRM007', 'FR007', 'EN007'),
('Premium', 15.00, 'PRM008', 'FR008', 'EN008'),
('Premium', 15.00, 'PRM009', 'FR009', 'EN009');


-- INSERT INTO [dbo].[Payment] (Price, ST_ID)
-- VALUES
-- (25.50, 1),
-- (40.00, 2),
-- (15.75, 3),
-- (60.00, 4);

-- INSERT INTO [dbo].[Total_Trip] (Payment_Time, Payment_Method, User_ID, Payment_ID)
-- VALUES
-- (GETDATE(), 'Card',   7, 1),
-- (GETDATE(), 'Cash',   8, 2),
-- (GETDATE(), 'Wallet', 7, 3),
-- (GETDATE(), 'Card',   4, 4);

