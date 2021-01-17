
<?php
require '../config/config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$home = $conn->query("SHOW tables");
$books = $conn->query("SELECT * FROM `db_book`");
$customer = $conn->query("SELECT * FROM `db_customer`");
$employee = $conn->query("SELECT * FROM `db_employee`");
$order = $conn->query("SELECT * FROM `db_order`");
$detail = $conn->query("SELECT * FROM `db_order_detail`");
$shipper = $conn->query("SELECT * FROM `db_shipper`");
$subject = $conn->query("SELECT * FROM `db_subject`");
$supplier = $conn->query("SELECT * FROM `db_supplier`");
?>

<html>
<head>
  <meta charset="utf-8"/>
  <meta name = "viewport" content = "width=device-width,initial-scale=1">
<style>
h1 {text-align: center;}
h4 {text-align: center;}
</style>
<title>COMP6120 Final Project</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<h1>Final project</h1>
<br>
</br>

<div class = "container">
  <ul class = "nav nav-tabs" role = "tablist">
    <li class = "active">
     <a href = "#all_tables" data-toggle = "tab"> Home </a>
    </li>

     <li>
      <a href = "#book" data-toggle = "tab">Book</a>
    </li>
    <li>
      <a href = "#customer" data-toggle = "tab">Customer</a>
    </li>
    <li>
      <a href = "#employee" data-toggle = "tab">Employee</a>
    </li>
    <li>
      <a href = "#order" data-toggle = "tab">Order</a>
    </li>
    <li>
      <a href = "#orderdetail" data-toggle = "tab">Order Detail</a>
    </li>
    <li>
      <a href = "#shipper" data-toggle = "tab">Shipper</a>
    </li>
    <li>
      <a href = "#subject" data-toggle = "tab">Subject</a>
    </li>
    <li>
      <a href = "#supplier" data-toggle = "tab">Supplier</a>
    </li>
  </ul>

  <div class = "tab-content">
         <div  id = "all_tables" class = "tab-pane fade in active">
         <p><br>Welcome to Group 4's Webpage. Each tab represents a table in our database.
          Please view the contents of each table then write some queries below. The results of the query
          will be displayed as a table.</br></p>
         </div>

    <div  id = "book" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
              <th scope="col">BookID</th>
              <th scope="col">Title</th>
              <th scope="col">Price</th>
              <th scope="col">Author</th>
              <th scope="col">Quantity</th>
              <th scope="col">SupplierID</th>
              <th scope="col">SubjectID</th>
          </tr>
          </thead>

          <?php
          if ($books->num_rows > 0) {
              while ($row = $books->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" , $row["BookID"] , "</td>";
                  echo "<td>" , $row["Title"] , "</td>";
                  echo "<td>" , $row["UnitPrice"] , "</td>";
                  echo "<td>" , $row["Author"] , "</td>";
                  echo "<td>" , $row["Quantity"] , "</td>";
                  echo "<td>" , $row["SupplierID"] , "</td>";
                  echo "<td>" , $row["SubjectID"] , "</td>";
                  echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div id = "customer" class = "tab-pane fade">
          <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
            <thead>
            <tr>
                <th scope="col">CustomerID</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Phone</th>
            </tr>
            </thead>

            <?php
            if ($customer->num_rows > 0) {
                while ($row = $customer->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" , $row["CustomerID"] , "</td>";
                  echo "<td>" , $row["LastName"] , "</td>";
                  echo "<td>" , $row["FirstName"] , "</td>";
                  echo "<td>" , $row["Phone"] , "</td>";
                  echo "</tr>";
                }
            }
            ?>
          </table>
      </div>
      <div  id = "employee" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">EmployeeID</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
          </tr>
          </thead>

          <?php
          if ($employee->num_rows > 0) {
              while ($row = $employee->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["EmployeeID"] , "</td>";
                echo "<td>" , $row["LastName"] , "</td>";
                echo "<td>" , $row["FirstName"] , "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div id = "order" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer ID</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Order Date</th>
            <th scope="col">Shipped Date</th>
            <th scope="col">Shipper ID</th>
          </tr>
          </thead>

          <?php
          if ($order->num_rows > 0) {
              while ($row = $order->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["OrderID"] , "</td>";
                echo "<td>" , $row["CustomerID"] , "</td>";
                echo "<td>" , $row["EmployeeID"] , "</td>";
                echo "<td>" , $row["OrderDate"] , "</td>";
                echo "<td>" , $row["ShippedDate"] , "</td>";
                echo "<td>" , $row["ShipperID"] , "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div id = "orderdetail" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">Book ID</th>
            <th scope="col">Order ID</th>
            <th scope="col">Quantity</th>
          </tr>
          </thead>

          <?php
          if ($detail->num_rows > 0) {
              while ($row = $detail->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["BookID"] , "</td>";
                echo "<td>" , $row["OrderID"] , "</td>";
                echo "<td>" , $row["Quantity"] , "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div id = "shipper" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">Shipper ID</th>
            <th scope="col">Shipper Name</th>
          </tr>
          </thead>

          <?php
          if ($shipper->num_rows > 0) {
              while ($row = $shipper->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["ShipperID"] , "</td>";
                echo "<td>" , $row["ShipperName"] , "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div  id = "subject" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">Subject ID</th>
            <th scope="col">Category Name</th>
          </tr>
          </thead>

          <?php
          if ($subject->num_rows > 0) {
              while ($row = $subject->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["SubjectID"] , "</td>";
                echo "<td>" , $row["CategoryName"] , "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
      <div  id = "supplier" class = "tab-pane fade">
        <table  class = "table table-striped table-dark" cellspacing = 0 width = "100%">
          <thead>
          <tr>
            <th scope="col">Supplier ID</th>
            <th scope="col">Company Name</th>
            <th scope="col">Contact Last Name</th>
            <th scope="col">Contact First Name</th>
            <th scope="col">Phone</th>
          </tr>
          </thead>

          <?php
          if ($supplier->num_rows > 0) {
              while ($row = $supplier->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" , $row["SupplierID"] , "</td>";
                echo "<td>" , $row["CompanyName"] , "</td>";
                echo "<td>" , $row["ContactLastName"] , "</td>";
                echo "<td>" , $row["ContactFirstName"] , "</td>";
                echo "<td>" , $row["Phone"] . "</td>";
                echo "</tr>";
              }
          }
          ?>
        </table>
      </div>
  </div>
</div>
<br>
</br>
<form align = "center" method = "post">
  <label for = "queries">Choose a query:</label>
  <br>
  </br>
   <select id = "select" name = "select">
   <option value = "Choose one from the above!">
     List: Click here to proceed 19 queries.</option>

    <option value = "SELECT sub.CategoryName
    FROM db_book AS b, db_supplier AS sup, db_subject AS sub
    WHERE b.SupplierID = sup.SupplierID
    AND b.SubjectID = sub.SubjectID
    AND sup.CompanyName = 'supplier2';">
     1. Show the subject names of books supplied by *supplier2*.</option>

    <option value = "SELECT b.Title, b.UnitPrice
    FROM db_book AS b, db_supplier AS sup
    WHERE b.SupplierID = sup.SupplierID
    AND b.UnitPrice = (SELECT MAX(b2.UnitPrice)
    FROM db_book AS b2, db_supplier AS sup2
    WHERE b2.SupplierID = sup2.SupplierID
    AND sup2.CompanyName = 'supplier3');">
     2. Show the name and price of the most expensive book supplied by *supplier3*.</option>

    <option value = "SELECT DISTINCT b.Title
    FROM db_book AS b, db_customer AS c, db_order AS o, db_order_detail AS od
    WHERE b.BookId = od.BookID
    AND c.CustomerID = o.CustomerID
    AND o.OrderID = od.OrderID
    AND c.LastName = 'lastname1'
    AND c.FirstName = 'firstname1';">
     3. Show the unique names of all books ordered by *lastname1 firstname1*.</option>

    <option value = "SELECT b.Title FROM db_book AS b WHERE Quantity > 10;">
    4. Show the title of books which have more than 10 units in stock.</option>

    <option value = "SELECT SUM(od.Quantity*b.UnitPrice) AS BuyTotal
    FROM db_book AS b, db_customer AS c, db_order AS o, db_order_detail AS od
    WHERE b.BookId = od.BookID
    AND c.CustomerID = o.CustomerID
    AND o.OrderID = od.OrderID
    AND c.LastName = 'lastname1'
    AND c.FirstName = 'firstname1';">
     5. Show the total price *lastname1 firstname1* has paid for the books.</option>

    <option value = "SELECT c.LastName, c.FirstName
    FROM db_customer AS c JOIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON o.OrderID = od.OrderID
    JOIN db_book AS b ON od.BookID = b.BookID
    GROUP BY c.CustomerID HAVING SUM(od.Quantity*b.UnitPrice) < 80;">
        6. Show the names of the customers who have paid less than $80 in totals.</option>

    <option value = "SELECT b.Title as BookNames
    FROM db_book AS b
    JOIN db_supplier AS sup ON b.SupplierID = sup.SupplierID
    WHERE sup.CompanyName = 'supplier2';">
     7. Show the name of books supplied by *supplier2*.</option>

    <option value ="SELECT SUM(od.Quantity*b.UnitPrice) AS BuyTotal, c.FirstName, c.LastName
    FROM db_book b, db_order_detail od, db_order o, db_customer c
    WHERE od.BookID = b.BookID
    AND c.CustomerID = o.CustomerID
    AND o.OrderID = od.OrderID
    GROUP BY c.CustomerID
    ORDER BY BuyTotal DESC;">
            8. Show the total price each customer paid and their names.  List the result in descending price.</option>

    <option value = "SELECT b.Title, sh.ShipperName
    FROM db_book AS b, db_order_detail AS od, db_order AS o, db_shipper AS sh
    WHERE b.BookID = od.BookID
    AND o.OrderID = od.OrderID
    AND o.ShipperID = sh.ShipperID
    AND o.ShippedDate = '2016-08-04';">
     9. Show the names of all the books shipped on 08/04/2016 and their shippers' names.</option>

    <option value =
        "SELECT DISTINCT b.Title
        FROM db_book AS b JOIN db_order_detail AS od ON b.BookID = od.BookID
        JOIN db_order AS o ON od.OrderID = o.OrderID
        JOIN db_customer AS c ON o.CustomerID = c.CustomerID
        WHERE c.LastName = 'lastname1'
        AND c.FirstName = 'firstname1'
        AND b.Title IN (SELECT DISTINCT b2.Title FROM db_book AS b2 JOIN db_order_detail AS od2 ON b2.BookID = od2.BookID
        JOIN db_order AS o2 ON od2.OrderID = o2.OrderID
        JOIN db_customer AS c2 ON o2.CustomerID = c2.CustomerID
        WHERE c2.LastName = 'lastname4' AND c2.FirstName = 'firstname4');">
     10. Show the unique names of all the books *lastname1 firstname1* and *lastname4 firstname4* *both* ordered.</option>

    <option value = "SELECT DISTINCT b.Title
    FROM db_book b, db_employee e, db_order o, db_order_detail ord
    WHERE ord.BookID = b.BookID
    AND ord.OrderID = o.OrderID
    AND o.EmployeeID = e.EmployeeID
    AND e.FirstName = 'firstname6'
    AND LastName='lastname6';">
      11. Show the names of all the books *lastname6 firstname6* was responsible for.</option>

    <option value = "SELECT b.Title, sum(od.Quantity) AS Total
    FROM db_book b, db_order_detail od
    WHERE b.BookID = od.BookID
    GROUP BY b.Title
    ORDER BY Total ASC;">12. Show the names of all the ordered books and their total
     quantities.  List the result in ascending quantity.</option>

    <option value = "SELECT FirstName, LastName
    from (select c.FirstName as FirstName, c.LastName as LastName, SUM(od.Quantity) AS BooksOrdered
    FROM db_customer c J
    OIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON o.OrderID = od.orderID
    GROUP BY c.CustomerID HAVING BooksOrdered >= 2) as Temp;">
    13. Show the names of the customers who ordered at least 2 books.</option>

    <option value = "SELECT c.FirstName, c.LastName, b.Title
    FROM db_customer AS c
    JOIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON o.OrderID = od.OrderID
    JOIN db_book AS b ON b.BookID = od.BookID
    JOIN db_subject AS sub ON b.SubjectID = sub.SubjectID
    WHERE (sub.CategoryName = 'category3' OR sub.CategoryName = 'category4');">
    14. Show the name of the customers who have ordered at least a book in
     *category3* or *category4* and the book names.</option>

    <option value = "SELECT DISTINCT c.FirstName, c.LastName
    FROM db_customer AS c JOIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON o.OrderID = od.OrderID
    JOIN db_book AS b ON od.BookID = b.BookID
    WHERE b.Author = 'author1';">
    15. Show the name of the customer who has ordered at least one book
     written by *author1*.</option>

    <option value = "SELECT e.FirstName, e.LastName, SUM(b.UnitPrice * od.Quantity) AS PriceOfOrder
    FROM db_employee AS e
    JOIN db_order AS o ON  e.EmployeeID = o.EmployeeID
    JOIN db_order_detail AS od ON o.OrderID = od.OrderID
    JOIN db_book AS b ON od.BookID = b.BookID
    GROUP BY e.EmployeeID;">
    16. Show the name and total sale (price of orders) of each employee.</option>

    <option value = "SELECT b.Title, sum(od.Quantity) as Total
    FROM db_book as b
    JOIN db_order_detail AS od ON b.BookID = od.BookID
    JOIN db_order AS o ON od.OrderID = o.OrderID
    WHERE (o.ShippedDate is null or o.ShippedDate > '2016-08-04')
    group by b.Title;">
    17. Show the book names and their respective quantities for open
     orders (the orders which have not been shipped) at midnight 08/04/2016.</option>

    <option value = "SELECT c.FirstName, c.LastName, SUM(od.Quantity) AS TotalBooksOrdered
    FROM db_customer AS c
    JOIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON od.OrderID = o.orderID
    GROUP BY c.CustomerID
    HAVING TotalBooksOrdered > 1
    ORDER BY TotalBooksOrdered DESC;">
    18. Show the names of customers who have ordered more than 1 book and
     the corresponding quantities.  List the result in the descending quantity.</option>

    <option value = "SELECT c.FirstName, c.LastName, c.Phone as Telephone
    FROM db_customer c
    JOIN db_order AS o ON c.CustomerID = o.CustomerID
    JOIN db_order_detail AS od ON o.OrderID = od.orderID
    GROUP BY c.CustomerID
    HAVING SUM(od.Quantity) >3;">
    19. Show the names of customers who have ordered more than 3 books and
     their respective telephone numbers.</option>

  </select>
  <br>
  </br>
<textarea id = 'stmt' name = 'stmt' rows = '10' cols = '80'></textarea>
<script>
function query(q) {
  $("#stmt").val(q.target.value);
}
$("#select").on("change", query);
</script>
<button type = 'submit' name = 'submitsql'>Submit</button>
</form><br>

    <?php

    $disallowedWords = 'drop';

    if(isset($_POST['submitsql'])) {
        $sql = $_POST['stmt'];


        if(strpos(strtolower($sql), $disallowedWords) !== false){
            echo "<div class='container'>";
              echo "<div class = 'alert alert-danger alert-dismissible fade in'>";
                echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                echo "<strong>FATAL ERROR: </strong>" , die("The '$disallowedWords' function is disabled...");
              echo "</div>";
            echo "</div>";}


          $result = mysqli_query($conn, $sql);
          $rowCount = mysqli_num_rows($result);
          if (!$result) {
            echo "<div class='container'>";
              echo "<div class = 'alert alert-danger alert-dismissible fade in'>";
                echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                echo "<strong>ERROR: </strong>" , mysqli_error($conn);
              echo "</div>";
            echo "</div>";

          } else {
              if ($rowCount > 0) {
                echo "<div class = 'container'>";
                echo "<table  class = 'table table-striped table-dark' cellspacing = 0 width = 100%";
                echo "<tr>";
                echo "<thead>";
                for($i=0; $i<$rowCount; $i++) {
                    $field = mysqli_fetch_field($result);
                    echo "<th>{$field->name}</th>";
                }
                echo "</tr>";
                echo "</thead>";

                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  foreach($row as $field) {
                      echo "<td>" , $field , "</td>";
                  }
                  echo "</tr>";
                }
              } else {
                  echo "No results found.";
              }
              echo "</table";
              echo "</div";
          }
         echo"<br><br>" ;

      }

    mysqli_free_result($result);
    ?>
<?php
$conn->close();
?>

  <br>
  <br>
  <br>
  </br>
</body>
</html>
