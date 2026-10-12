<?php
require "db.php";
require "validate.php";

$error = "";
$title = "";
$description = "";
$status = "pending";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? "";

    $error = validate_task($title, $description, $status);

    if ($error === "") {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $status);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Task</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
 <h2>Add Task</h2>

 <?php if ($error !== ""): ?>
  <div class="banner"><?php echo htmlspecialchars($error); ?></div>
 <?php endif; ?>

 <form method="POST" action="create.php" novalidate>
  <label for="title">Title</label>
  <input type="text" id="title" name="title" maxlength="255" value="<?php echo htmlspecialchars($title); ?>" required>
  <span class="error" id="title-error"></span>

  <label for="description">Description</label>
  <textarea id="description" name="description" maxlength="1000"><?php echo htmlspecialchars($description); ?></textarea>

  <label for="status">Status</label>
  <select id="status" name="status">
   <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
   <option value="in_progress" <?php echo $status === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
   <option value="done" <?php echo $status === 'done' ? 'selected' : ''; ?>>Done</option>
  </select>

  <button type="submit" class="btn">Save Task</button>
 </form>
 <a class="back" href="index.php">&larr; Back</a>
</div>
<script src="script.js"></script>
</body>
</html>
