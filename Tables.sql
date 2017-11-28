Create Table Room (
  RoomNo INTEGER PRIMARY KEY,
  Type VARCHAR(35),
  Price INTEGER,
  Availability BOOLEAN,
  CHECK TYPE in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room')
);

Create Table Group_Packages (
  Type VARCHAR(35),
  Num INTEGER,
  Discount INTEGER,
  CONSTRAINT PKP_GP PRIMARY KEY (Type, Num),
  CHECK TYPE in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room')
);

Create Table Seasonal_Discount (
  Type VARCHAR(35),
  StartDate DATE,
  EndDate DATE,
  Discount INTEGER,
  CONSTRAINT PK_SD PRIMARY KEY (Type, StartDate),
  CHECK TYPE in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room')
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
  CustName VARCHAR(35),
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
  EmpName Varchar(35),
  DeptID INTEGER,
  Salary INTEGER
);

Create Table Department (
  DeptID INTEGER PRIMARY KEY,
  DeptName VARCHAR(35),
  PhoneNo INTEGER
);

Create Table Inventory(
  PartID INTEGER PRIMARY KEY,
  PartName VARCHAR(35),
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
