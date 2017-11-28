CREATE OR REPLACE Procedure makeReservation (roomNoIN IN INTEGER,
                                              custIDIN IN INTEGER,
                                              CreditCardNoIN IN INTEGER,
                                              checkInDateIN IN DATE,
                                              checkInTimeIN IN TIME,
                                              checkOutDateIN IN DATE,
                                              checkOutTimeIN IN TIME)
DECLARE
  rmCheck INTEGER := 0;
  custCheck INTEGER := 0;
BEGIN
  Select RoomNo into rmCheck FROM Room where roomNoIN = roomNo;
  Select CustID into custCheck FROM Customer where custIDIN = custID;

  IF Price IS NOT NULL
  THEN
    IF custCheck IS NOT NULL
      THEN
        UPDATE Room SET Availability = 0 where roomNo = rmCheck;
        INSERT INTO Availibility_Calendar VALUES (roomNoIN, custIDIN, checkInDateIN, checkInTimeIN, checkOutDateIN, checkOutTimeIN);
    END IF
  END IF
END;
/
Show Errors;
