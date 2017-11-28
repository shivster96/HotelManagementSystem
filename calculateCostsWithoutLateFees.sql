CREATE OR REPLACE FUNCTION calculateRoomCosts (stayLength IN INTEGER, typeIN IN VARCHAR, numIN IN NUMBER, checkInDateIN IN DATE)
RETURN NUMBER IS
  retCost NUMBER (100000000000000, 2);
DECLARE
  GD NUMBER := 0;
  SD NUMBER := 0;
  initialCost NUMBER := 0;
  roomCost NUMBER := 0;
BEGIN
  GD := 1-(checkGroupDiscount(typeIN, numIN) / 100);
  SD := 1-(checkSeasonalDiscount(typeIN, checkInDateIN) / 100);
  Select Distinct price into roomCost from Room where type = typeIN;
  initialCost := roomCost * stayLength;
  IF GD <= SD
  THEN
    retCost := initialCost * GD;
    retCost := retCost * SD;
  ELSE
    retCost := initialCost * SD;
    retCost := retCost * GD;
  END IF;
END;
/
Show Errors;
