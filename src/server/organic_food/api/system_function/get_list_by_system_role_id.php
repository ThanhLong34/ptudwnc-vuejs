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
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");


//? ====================
//? CHECK PERMISSTION
//? ====================
$functionName = "GetSystemFunctionListBySystemRoleId";
if (!checkPermissionFunction($functionName)) exit;


//? ====================
//? PARAMETERS & PAYLOAD
//? ====================
$tableName = "systemfunction";
$systemRoleId = $_GET["systemRoleId"] ?? 0;


//? ====================
//? START
//? ====================
// ✅ Lấy danh sách item 
getList($systemRoleId);


//? ====================
//? FUNCTIONS
//? ====================
function getList($systemRoleId)
{
   global $connect, $tableName;

   $query = "SELECT DISTINCT `$tableName`.`id`, `$tableName`.`apiPath`, `$tableName`.`name`, `$tableName`.`description`, `$tableName`.`method` 
      FROM `$tableName`, `systemrole_function` 
      WHERE `systemrole_function`.`systemRoleId` = '$systemRoleId' 
      AND `systemrole_function`.`systemFunctionId` = `$tableName`.`id`
      AND `$tableName`.`deletedAt` IS NULL";

   // Thực thi truy vấn
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
      $list = [];

      while ($obj = $result->fetch_object()) {
         array_push($list, $obj);
      }

      $response = new ResponseAPI(1, "Thành công", $list);
      $response->send();
   } else {
      $response = new ResponseAPI(2, "Thất bại");
      $response->send();
   }
}
