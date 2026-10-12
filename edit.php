<?php
require "db.php";
require "validate.php";

$id = intval($_GET["id"] ?? 0);
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? "";
    $post_id = intval($_POST["id"] ?? 0);

    $error = validate_task($title, $description, $status);

    if ($error === "") {
        $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, status=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $status, $post_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: index.php");
        exit;
    }

    // validation failed: show the form again with what the user typed
    $task = ["id" => $post_id, "title" => $title, "description" => $description, "status" => $status];
} else {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $task = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$task) { die("Task not found."); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Task</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
 <h2>Edit Task</h2>

 <?php if ($error !== ""): ?>
  <div class="banner"><?php echo htmlspecialchars($error); ?></div>
 <?php endif; ?>

 <form method="POST" action="edit.php" novalidate>
  <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

  <label for="title">Title</label>
  <input type="text" id="title" name="title" maxlength="255" value="<?php echo htmlspecialchars($task['title']); ?>" required>
  <span class="error" id="title-error"></span>

  <label for="description">Description</label>
  <textarea id="description" name="description" maxlength="1000"><?php echo htmlspecialchars($task['description']); ?></textarea>

  <label for="status">Status</label>
  <select id="status" name="status">
   <option value="pending" <?php echo $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
   <option value="in_progress" <?php echo $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
   <option value="done" <?php echo $task['status'] === 'done' ? 'selected' : ''; ?>>Done</option>
  </select>

  <button type="submit" class="btn">Update Task</button>
 </form>
 <a class="back" href="index.php">&larr; Back</a>
</div>
<script src="script.js"></script>
</body>
</html>
