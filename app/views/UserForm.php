<?php use models\User as UserModel;

include __DIR__ . '/header.php';

$isUpdate = isset($userData);
?>

    <h1><?= $isUpdate ? 'Update User' : 'Create User'; ?></h1>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Profile Info</h2>
                <p class="text-muted">Manage your personal information.</p>
                <form action="<?= $actionUrl; ?>" method="POST" id="userForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name <span class="required">*</span> </label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="<?= $userData['first_name'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="<?= $userData['last_name'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $userData['email'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobileNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="mobileNumber" name="mobile_number" value="<?= $userData['mobile_number'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="required">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $userData['address'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City <span class="required">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" value="<?= $userData['city'] ?? '';?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State / Province <span class="required">*</span></label>
                        <select class="form-select" id="state" name="state" required>
                            <option value="" selected>None</option>
                            <option <?= (isset($userData['state']) && $userData['state'] == 'AZ') ? 'selected' : '' ?> value="AZ">Alabama</option>
                            <option <?= (isset($userData['state']) && $userData['state'] == 'CA') ? 'selected' : '' ?> value="CA">California</option>
                            <option <?= (isset($userData['state']) && $userData['state'] == 'NY') ? 'selected' : '' ?> value="NY">New York</option>
                            <option <?= (isset($userData['state']) && $userData['state'] == 'IL') ? 'selected' : '' ?> value="IL">Illinois</option>
                            <option <?= (isset($userData['state']) && $userData['state'] == 'TX') ? 'selected' : '' ?> value="TX">Texas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="postalCode" class="form-label">Postal Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="postalCode" name="zip" maxlength="10" pattern="\d{5}(-\d{4})?" value="<?= $userData['zip'] ?? '' ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary"><?= $isUpdate ? 'Update User' : 'Create User'; ?></button>
                        <a href="/" class="btn btn-secondary">Back</a>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $userData['id'] ?? '' ?>">
                </form>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/footer.php'; ?>