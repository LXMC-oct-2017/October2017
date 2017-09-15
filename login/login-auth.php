<?php
    session_start();

    $team_id = $_GET['team-id'];
    $passwd_hash = hash('md5', $_GET['password']);
    $correct_pw = selectCorrectPassword($team_id);

    if(in_array($passwd_hash, $correct_pw)){
        //  loggin succeeded
        login();
    }else{
        //  login failed
        loginFail();
    }

    /**
     *  select password
     */
    function selectCorrectPassword($team_id){
        require '../api/database/Database.php';
        $db = Database::connect();
        $stmt = $db->query("select PASSWORD from TEAM where TEAM_ID = $team_id");
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 'PASSWORD');
    }

    /**
     *  on succeeded
     *  redirect to index.php and save team id
     */
    function login(){
        $_SESSION['LXMC_TEAM'] = $_GET['team-id'];
        $top_url = '../index.php';
        header("Location: $top_url");
    }

    /**
     *  on failed to login
     *  redirect to login page with parameter 'result=failed'
     */
    function loginFail(){
        header("Location: $url");
        exit;
    }
?>
