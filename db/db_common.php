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



//TODO : test start
// $arr =  array(
//     "board_no" => 1
//     ,"board_title" => "test122"
//     ,"board_cont" => "test_content122"
// );
// echo update_board_info_no( $arr );
//TODO : test end
?>