
------------------------------------
--------- CREATE INDEXES -----------
------------------------------------

-- 1. User 
CREATE INDEX IDX_User_TypeID ON [dbo].[User](Type_ID);

    -- Index by Username
CREATE INDEX IDC_User_Username ON [dbo].[User](Username);

-- 2. GDPR 
CREATE INDEX IDX_GDPR_RequestedBy ON [dbo].[GDPR_Request_Log](Requested_By);
CREATE INDEX IDX_GDPR_ManagedBy ON [dbo].[GDPR_Request_Log](Managed_By);

-- 3. Feedback
CREATE INDEX IDX_Feedback_AboutUser ON [dbo].[Feedback](About_User);
CREATE INDEX IDX_Feedback_ByUser ON [dbo].[Feedback](By_User);
CREATE INDEX IDX_Feedback_TT_ID ON [dbo].[Feedback](TT_ID);

-- 4. Type --

-- 5. Preferences
CREATE INDEX IDX_Preferences_UserID ON [dbo].[Preferences](User_ID);

-- 6. Driver Doc
CREATE INDEX IDX_DriverDoc_DriverID ON [dbo].[Driver_Doc](Driver_ID);
CREATE INDEX IDX_DriverDoc_OperatorID ON [dbo].[Driver_Doc](Operator_ID);


-- 7. Vehicle Doc
CREATE INDEX IDX_VehicleDoc_VehicleID
    ON [dbo].[Vehicle_Doc](License_Plate, Frame_Number, Engine_Number);

CREATE INDEX IDX_VehicleDoc_Operator_ID ON [dbo].[Vehicle_Doc](Operator_ID);

-- 8. Vehicle Inspection
CREATE INDEX IDX_VehicleInspection_VehicleID 
ON [dbo].[Vehicle_Inspection](License_Plate, Frame_Number, Engine_Number);

CREATE INDEX IDX_VehicleInspection_OperatorID
    ON [dbo].[Vehicle_Inspection](Operator_ID);

-- 9. Vehicle 
CREATE INDEX IDX_Vehicle_DriverID ON [dbo].[Vehicle](Driver_ID);
CREATE INDEX IDX_Vehicle_CompanyRepID ON [dbo].[Vehicle](Company_Rep_ID);
CREATE INDEX IDX_Vehicle_OpAudits ON [dbo].[Vehicle](Op_Audits);
CREATE INDEX IDX_Vehicle_GeofenceID ON [dbo].[Vehicle](Geofence_ID);

-- 10. Trip Segment
CREATE INDEX IDX_TripSegment_TL_ID ON [dbo].[Trip_Segment](TL_ID);
CREATE INDEX IDX_TripSegment_TT_ID ON [dbo].[Trip_Segment](TT_ID);
CREATE INDEX IDX_TripSegment_PaymentID ON [dbo].[Trip_Segment](Payment_ID);

    --Index by Driver ID and Passenger ID
CREATE INDEX IDX_TripSegment_DriverID ON [dbo].[Trip_Segment](Drv_ID);
CREATE INDEX IDX_TripSegment_PassengerID ON [dbo].[Trip_Segment](Psg_ID);

-- 11. --

-- 12. In App Message
CREATE INDEX IDX_InAppMessage_TripID ON [dbo].[In_App_Message](Trip_ID);

-- 13. --

-- 14. Service Type
CREATE INDEX IDX_Service_Type_VehicleID 
    ON [dbo].[Service_Type](License_Plate, Frame_Number, Engine_Number);

-- 15. Total Trip
CREATE INDEX IDX_TotalTrip_UserID ON [dbo].[Total_Trip](User_ID);
CREATE INDEX IDX_TotalTrip_PaymentID ON [dbo].[Total_Trip](Payment_ID);

-- also add 
CREATE INDEX IDX_TotalTrip_User_PaymentTime ON [dbo].[Total_Trip](User_Id, Payment_Time);

-- 16. Payment
CREATE INDEX IDX_Payment_ST_ID ON [dbo].[Payment](ST_ID);

-- 17. --

-- 18. --

-- 19. --

-- 20. --



