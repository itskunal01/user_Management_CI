
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management - Login</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border: none;
            border-radius: 12px;
        }

        .login-title {
            font-weight: 700;
            color: #212529;
        }

        .login-btn {
            width: 100%;
            padding: 11px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">

                <div class="card login-card mx-auto">


                    <div class="text-center mb-4">

                        <h3 class="login-title">
                            User Management
                        </h3>

                        <p class="text-muted">
                            login to continue
                        </p>

                    </div>


                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">
                            <?= html_escape($error); ?>
                        </div>

                    <?php endif; ?>


                    <form action="<?= site_url('auth/login'); ?>"
                          method="POST">


                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                autocomplete="username"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label for="password" class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >

                        </div>


                        <button type="submit"
                                class="btn btn-primary login-btn">

                            Login

                        </button>

                    </form>

                </div>
                </p>

            </div>

        </div>

    </div>

</body>
</html>
