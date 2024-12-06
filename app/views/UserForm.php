<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<h1>User Form</h1>
<form method="POST" action="/create">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Submit</button>
</form>
</body>
</html>