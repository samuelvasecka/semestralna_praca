<?php
include "../common/include.php";

$new = $_GET["n"];
$top = $_GET["t"];
$my = $_GET["m"];
$page = $_GET["p"];

$conn = getConnection();
$data = "";
if ($conn == null) {
    echo "<div class='item'>Connection error!</div>";
} else {

    date_default_timezone_set('CET');

    $sql = "SELECT post.id, post.title, post.created, post.description, users.username, users.id as userId, users.image as userImg, post.image, count(likes.id) as likesNum, count(comment.id) as commentNum, SUM(CASE WHEN likes.user ='" . $_COOKIE["user_id"] . "' THEN 1 ELSE 0 END) as hasLike FROM post LEFT JOIN likes ON likes.id_obj=post.id AND likes.type=2 LEFT JOIN comment ON comment.post=post.id LEFT JOIN users ON post.id_user=users.id";

    $date = "";
    switch ($new) {
        case 1:
            $date = date("Y/m/d H:i:sa", (strtotime('-1 day')));
            $sql = $sql . " WHERE post.created >='" . $date . "'";
            break;
        case 2:
            $date = date("Y/m/d H:i:sa", (strtotime('-1 week')));
            $sql = $sql . " WHERE post.created >='" . $date . "'";
            break;
        case 3:
            $date = date("Y/m/d H:i:sa", (strtotime('-1 month')));
            $sql = $sql . " WHERE post.created >='" . $date . "'";
            break;
    }

    if ($page != 0) {
        if ($new == 4) {
            $sql = $sql . " WHERE post.page='" . $page . "'";
        } else {
            $sql = $sql . " AND post.page='" . $page . "'";
        }
    }

    if ($my == 1) {
        if ($new == 4 && $page == 0) {
            $sql = $sql . " WHERE post.id_user='" . $_COOKIE["user_id"] . "'";
        } else {
            $sql = $sql . " AND post.id_user='" . $_COOKIE["user_id"] . "'";
        }
    }

    $sql = $sql . " GROUP BY post.id";

    switch ($top) {
        case 1:
            //TODO: order by a join s count
            $sql = $sql . " ORDER BY count(likes.id) DESC";
            break;
        case 2:
            $sql = $sql . " ORDER BY count(comment.id) DESC";
            break;
        case 3:
            $sql = $sql . " ORDER BY post.created DESC";
            break;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class='item'>
                <div class="avatar">
                    <img alt="avatar" class="image" src="../semestralna_praca/<?php echo $row["userImg"]; ?>"/>
                </div>
                <div class="left">
                    <h3 class="title">
                        <?php echo $row["title"]; ?>
                    </h3>
                    <a href=""><?php echo $row["username"]; ?></a>
                </div>
                <div class="right date">
                    <div>
                        <?php echo $row["created"]; ?>
                    </div>
                    <div>
                        <?php echo $row["created"]; ?>
                    </div>
                </div>
                <hr class="item-hr">
                <span>
                    <?php echo $row["description"]; ?>
                </span>
                <?php if ($row["image"] != null) {
                    echo "<img alt=\"published image\" id=\"published-img\" class=\"image\" src=\"../semestralna_praca/" . $row["image"] . "\"/>";
                } ?>
                <hr class="item-hr-bottom">
                <div class="post-stats">
                    <div class="inline">
                        <a href="" class="comments">
                            Comments
                        </a>
                        <?php echo $row["commentNum"]; ?>
                    </div>
                    <div class="inline likes">
                        <i class="fa fa-thumbs-up"></i>
                        <?php echo $row["likesNum"]; ?>
                    </div>

                </div>
            </div>
            <?php
        }
    }

}
$conn->close();

//echo $data;
?>