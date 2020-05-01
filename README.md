# Hello_PHP
My first PHP practice!

# What does it do
- Allow user to add comments to the database
- Query comments from the database and show them

# Knowledge involved
- Session
- Database query & update
- Prevent SQL injection
- Prevent HTML injection
- Prevent excessive requests

# Study notes
1. html documents should start by `<!DOCTYPE html>`
2. You may customize styles in <style> tag: `.xxx {*}`. To use this style: `<span class="xxx">`
3. To prevent SQL injections:
```php
$stmt = $conn->prepare("SELECT * FROM table WHERE name=?");
// Check if $stmt is false
$stmt->bind_param("s", $name);    // https://www.php.net/manual/en/mysqli-stmt.bind-param.php
$stmt->execute();
$stmt->close();
```
4. To prevent HTML injections:
```php
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
```
5. To handle forms: `<form method="*" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">`
6. Return value of `time()` is in seconds
7. Don't forget to close database connection
8. After processing POST request, redirect to other pages to prevent the "resubmit data" popup of the browser:
```php
header("Location: #");
```
