<?php
require "db.php";
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tasks</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
 <div class="top">
  <h1>My Tasks</h1>
  <a class="btn" href="create.php">+ Add Task</a>
 </div>

 <?php if ($result->num_rows === 0): ?>
  <p class="empty">No tasks yet. Add your first one.</p>
 <?php endif; ?>

 <?php while ($row = $result->fetch_assoc()): ?>
  <div class="task">
   <h3><?php echo htmlspecialchars($row['title']); ?></h3>
   <?php if ($row['description'] !== ''): ?>
    <p><?php echo htmlspecialchars($row['description']); ?></p>
   <?php endif; ?>
   <div class="meta">
    <span class="badge <?php echo $row['status']; ?>"><?php echo ucwords(str_replace('_', ' ', $row['status'])); ?></span>
    <span><?php echo date("d M Y, H:i", strtotime($row['created_at'])); ?></span>
    <span class="actions">
     <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
     <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this task?');">Delete</a>
    </span>
   </div>
  </div>
 <?php endwhile; ?>
</div>
</body>
</html>
<?php $conn->close(); ?>
