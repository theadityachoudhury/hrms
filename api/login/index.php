<?php
header('Content-type: application/json; charset=utf-8');

// if (!isset($_POST['loginsubmit'])) {
//     header('Location: ../../');
//     exit();
// } else {
    if(isset($_POST['username'])){
        $username = $_POST['username'];
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
    }
    $data = [];
    if (empty($username) || empty($password)) {
        $data['error'] = 'fields cannot be empty';
    } else {
        require '../../assets/setup/db.inc.php';
        $sql = 'UPDATE users SET last_login_at=NOW() WHERE username=?;';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $data['error'] = 'SQL Error';
            echo json_encode($data);
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
        }

        $sql = 'SELECT * FROM users WHERE username=?;';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $data['error'] = 'SQL Error';
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['password']);

                if ($pwdCheck == false) {
                    $data['error'] = 'Wrong Password';
                } elseif ($pwdCheck == true) {
                    if ($row['verified_at'] != null) {
                        $data['auth'] = 'verified';
                    } else {
                        $data['auth'] = 'loggedin';
                    }

                    $mail1 = $data['email'] = $row['email'];

                    /*
                     * -------------------------------------------------------------------------------
                     *   Setting rememberme cookie
                     * -------------------------------------------------------------------------------
                     */

                    $selector = bin2hex(random_bytes(8));
                    $token = random_bytes(32);

                    $sql =
                        "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='remember_me';";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        $data['error'] = 'SQL Error';
                    } else {
                        mysqli_stmt_bind_param($stmt, 's', $data['email']);
                        mysqli_stmt_execute($stmt);
                    }

                    

                    $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
                                VALUES (?, 'remember_me', ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        $data['error'] = 'SQL Error';
                    } else {
                        $gg = date('Y-m-d\TH:i:s', time() + 864000);
                        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                        $data['token'] = $hashedToken;
                        $data['selector'] = $selector;
                        mysqli_stmt_bind_param(
                            $stmt,
                            'ssss',
                            $mail1,
                            $selector,
                            $hashedToken,
                            $gg
                        );
                        mysqli_stmt_execute($stmt);
                        $data['message'] = 'success';
                    }
                }
            } else {
                $data['error'] = 'No user found';
            }
        }
    }
// }
echo json_encode($data);

?>
