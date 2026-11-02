<!DOCTYPE html>
<html>
<head>
    <title>User Management Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2>Welcome to User Management System</h2>

        <hr>

        <p><strong>Name:</strong> <?= html_escape($name); ?></p>

        <p><strong>Email:</strong> <?= html_escape($email); ?></p>

        <p><strong>Role:</strong> <?= html_escape($role); ?></p>


        <a href="<?= site_url('users'); ?>" class="btn btn-primary">
            Manage Users
        </a>

        <a href="<?= site_url('auth/logout'); ?>" class="btn btn-danger">
            Logout
        </a>

    </div>

</div>

</body>
</html>