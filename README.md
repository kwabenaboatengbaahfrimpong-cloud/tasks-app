# Tasks App

A small PHP and MySQL CRUD app for the CS442 E-Commerce lab. You can add, edit and delete tasks, and each task has a title, a description and a status (pending, in progress or done).

## Files

- `db.php` database connection
- `setup.php` creates the `tasks` table (run once)
- `index.php` lists all tasks (Read)
- `create.php` adds a task (Create)
- `edit.php` updates a task (Update)
- `delete.php` removes a task (Delete)
- `validate.php` server-side checks shared by create and edit
- `script.js` the same title check in the browser, for quick feedback
- `style.css` styling

## Run it locally

1. Start Apache and MySQL in XAMPP.
2. Copy this folder into `xamppfiles/htdocs/`.
3. Open `http://localhost/tasks-app/setup.php`, then `http://localhost/tasks-app/index.php`.

## Notes

- All queries use prepared statements, and output is escaped with `htmlspecialchars`.
- The title must be 1 to 255 characters with at least one letter or number. The status must be one of the three allowed values. This is checked in the browser and again in PHP.
- The `db.php` here uses the local XAMPP login. The live server copy uses different credentials that are not stored in this repository.
