------------------------------------
-------- DROP FOREIGN KEYS ---------
------------------------------------

-- 1. User
ALTER TABLE [dbo].[User] DROP CONSTRAINT IF EXISTS FK_User_Type

-- 2. GDPR
ALTER TABLE [dbo].[GDPR_Request_Log] DROP CONSTRAINT IF EXISTS FK_GDPR_User_RequestedBy
ALTER TABLE [dbo].[GDPR_Request_Log] DROP CONSTRAINT IF EXISTS FK_GDPR_User_ManagedBy

-- 3. Feedback
ALTER TABLE [dbo].[Feedback] DROP CONSTRAINT IF EXISTS FK_Feedback_About_User
ALTER TABLE [dbo].[Feedback] DROP CONSTRAINT IF EXISTS FK_Feedback_By_User
ALTER TABLE [dbo].[Feedback] DROP CONSTRAINT IF EXISTS FK_Feedback_Trip

-- 4. Type: NO Foreign Keys

-- 5. Preferences
ALTER TABLE [dbo].[Preferences] DROP CONSTRAINT IF EXISTS FK_Preferences_User

-- 6. Driver Document
ALTER TABLE [dbo].[Driver_Doc] DROP CONSTRAINT IF EXISTS FK_Driver_Doc_User_Driver
ALTER TABLE [dbo].[Driver_Doc] DROP CONSTRAINT IF EXISTS FK_Driver_Doc_User_Operator

-- 7. Vehicle Document
ALTER TABLE [dbo].[Vehicle_Doc] DROP CONSTRAINT IF EXISTS FK_Vehicle_Doc_User_Operator
ALTER TABLE [dbo].[Vehicle_Doc] DROP CONSTRAINT IF EXISTS FK_Doc_Vehicle_ID

-- 8. Vehicle Inspection
ALTER TABLE [dbo].[Vehicle_Inspection] DROP CONSTRAINT IF EXISTS FK_Vehicle_Inspection_User_Operator
ALTER TABLE [dbo].[Vehicle_Inspection] DROP CONSTRAINT IF EXISTS FK_Vehicle_Inspection_Vehicle

-- 9. Vehicle
ALTER TABLE [dbo].[Vehicle] DROP CONSTRAINT IF EXISTS FK_Vehicle_Company_Rep
ALTER TABLE [dbo].[Vehicle] DROP CONSTRAINT IF EXISTS FK_Vehicle_Driver
ALTER TABLE [dbo].[Vehicle] DROP CONSTRAINT IF EXISTS FK_Vehicle_Geofence
ALTER TABLE [dbo].[Vehicle] DROP CONSTRAINT IF EXISTS FK_Vehicle_Op_Audits

-- 10. Trip Segment
ALTER TABLE [dbo].[Trip_Segment] DROP CONSTRAINT IF EXISTS FK_Trip_Segment_Payment_ID
ALTER TABLE [dbo].[Trip_Segment] DROP CONSTRAINT IF EXISTS FK_TL_ID
ALTER TABLE [dbo].[Trip_Segment] DROP CONSTRAINT IF EXISTS FK_TT_ID

-- 11. Trip Log: No foreign key

-- 12. In App Message
ALTER TABLE [dbo].[In_App_Message] DROP CONSTRAINT IF EXISTS FK_In_App_Message_Trip_Segment

-- 13. Bridge: No foreign Keys

-- 14. Service Type
ALTER TABLE [dbo].[Service_Type] DROP CONSTRAINT IF EXISTS FK_Service_Type_Vehicle

-- 15. Total Trip
ALTER TABLE [dbo].[Total_Trip] DROP CONSTRAINT IF EXISTS FK_Total_Trip_Payment
ALTER TABLE [dbo].[Total_Trip] DROP CONSTRAINT IF EXISTS FK_Total_Trip_User

-- 16. Payment
ALTER TABLE [dbo].[Payment] DROP CONSTRAINT IF EXISTS FK_Payment_Service_Type

-- 17. Geofence: No Foreign Keys

-- 18. TotalTrip_Bridge
ALTER TABLE [dbo].[TotalTrip_Bridge] DROP CONSTRAINT IF EXISTS FK_M2M_TT_Bridge_TT_ID
ALTER TABLE [dbo].[TotalTrip_Bridge] DROP CONSTRAINT IF EXISTS FK_M2M_TT_Bridge_BID

