<?php
    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

            if (empty($email)) {
                $_SESSION['error'] = "ກະລຸນາໃສອີເມວ";
                header("location: signin.php");
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "ຮູບແບບ ອີເມວບໍ່ຖືກຕ້ອງ";
                header("location: signin.php");
            } else if (empty($password)) {
                $_SESSION['error'] = "ກະລຸນາໃສລະຫັດຜ່ານ";
                header("location: signin.php");
            } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
                $_SESSION['error'] = "ລະຫັດຕ້ອງມີຄວາມຍາວລະຫ່ວາງ 5 ຫາ 20 ຕົວອັກສອນ";
                header("location: signin.php");
            } else {
                try {
                    $check_datebase = $conn->prepare("SELECT * FROM users WHERE email = :email");
                    $check_datebase->bindParam(":email", $email);
                    $check_datebase->execute();
                    $row = $check_datebase->fetch(PDO::FETCH_ASSOC);

                        if ($check_datebase->rowCount() > 0) {
                            
                            if ($email == $row['email']) {
                                if (password_verify($password, $row['password'])) {
                                    if ($row['urole'] == 'user') {
                                        $_SESSION['user_login'] = $row['id'];
                                        header("location: user.php");
                                    } else {
                                        $_SESSION['admin_login'] = $row['id'];
                                        header("location: admin.php");
                                    }
                                } else {
                                    $_SESSION['error'] = "ລະຫັດຜ່ານຜິດ";
                                        header("location: signin.php");
                                }
                            } else {
                                $_SESSION['error'] = "ອີເມວຜິດ";
                                header("location: signin.php");
                            }
                        } else {
                            $_SESSION['error'] = "ບໍ່ມີຂໍ້ມູນໃນລະບົບ";
                            header("location: signin.php");
                        }
                } catch(PDOException $e) {
                    $e->getMessage();
                }
            }
    }

?>