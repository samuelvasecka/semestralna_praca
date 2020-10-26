<?php
include "../common/include.php";

$query=$_GET["q"];
$type=$_GET["t"];

$conn=getConnection();
if($conn==null){
    $data="Connection Error";
}else{
    $data="";
    if ($type=="all" || $type=="pages") {
        $sql = "SELECT title, id FROM page WHERE title LIKE '".$query."%' LIMIT 10";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data=$data . "<a href='localhost/../index.php?p=".$row["id"]."'>" .
                    $row["title"] . "<span style='float: right' value='" .$row["id"]. "'>/page</span></a>";
            }
        }
    }
    if ($type=="all" || $type=="users") {
        $sql = "SELECT username, id FROM users WHERE username LIKE '".$query."%' LIMIT 10";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data=$data . "<a href='#' target='_blank'>" .
                    $row["username"] . "<span style='float: right' value='" .$row["id"]. "'>/user</span></a>";
            }
        }
    }
    if ($type=="all" || $type=="posts") {
        $sql = "SELECT title, id FROM post WHERE title LIKE '".$query."%' LIMIT 10";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data=$data . "<a href='#' target='_blank'>" .
                    $row["title"] . "<span style='float: right' value='" .$row["id"]. "'>/post</span></a>";
            }
        }
    }
}
$conn->close();

if ($data=="") {
    $response="<a href='#'>No suggestion</a>";
} else {
    $response=$data;
}
echo $response;
?>