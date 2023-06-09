<?php
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_DB", DOC_ROOT . "board/db/db_common.php");
define("URL_HEADER", DOC_ROOT . "board/header.php");
include_once(URL_DB);

$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method === "GET") {
    $board_no = 1;
    if (array_key_exists("board_no", $_GET)) {
        $board_no = $_GET["board_no"];
    }

    $result_info = select_board_info_no($board_no);
} else {
    $arr_post = $_POST;
    $arr_info =
        array(
            "board_title" => $arr_post["board_title"], "board_cont" => $arr_post["board_cont"], "board_no" => $arr_post["board_no"]
        );

    $result_info_change = update_board_info_no($arr_info);
    // header("Location: board_detail.php?board_no=" . $arr_post["board_no"]);
    // exit();
    $result_info = select_board_info_no($arr_post["board_no"]);
}



?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유 게시판 - 수정 페이지</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./favi/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favi/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favi/favicon-16x16.png">
    <link rel="manifest" href="./favi/site.webmanifest">
    <link rel="stylesheet" href="./css/default.css">
    <script src="./js/script.js"></script>
</head>

<body>
    <header>
        <?php include_once(URL_HEADER) ?>
    </header>
    <div class="content-wrap">
        <div class="title">
            <div class="page-title">
                <h3><?php echo $result_info["board_no"] ?>번 글 상세 내용 수정</h3>
                <p></p>
            </div>
        </div>
        <form method="post" class="content" name="enter_pr" onkeydown="return event.key != 'Enter';">
            <input type="hidden" name="boardMode" value="view">
            <div class="ko board view ys-board">
                <div class="board-wrap">
                    <input type="hidden" name="board_no" value="<?php echo $result_info["board_no"] ?>">
                    <div class="board-write-wrap">
                        <dl class="board-write-box board-write-box-v01">
                            <dt>제목</dt>
                            <dd>
                                <input type="text" name="board_title" value="<?php echo $result_info["board_title"] ?>">
                            </dd>
                        </dl>
                        <dl class="board-write-box board-write-box-v02">
                            <dt>
                                작성일
                            </dt>
                            <dd><?php echo $result_info["create_date"] ?></dd>
                        </dl>
                        <dl class="board-write-box board-write-box-v03">
                            <dt class="hide replyNone">게시글 내용</dt>
                            <dd>
                                <div>
                                    <p>
                                        <input type="text" name="board_cont" value="<?php echo $result_info["board_cont"] ?>">
                                    </p>
                                </div>
                            </dd>
                        </dl>
                    </div>

                    <ul class="btn-wrap text-right">
                        <li>
                            <button type="submit" name="save_btn" class="btn btn01">저장</button>
                            <?php
                            if (isset($_POST["save_btn"])) {
                                if ($result_info_change = 1) {
                            ?>
                                    <script>
                                        customAlert.alert('수정되었습니다.');
                                        location.href = '/board/detail.php?board_no=<?php echo $_POST["board_no"] ?>';
                                    </script>
                                <?php
                                } else {
                                ?>
                                    <script>
                                        customAlert.alert('수정에 실패했습니다.');
                                    </script>
                            <?php
                                }
                            }
                            ?>
                        </li>
                        <li>
                            <a class="btn btn01" href="/board/detail.php?board_no=<?php echo $result_info["board_no"] ?>">취소</a>
                        </li>
                        <li>
                            <a class="btn btn01" href="/board/index.php">목록</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    <footer>
        &copy; All Rights Deserved.
        <br> Designed by Subin Noh.
    </footer>
</body>

</html>