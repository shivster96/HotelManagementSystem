--Simple add room function. I kept availability as an input because hotels may upgrade to our system after already having....
--people in some of their rooms. Therefore it is useful to let them mark as occupied during the room creation process.
CREATE OR REPLACE PROCEDURE createRoom (roomNoIN IN INTEGER, typeIN IN VARCHAR, priceIN IN INTEGER, AvailabilityIN IN BOOLEAN)
IS
BEGIN
  INSERT INTO Room VALUES (roomNoIn, typeIN, PriceIN, AvailabilityIN);
END;
/
show errors;

--Amit
