<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user-delete"])) {
    require_once('../../config/db_con.php');
    require_once("../../config/session.php");
    require_once('../../models/users/UserManager.php');

    $userManager = new UserManager($pdo);

    // Debug
    file_put_contents('debug_delete.txt', print_r($_POST, true));

    if (!empty($_POST["user_ids"]) && is_array($_POST["user_ids"])) {
        $userIds = array_filter($_POST["user_ids"], fn($id) => filter_var($id, FILTER_VALIDATE_INT));
        if (count($userIds) > 0) {
            $userManager->deleteUsers($userIds);
            $successMsg = count($userIds) ." users deleted successfully.";
        } 
    } else {
        $userId = (int)trim($_POST["user-delete"]);
        $user = $userManager->getUserById($userId)["username"];
        $userManager->deleteUser($userId);
    
        $successMsg = "User \"" .$user. "\" deleted successfully.";
    }

    $_SESSION["success_msg"] = $successMsg;
    $_SESSION["flash_time"] = time();

    header("Location: ../../views/admin/dashboard.php?request=users&delete=success");
    exit;
} else {
    header("Location: ../../views/admin/dashboard.php?request=users&delete=error");
    exit;
}
