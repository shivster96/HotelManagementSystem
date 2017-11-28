--returns the discount. Returned value is (-)1 if discount is null
Create or Replace Function checkGroupDiscount (typeIN IN VARCHAR, numIN IN INTEGER)
return INTEGER IS
  retVal INTEGER := 0;
Begin
  Select Discount INTO retVal From Group_Packages where type = typeIN and num = numIN;

  IF retVal <> NULL
  THEN
    Return retVal;
  ELSE
    retVal := -1;
    Return retVal;
  END IF;
END;
/
show errors;

--Amit


--Same as above but for SeasonalDiscounts
Create or Replace Function checkSeasonalDiscount (typeIN IN VARCHAR, checkInDate IN DATE)
return INTEGER IS
  retVal INTEGER := 0;
Begin

  Select Discount INTO retVal From Seasonal_Discount where type = typeIN and checkInDate >= startDate and checkInDate <= to endDate;
  IF retVal <> NULL
  THEN
    Return retVal;
  ELSE
    retVal := -1;
    Return retVal;
  END IF;
END;
/
show errors;