-- 19. Bridge_Geofence
ALTER TABLE [dbo].[Bridge_Geofence] DROP CONSTRAINT IF EXISTS FK_M2M_Bridge_Geofence_BID
ALTER TABLE [dbo].[Bridge_Geofence] DROP CONSTRAINT IF EXISTS FK_M2M_Bridge_Geofence_GID

-- 20. Vehicle_TripSegment
ALTER TABLE [dbo].[Vehicle_TripSegment] DROP CONSTRAINT IF EXISTS FK_M2M_Vehicle_TS_TripID
ALTER TABLE [dbo].[Vehicle_TripSegment] DROP CONSTRAINT IF EXISTS FK_M2M_Vehicle_TS_VID



------------------------------------
----------- DROP TABLES ------------
------------------------------------
--------- In reverse order ---------

DROP TABLE IF EXISTS [dbo].[Vehicle_TripSegment]
DROP TABLE IF EXISTS [dbo].[Bridge_Geofence]
DROP TABLE IF EXISTS [dbo].[TotalTrip_Bridge]
DROP TABLE IF EXISTS [dbo].[Geofence]
DROP TABLE IF EXISTS [dbo].[Payment]
DROP TABLE IF EXISTS [dbo].[Total_Trip]
DROP TABLE IF EXISTS [dbo].[Service_Type]
DROP TABLE IF EXISTS [dbo].[Bridge]
DROP TABLE IF EXISTS [dbo].[In_App_Message]
DROP TABLE IF EXISTS [dbo].[Trip_Log]
DROP TABLE IF EXISTS [dbo].[Trip_Segment]
DROP TABLE IF EXISTS [dbo].[Vehicle]
DROP TABLE IF EXISTS [dbo].[Vehicle_Inspection]
DROP TABLE IF EXISTS [dbo].[Vehicle_Doc]
DROP TABLE IF EXISTS [dbo].[Driver_Doc]
DROP TABLE IF EXISTS [dbo].[Preferences]
DROP TABLE IF EXISTS [dbo].[Type]
DROP TABLE IF EXISTS [dbo].[Feedback]
DROP TABLE IF EXISTS [dbo].[GDPR_Request_Log]
DROP TABLE IF EXISTS [dbo].[User]



------------------------------------
--------- DROP PROCEDURES ----------
------------------------------------

IF OBJECT_ID('[dbo].[AddDriverDoc]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[AddDriverDoc];
GO

IF OBJECT_ID('[dbo].[AddUser]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[AddUser];
GO

IF OBJECT_ID('[dbo].[AddVehicleDoc]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[AddVehicleDoc];
GO

IF OBJECT_ID('[dbo].[CreatePayment]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[CreatePayment];
GO

IF OBJECT_ID('[dbo].[GetMessagesByTrip]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetMessagesByTrip];
GO

IF OBJECT_ID('[dbo].[GetPaymentForTrip]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetPaymentForTrip];
GO

IF OBJECT_ID('[dbo].[GetPaymentsByUser]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetPaymentsByUser];
GO

IF OBJECT_ID('[dbo].[GetSegmentDetails]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetSegmentDetails];
GO

IF OBJECT_ID('[dbo].[GetServiceTypeForVehicle]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetServiceTypeForVehicle];
GO

IF OBJECT_ID('[dbo].[GetTotalTripsByUser]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetTotalTripsByUser];
GO

IF OBJECT_ID('[dbo].[GetUserByUsername]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetUserByUsername];
GO

IF OBJECT_ID('[dbo].[GetServiceTypesForVehicle]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetServiceTypesForVehicle];
GO

IF OBJECT_ID('[dbo].[GetUserByID]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetUserByID];
GO

IF OBJECT_ID('[dbo].[GetVehicleByDriver]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetVehicleByDriver];
GO

IF OBJECT_ID('[dbo].[GetVehicleDocs]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetVehicleDocs];
GO

IF OBJECT_ID('[dbo].[GetVehicleInspections]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetVehicleInspections];
GO

IF OBJECT_ID('[dbo].[InsertTripSegment]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[InsertTripSegment];
GO

IF OBJECT_ID('[dbo].[InsertVehicle]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[InsertVehicle];
GO

IF OBJECT_ID('[dbo].[UpdateUser]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[UpdateUser];
GO

IF OBJECT_ID('[dbo].[CountVehicles]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[CountVehicles];
GO

IF OBJECT_ID('[dbo].[TripStatisticsReport]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[TripStatisticsReport];
GO

IF OBJECT_ID('[dbo].[GetDashboardStats]', 'P') IS NOT NULL
    DROP PROCEDURE [dbo].[GetDashboardStats];
GO









