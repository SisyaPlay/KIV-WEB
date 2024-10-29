<div class="background"></div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: relative; z-index: 1;">
    <div class="container">
        <a class="navbar-brand" href="#">Project-M</a>

        <!-- Кнопка гамбургера для мобильных устройств -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Вкладки по центру -->
            <div class="mx-auto order-0">
                <ul class="navbar-nav" style="display: flex; justify-content: center; width: 100%;">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home <!-- Иконка домика -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-images"></i> Album <!-- Иконка альбома -->
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Кнопки справа -->
            <div class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="profile.php" id="userProfileLink" aria-expanded="false">
                        <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" id="userAvatar" />
                    </a>
                <?php else: ?>
                    <a class="nav-link" href="#" id="signInBtn">Sign In</a>
                    <div class="dropdown-login" id="loginDropdown" style="display: none;">
                        <div class="dropdown-login-content">
                            <form id="loginForm" action="vendor/signin.php" method="post">
                                <label for="username">Username:</label>
                                <div class="input-wrapper">
                                    <input type="text" name="username" id="username" placeholder="Type your username">
                                    <span class="error-message" id="username-error"></span>
                                </div>
                                <label for="password">Password:</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Type your password">
                                    <span class="error-message" id="password-error"></span>
                                </div>

                                <div class="checkbox-container">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox" class="checkbox-container">Remember me</label>
                                </div>

                                <button type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                    <a class="nav-link" href="register.php">Sign Up</a>
                <?php endif; ?>
                <select class="form-select form-select-sm" id="languageSelect" aria-label="Language select">
                    <option value="en">English</option>
                    <option value="ru">Русский</option>
                </select>
            </div>
        </div>
    </div>
</nav>

<!-- Выезжающее меню для мобильных устройств -->
<div class="offcanvas offcanvas-end offcanvas-fullscreen" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel" style="background-color: white;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between text-center">
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="mb-3">
                    <a href="profile.php">
                        <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" id="userAvatar" style="width: 80px; height: 80px; border-radius: 50%;">
                    </a>
                </div>
            <?php else: ?>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a class="nav-link" href="login.php">Log In</a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="register.php">Sign Up</a>
                    </li>
                </ul>
            <?php endif; ?>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-images"></i> Album
                        </a>
                    </li>
                </ul>
        </div>

        <!-- Комбобокс выбора языка внизу -->
        <div class="mt-3">
            <select class="form-select form-select-sm" id="languageSelect" aria-label="Language select">
                <option value="en">English</option>
                <option value="ru">Русский</option>
            </select>
        </div>
    </div>
</div>

<!-- Подключите Bootstrap JS и CSS внизу вашей страницы -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>