<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Select your Room</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1> Select your Rooms </h1>
  <form action="selectRoom()" method="post">
    <p> StartDate of your stay </p>
    <p> EndDate of your stay </p>
    <select name="numrooms" required>
      <option selected disabled> Number of Rooms * </option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
     <option value="5">5</option>
    </select>
    <div id = "room">
      <!-- loop numroom types and display the select option below for each room -->
      <p> Room 1 </p>
      <select name="room1" required>
        <option selected disabled> Type of Room * </option>
        <option value="Presidential">Presidential Suite</option>
        <option value="Deluxe">Deluxe Suite</option>
        <option value="Suite">Suite</option>
        <option value="Conference">Conference Room</option>
        <option value="Ballroom">Ball Room</option>
      </select>
    </div>
    <input type = "checkbox" name="seasonaldiscount" value="yes"> Look for Seasonal Discount(s) </input>
    <input type = "submit" value="Book your rooms">
  </form>
</body>
</html>
