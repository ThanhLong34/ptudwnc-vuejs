<?php
//? ====================
//? IMPORTS
//? ====================
require("../../core/config.php");
require("../../core/connect_db.php");
require("../../classes/ResponseAPI.php");
require("../../helpers/functions.php");


//? ====================
//? HEADERS
//? ====================
header("Access-Control-Allow-Origin: " . ACCESS_CONTROL_ALLOW_ORIGIN);
header("Access-Control-Allow-Headers: " . ACCESS_CONTROL_ALLOW_HEADERS);
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");


//? ====================
//? CHECK PERMISSTION
//? ====================
$functionName = "GetProductList";
if (!checkPermissionFunction($functionName)) exit;


//? ====================
//? PARAMETERS & PAYLOAD
//? ====================
$tableName = "product";

$limit = $_GET["limit"] ?? ""; // int, limit = "", hoặc không có payload để lấy tất cả
$offset = $_GET["offset"] ?? ""; // int
$searchType = trim($_GET["searchType"] ?? ""); // string
$searchValue = trim($_GET["searchValue"] ?? ""); // string
$fillType = trim($_GET["fillType"] ?? ""); // string
$fillValue = trim($_GET["fillValue"] ?? ""); // string
$orderby = trim($_GET["orderby"] ?? "id"); // string
$reverse = ($_GET["reverse"] ?? "false") === "true"; // boolean


//? ====================
//? START
//? ====================
// ✅ Lấy danh sách item 
getList($limit, $offset, $searchType, $searchValue, $fillType, $fillValue, $orderby, $reverse);


//? ====================
//? FUNCTIONS
//? ====================
function getList($limit, $offset, $searchType, $searchValue, $fillType, $fillValue, $orderby, $reverse)
{
   global $connect, $tableName;

   // Kiểm tra dữ liệu payload
   if (($limit !== "" && !is_numeric($limit)) || ($offset !== "" && !is_numeric($offset)) || !is_bool($reverse))
   {
      $response = new ResponseAPI(9, "Không đủ payload để thực hiện");
      $response->send();
      return;
   }


   //! Thêm tùy chỉnh Code ở đây
   $baseQuery = "SELECT `$tableName`.*, 
      CEIL(AVG(`productreview`.`rating`)) AS 'averageRating',
      `image`.`link` AS 'featureImageUrl', 
      `productcategory`.`name` AS 'productCategoryName', 
      `productcategory`.`deletedAt` AS 'productCategoryDeletedAt'
      FROM `$tableName`
      LEFT JOIN `image` ON `image`.`id` = `$tableName`.`featureImageId`
      LEFT JOIN `productcategory` ON `productcategory`.`id` = `$tableName`.`productCategoryId`
      LEFT JOIN `productreview` ON `productreview`.`productId` = `$tableName`.`id`
      WHERE `$tableName`.`deletedAt` IS NULL
      GROUP BY `$tableName`.`id`";
   $optionQuery = "";


   //! Cẩn thận khi sửa Code ở đây
   //! Tùy chỉnh truy vấn theo các tiêu chí
   $querySelectAllRecord = $baseQuery . " " . $optionQuery;
   // Ở đây không cần nên dùng `tableName`.`$orderby` bời vì
   // Để có thể lọc theo averageRating ở bảng productreview
   $orderbyQuery = "ORDER BY `$orderby` ASC";
   if ($reverse) {
      $orderbyQuery = "ORDER BY `$orderby` DESC";
   }
   $limitQuery = "LIMIT $limit OFFSET $offset";

   if ($limit === "") {
      $query = $querySelectAllRecord . " " . $orderbyQuery;
   } else {
      if ($searchType !== "" && $searchValue !== "" && $fillType !== "" && $fillValue !== "") {
         $querySelectAllRecord .= " AND `$tableName`.`$searchType` LIKE '%$searchValue%' AND `$tableName`.`$fillType` = '$fillValue'";
      } else if ($searchType !== "" && $searchValue !== "") {
         $querySelectAllRecord .= " AND `$tableName`.`$searchType` LIKE '%$searchValue%'";
      } else if ($fillType !== "" && $fillValue !== "") {
         $querySelectAllRecord .= " AND `$tableName`.`$fillType` = '$fillValue'";
      }

      $query = $querySelectAllRecord . " " . $orderbyQuery . " " . $limitQuery;
   }

   echo($query);

   // Thực thi truy vấn
   performsQueryAndResponseToClient($query, $querySelectAllRecord);

   // Đóng kết nối
   $connect->close();
}

// Thực thi truy vấn và trả về kết quả cho Client
function performsQueryAndResponseToClient($query, $querySelectAllRecord)
{
   global $connect;

   $result = mysqli_query($connect, $query);
   $resultSelectAllRecord = mysqli_query($connect, $querySelectAllRecord);

   if ($result && $resultSelectAllRecord) {
      $list = [];

      while ($obj = $result->fetch_object()) {
         array_push($list, $obj);
      }

      $response = new ResponseAPI(1, "Thành công", $list, mysqli_num_rows($resultSelectAllRecord));
      $response->send();
   } else {
      $response = new ResponseAPI(2, "Thất bại");
      $response->send();
   }
}
