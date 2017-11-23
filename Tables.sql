Create Table Room (
  RoomNo INTEGER PRIMARY KEY,
  Type VARCHAR,
  Price INTEGER,
  Availability BOOLEAN
);

Create Table Group_Packages (
  Type VARCHAR,
  Num INTEGER,
  Discount INTEGER,
  CONSTRAINT PKP_GP PRIMARY KEY (Type, Num)
);

Create Table Seasonal_Discount (
  Type VARCHAR,
  StartDate DATE,
  EndDate DATE,
  Discount INTEGER,
  CONSTRAINT PK_SD PRIMARY KEY (Type, StartDate)
);

Create Table Availibility_Calendar (
  RoomNo INTEGER,
  CustID INTEGER,
  CheckInDate DATE,
  CheckInTime INTEGER,
  CheckOutDate Date,
  CheckOutTime INTEGER,
  CONSTRAINT PK_AC PRIMARY KEY (RoomNo, CheckOutDate)
);

Create Table Customer (
  CustID INTEGER PRIMARY KEY,
  CustName VARCHAR,
  CreditCardNo INTEGER
);

Create Table Charges (
  CustID INTEGER PRIMARY KEY,
  RoomNo INTEGER,
  TotalCost INTEGER,
);

Create Table Rewards (
  CustID INTEGER PRIMARY KEY,
  Points INTEGER,
  Tier INTEGER
);

Create Table Employees (
  EmpID INTEGER PRIMARY KEY,
  EmpName Varchar,
  DeptID INTEGER,
  Salary INTEGER
);

Create Table Department (
  DeptID INTEGER PRIMARY KEY,
  DeptName VARCHAR,
  PhoneNo INTEGER
);

Create Table Inventory(
  PartID INTEGER PRIMARY KEY,
  PartName VARCHAR,
  Qty INTEGER,
  MinQty INTEGER,
  Price INTEGER,
  DeptID INTEGER,
  Date_Checked DATE
);

Needed_Parts(
  PartID INTEGER PRIMARY KEY,
  Qty INTEGER
);
