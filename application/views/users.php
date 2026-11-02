<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>User Management</h2>

        <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
            <?= html_escape($this->session->flashdata('success')); ?>
            </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">All Users</h5>

                    <?php if ($this->session->userdata('role') === 'ADMIN'): ?>

                    <a href="<?= site_url('users/add'); ?>" class="btn btn-primary">
                        + Add User
                    </a>
                    <?php endif; ?>

            </div>
              <form method="get" action="<?= site_url('users'); ?>" class="row g-2 mb-3">

                    <div class="col-md-4">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search name or email"
                            value="<?= html_escape($search); ?>">
                    </div>

                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>

                            <option value="ADMIN" <?= ($role == 'ADMIN') ? 'selected' : ''; ?>>
                                ADMIN
                            </option>

                            <option value="OPERATOR" <?= ($role == 'OPERATOR') ? 'selected' : ''; ?>>
                                OPERATOR
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>

                            <option value="ACTIVE" <?= ($status == 'ACTIVE') ? 'selected' : ''; ?>>
                                ACTIVE
                            </option>

                            <option value="INACTIVE" <?= ($status == 'INACTIVE') ? 'selected' : ''; ?>>
                                INACTIVE
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>

                </form>              
            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($users)): ?>

                            <?php foreach ($users as $user): ?>

                                <tr>
                                    <td><?= html_escape($user->id); ?></td>

                                    <td><?= html_escape($user->name); ?></td>

                                    <td><?= html_escape($user->email); ?></td>

                                    <td><?= html_escape($user->role); ?></td>

                                   <td>

                                        <?php if ($this->session->userdata('role') === 'ADMIN'): ?>

                                            <select class="form-select form-select-sm status-dropdown"
                                                data-user-id="<?= $user->id; ?>"
                                                data-current-status="<?= $user->status; ?>"
                                                style="width: 130px;">

                                                <option value="ACTIVE"
                                                    <?= ($user->status === 'ACTIVE') ? 'selected' : ''; ?>>
                                                    ACTIVE
                                                </option>

                                                <option value="INACTIVE"
                                                    <?= ($user->status === 'INACTIVE') ? 'selected' : ''; ?>>
                                                    INACTIVE
                                                </option>

                                            </select>

                                        <?php else: ?>

                                            <?php if ($user->status == 'ACTIVE'): ?>
                                                <span class="badge bg-success">ACTIVE</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">INACTIVE</span>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                    </td>

                                    <td><?= html_escape($user->created_at); ?></td>
                                    <td>
                                        <a href="<?= site_url('users/edit/' . $user->id); ?>"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <?php if (
                                            $this->session->userdata('role') === 'ADMIN'
                                            && $user->status === 'ACTIVE'
                                            && $user->id != $this->session->userdata('user_id')
                                        ): ?>

                                            <a href="<?= site_url('users/deactivate/' . $user->id); ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to deactivate this user?');">
                                                Deactivate
                                            </a>

                                            <?php endif; ?>
                                </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" class="text-center">
                                    No users found.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>
            <div class="mt-3">
                <?= $pagination_links; ?>
            </div>

        </div>

    </div>

</div>
<script 
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>

<script>
$(document).ready(function () {

    $('.status-dropdown').on('change', function () {

        var dropdown = $(this);

        var userId = dropdown.data('user-id');
        var newStatus = dropdown.val();
        var previousStatus = dropdown.attr('data-current-status');

        $.ajax({

            url: "<?= site_url('users/update_status'); ?>",

            type: "POST",

            data: {
                id: userId,
                status: newStatus
            },

            dataType: "json",

            success: function (response) {

                if (response.success) {

                    dropdown.attr('data-current-status', newStatus);

                    alert(response.message);

                } else {

                    alert(response.message);

                    dropdown.val(previousStatus);
                }
            },

            error: function (xhr) {

                alert('Unable to update user status.');

                dropdown.val(previousStatus);
            }

        });

    });

});
</script>
</body>
</html>