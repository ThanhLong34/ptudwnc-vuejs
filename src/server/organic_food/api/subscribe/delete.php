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
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");


//? ====================
//? CHECK PERMISSTION
//? ====================
$functionName = "DeleteSubscribe";
if (!checkPermissionFunction($functionName)) exit;


//? ====================
//? PARAMETERS & PAYLOAD
//? ====================
$tableName = "subscribe";
$data = getJSONPayloadRequest();

$id = $data["id"] ?? ""; // int


//? ====================
//? START
//? ====================
// ✅ Xóa item theo id
deleteItem($id);


//? ====================
//? FUNCTIONS
//? ====================
function deleteItem($id)
{
   global $connect, $tableName;

   // Kiểm tra dữ liệu payload
   if ($id === "" || !is_numeric($id)) {
      $response = new ResponseAPI(9, "Không đủ payload để thực hiện");
      $response->send();
      return;
   }

   // Kiểm tra item đã đánh dấu trong thùng rác chưa
   if (!checkItemInTrash($id)) {
      $response = new ResponseAPI(3, "Xóa thất bại, đối tượng chưa được chuyển vào thùng rác");
      $response->send();
      return;
   }

   // Thực thi query
   $query = "DELETE FROM `$tableName` WHERE `id` = '$id' AND `deletedAt` IS NOT NULL";
   performsQueryAndResponseToClient($query);

   // Đóng kết nối
   $connect->close();
}

// Thực thi truy vấn và trả về kết quả cho Client
function performsQueryAndResponseToClient($query)
{
   global $connect;
   $result = mysqli_query($connect, $query);

   if ($result) {
      $response = new ResponseAPI(1, "Thành công");
      $response->send();
   } else {
      $response = new ResponseAPI(2, "Thất bại");
      $response->send();
   }
}

// Kiểm tra trường dữ liệu deletedAt có null không
function checkItemInTrash($id)
{
   global $connect, $tableName;

   $query = "SELECT * FROM `$tableName` WHERE `id` = '$id' AND `deletedAt` IS NOT NULL LIMIT 1";
   $result = mysqli_query($connect, $query);

   if ($result && mysqli_num_rows($result) > 0) {
      return true;
   }

   return false;
}
