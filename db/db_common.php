<?php
function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board_project";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option =
        array(
            PDO::ATTR_EMULATE_PREPARES => false
            ,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
    
    try {
        $param_conn = new PDO ($dns, $user, $pass, $pdo_option);
        return true;
    } catch (EXCEPTION $e) {
        $param_conn = null;
        throw new Exception($e->getMessage());
        
    }

}

function select_board_info_paging( &$param_arr ){
    $sql =
        " select "
            . " board_no "
            ." , board_title "
            ." , create_date "
        ." from "
            ." board_info "
        ." where "
            ." del_flag = '0' "
        ." order by "
            ." board_no  DESC "
        ." limit :limit_num offset :offset "
        ;
    
    $arr_prepare =
        array(
            ":limit_num" => $param_arr["limit_num"]
            ,":offset" => $param_arr["offset"]
        );
    // $conn = null;
    try{
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result;

    
}

function select_board_info_cnt()
{
    $sql =
        " select "
        . " count(*) as cnt "
        . " from "
        . " board_info "
        . " where "
        . " del_flag = '0' "
        ;

    $arr_prepare =
        array();
        
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result;
}


function select_board_info_no( &$param_no )
{
    $sql =
        " SELECT "
        . " * "
        . " FROM "
        . " board_info "
        . " WHERE "
        . " board_no = :board_no";

    $arr_prepare =
        array(
            ":board_no" => $param_no
        );

    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result[0];
}

function update_board_info_no( &$param_arr )
{
    $sql = 
    " UPDATE "
    ." board_info "
    . " SET "
    . " board_title = :board_title "
    . ", board_cont = :board_cont "
    . ", create_date = NOW()"
    . "WHERE "
    ." board_no = :board_no";

    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_cont" => $param_arr["board_cont"]
            ,":board_no" => $param_arr["board_no"]
        );

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } catch (EXCEPTION $e) {
        $conn->rollback();
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    // return $result_cnt;
}

function delete_board_info_no(&$param_arr)
{
    $sql = 
    " UPDATE "
    . " board_info "
    ." SET "
    ." del_flag = '1' "
    ." ,delete_date = Now() "
    ." WHERE "
    ." board_no = :board_no ";

    $arr_prepare = 
    array(":board_no" => $param_arr["board_no"]);

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } catch ( EXCEPTION $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }

    return $result_cnt;
}

function write_board_info(&$param_arr)
{
    $sql =
        " INSERT INTO "
        . " board_info "
        . " ( "
        . " board_title "
        . ", board_cont "
        . ", create_date "
        . " ) VALUES "
        . " ( "
        . " :board_title "
        . " , :board_cont "
        . " , Now() "
        . " ) ";

    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            , ":board_cont" => $param_arr["board_cont"]
        );

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } catch (EXCEPTION $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }

    // return $result_cnt;
}

function search_board_info( &$param_arr ){
    $sql =
        " SELECT "
            ." board_no "
            ." , board_title "
            ." , create_date "
        ." FROM "
            ." board_info "
        ." WHERE "
            ." del_flag = '0' "
            ." AND (board_title LIKE :search_query OR board_cont LIKE :search_query) "
        ." ORDER BY "
            ." board_no DESC "
        ." LIMIT :limit_num OFFSET :offset "
        ;
    
    $search_query = "%".$param_arr["search_query"]."%";
    
    $arr_prepare =
        array(
            ":search_query" => $search_query
            ,":limit_num" => $param_arr["limit_num"]
            ,":offset" => $param_arr["offset"]
        );
    
    try{
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result;
}


//TODO : test start
// $arr =  array(
//     "board_title" => "새로운 글입니다."
//     , "board_cont" => "새로운 글입니다."
// );
// echo write_board_info($arr);
//TODO : test end

?>
