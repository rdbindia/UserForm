<?php

include __DIR__ . '/header.php';
?>

    <div class="container">
    <div class="row col-md-offset-2 custyle">
    <table class="table table-striped custab">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['first_name']; ?></td>
                <td><?= $user['last_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['mobile_number']; ?></td>
                <td><?= $user['address']; ?></td>
                <td><?= $user['city']; ?></td>
                <td><?= $user['state']; ?></td>
                <td><?= $user['zip']; ?></td>
                <td>
                    <a
                            href="/update?id=<?= $user['id']; ?>"
                            class="btn btn-sm btn-warning"
                    >
                        Edit
                    </a>

                    <a
                            class="btn btn-sm btn-danger delete-user"
                            data-id="<?= $user['id']; ?>"
                            href="/delete?id=<?= $user['id']; ?>"
                    >
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include __DIR__ . '/footer.php'; ?>