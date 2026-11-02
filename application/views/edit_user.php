
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header">
            <h4>Edit User</h4>
        </div>

        <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= html_escape($error); ?>
                </div>
            <?php endif; ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <?= form_open('users/edit/' . $user->id); ?>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?= html_escape(set_value('name', $user->name)); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= html_escape(set_value('email', $user->email)); ?>"
                           required>
                </div>

                <?php if ($this->session->userdata('role') === 'ADMIN'): ?>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="ADMIN"
                                <?= set_select('role', 'ADMIN', $user->role === 'ADMIN'); ?>>
                                ADMIN
                            </option>

                            <option value="OPERATOR"
                                <?= set_select('role', 'OPERATOR', $user->role === 'OPERATOR'); ?>>
                                OPERATOR
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="ACTIVE"
                                <?= set_select('status', 'ACTIVE', $user->status === 'ACTIVE'); ?>>
                                ACTIVE
                            </option>

                            <option value="INACTIVE"
                                <?= set_select('status', 'INACTIVE', $user->status === 'INACTIVE'); ?>>
                                INACTIVE
                            </option>
                        </select>
                    </div>

                <?php endif; ?>

                <button type="submit" class="btn btn-primary">
                    Update User
                </button>

                <a href="<?= site_url('users'); ?>" class="btn btn-secondary">
                    Cancel
                </a>

            <?= form_close(); ?>

        </div>

    </div>

</div>

</body>
</html>
