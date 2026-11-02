<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New User</h4>
        </div>

        <div class="card-body">


            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= html_escape($error) ?>
                </div>
            <?php endif; ?>


            <?= validation_errors(
                '<div class="alert alert-danger">',
                '</div>'
            ) ?>

            <form method="post" action="<?= site_url('users/add') ?>">


                <div class="mb-3">
                    <label class="form-label">Full Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= set_value('name') ?>"
                        placeholder="Enter full name"
                        required
                    >
                </div>


                <div class="mb-3">
                    <label class="form-label">Email Address</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= set_value('email') ?>"
                        placeholder="Enter email address"
                        required
                    >
                </div>


                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter password"
                        required
                    >
                </div>


                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>

                    <input
                        type="password"
                        name="confirm_password"
                        class="form-control"
                        placeholder="Confirm password"
                        required
                    >
                </div>


                <div class="mb-3">
                    <label class="form-label">Role</label>

                    <select name="role" class="form-select" required>
                        <option value="">Select Role</option>

                        <option value="ADMIN" <?= set_select(
                            'role',
                            'ADMIN'
                        ) ?>>
                            ADMIN
                        </option>

                        <option value="OPERATOR" <?= set_select(
                            'role',
                            'OPERATOR'
                        ) ?>>
                            OPERATOR
                        </option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select" required>
                        <option value="">Select Status</option>

                        <option value="ACTIVE" <?= set_select(
                            'status',
                            'ACTIVE'
                        ) ?>>
                            ACTIVE
                        </option>

                        <option value="INACTIVE" <?= set_select(
                            'status',
                            'INACTIVE'
                        ) ?>>
                            INACTIVE
                        </option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">
                    Save User
                </button>

                <a href="<?= site_url('users') ?>" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>