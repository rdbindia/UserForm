<?php
$isUpdate = isset($userData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isUpdate ? 'Update User' : 'Create User'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1><?= $isUpdate ? 'Update User' : 'Create User'; ?></h1>
    <form action="<?= $actionUrl; ?>" method="POST" id="userForm">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $userData['name'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $userData['email'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $userData['mobile_number'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= $userData['address'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?= $userData['city'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" value="<?= $userData['state'] ?? ''; ?>" maxlength="2">
        </div>
        <div class="mb-3">
            <label for="zip" class="form-label">ZIP</label>
            <input type="text" class="form-control" id="zip" name="zip" value="<?= $userData['zip'] ?? ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?= $isUpdate ? 'Update User' : 'Create User'; ?></button>
    </form>
</div>
</body>
</html>