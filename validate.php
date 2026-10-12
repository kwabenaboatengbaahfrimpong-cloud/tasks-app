<?php
// Shared check for create.php and edit.php.
// Returns an error message, or an empty string if everything is fine.
function validate_task($title, $description, $status) {
    // 1 to 255 characters, with at least one letter or number in it
    if (!preg_match('/^(?=.*[A-Za-z0-9]).{1,255}$/u', $title)) {
        return "Title is required (up to 255 characters) and must contain a letter or number.";
    }
    if (mb_strlen($description) > 1000) {
        return "Description must be 1000 characters or less.";
    }
    if (!in_array($status, ["pending", "in_progress", "done"], true)) {
        return "Please choose a valid status.";
    }
    return "";
}
