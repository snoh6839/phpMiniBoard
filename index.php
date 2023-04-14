<?php
// define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
// define( "URL_DB", DOC_ROOT. "db/db_common.php" );
// include_once( URL_DB );

define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
// define("URL_DB", DOC_ROOT . "board/db/db_common.php");
define("URL_DB", "C:\Apache24\htdocs\board\db\db_common.php");
// define("URL_HEADER", DOC_ROOT . "board/header.php");
define("URL_HEADER", "C:\Apache24\htdocs\board\header.php");
include_once(URL_DB);

if (array_key_exists("page_num", $_GET)) {
    $page = $_GET["page_num"];
} else {
    $page = 1;
}

$limit_num = 5;
$result_cnt = select_board_info_cnt();
$offset = ($page * $limit_num) - $limit_num;
$num_pages = ceil((int)$result_cnt[0]["cnt"] / $limit_num);
// echo $num_pages;

$arr_prepare =
    array(
        "limit_num" => $limit_num, "offset" => $offset
    );
$board_list = select_board_info_paging($arr_prepare);
// print_r($result_cnt);

if (isset($_POST['search_query']) && !empty($_POST['search_query'])) {
    $search_word = $_POST['search_query'];
    $search_arr = array("search_query" => $search_word
    // , "limit_num" => $limit_num
    // , "offset" => $offset
);
    $board_list = search_board_info($search_arr);
    var_dump($board_list);

} else {
    $arr_prepare = array("limit_num" => $limit_num, "offset" => $offset);
    $board_list = select_board_info_paging($arr_prepare);
}


?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유 게시판</title>
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
                <h3>자유 게시판 미니 프로젝트</h3>
            </div>
        </div>

        <form method="post">
            <fieldset class="content-search-wrap">
                <legend class="hide">게시글 검색</legend>
                <input type="hidden" name="mode" value="list">
                <div>
                    <label for="search_key" class="hide">검색분류선택</label>
                    <input type="hidden" name="search_key" id="search_key">
                    <select class="board-selectbox board-selectbox-title">
                        <option selected class="searchOption" title="제목" data-value="board_title">제목</option>
                        <option class="searchOption" title="내용" data-value="board_cont">내용</option>
                    </select>
                </div>
                <label for="search_val" class="hide">검색어</label>
                <input type="text" id="search_val" name="search_query" value="" placeholder="검색어를 입력해 주세요">
                <button type="submit" class="board-search-btn">검색</button>
            </fieldset>
        </form>
        <div class="content">
            <input type="hidden" name="boardMode" value="list">
            <div class="board list ys-board">
                <div class="common">
                    <div class="board-wrap board-qa">
                        <table class="board-table">
                            <caption class="hide">미니 &gt; 자유 &gt; 게시판</caption>
                            <colgroup>
                                <col width="10%">
                                <col width="*">
                                <col width="15%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">제목</th>
                                    <th scope="col">등록일/수정일</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($board_list as $recode) {
                                ?>
                                    <tr class="  ">
                                        <td class="">
                                            <?php
                                            echo $recode["board_no"]
                                            ?>
                                        </td>
                                        <td class="text-left">
                                            <div class="c-board-title-wrap">
                                                <a href="/board/detail.php?board_no=<?php echo $recode["board_no"] ?>" class="c-board-title">
                                                    <?php
                                                    echo $recode["board_title"]
                                                    ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            echo $recode["create_date"]
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <ul class="paging-wrap">
                        <?php
                        $prevPage = ($page == 1) ? $num_pages : $page - 1;
                        $nextPage = ($page == $num_pages) ? 1 : $page + 1;
                        if ($page > 1) {
                        ?>
                            <li><a href='index.php?page_num=<?php echo $prevPage; ?>'>Prev</a></li>
                        <?php } ?>
                        <?php
                        for ($i = 1; $i <= $num_pages; $i++) {
                            if ($i === (int)$page) {
                        ?>
                                <li><a href="/board/index.php?page_num=<?php echo $i ?>" class="page-icon active"><?php echo $i ?></a></li>
                            <?php
                            } else {
                            ?>
                                <li><a href="/board/index.php?page_num=<?php echo $i ?>" class="page-icon"><?php echo $i ?></a></li>
                            <?php
                            }
                        }
                        if ((int)$page < $num_pages) {
                            ?>
                            <li><a href='/board/index.php?page_num=<?php echo $nextPage; ?>'>Next</a></li>
                        <?php } else if ((int)$page = $num_pages) { ?>
                            <script>
                                customAlert.alert('마지막페이지입니다.')
                            </script>
                        <?php } ?>
                    </ul>
                    <ul class="btn-wrap text-right">
                        <li>
                            <a class="btn btn01" href="/board/write.php">글쓰기</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer>
        &copy; All Rights Deserved.
        <br> Designed by Subin Noh.
    </footer>
</body>

</html>