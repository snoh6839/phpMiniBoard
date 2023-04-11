<?php
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_DB", DOC_ROOT . "db/db_common.php");
include_once(URL_DB);

$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method === "GET") {
    $board_no = 1;
    if (array_key_exists("board_no", $_GET)) {
        $board_no = $_GET["board_no"];
    }

    $result_info = select_board_info_no($board_no);
} else {
    print_r($_POST);
}

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유 게시판 - 상세 내용</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="./css/default.css">
    <script src="./js/script.js"></script>
</head>

<body>
    <div class="content-wrap">
        <div class="title">
            <div class="page-title">
                <h3>상세 내용</h3>
                <p></p>
            </div>
        </div>
        <div class="content">
            <input type="hidden" name="boardMode" value="view">
            <div class="ko board view ys-board">
                <div class="board-wrap">
                    <input type="hidden" name="board_no" value="<?php echo $result_info["board_no"] ?>">
                    <div class="board-write-wrap">
                        <dl class="board-write-box board-write-box-v01">
                            <dt>제목</dt>
                            <dd>
                                <?php echo $result_info["board_title"] ?>
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
                                    <p><?php echo $result_info["board_cont"] ?></p>
                                </div>
                            </dd>
                        </dl>
                    </div>

                    <ul class="btn-wrap text-right">
                        <li>
                            <a class="btn btn01" href="/update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a>
                        </li>
                        <li>
                            <a class="btn btn01" href="">삭제</a>
                        </li>
                        <li>
                            <a class="btn btn01" href="/index.php">목록</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

</html>