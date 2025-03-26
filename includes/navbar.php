<header class="header">

    <div class="container">
        <div class="nav-container">
            <a href="#" class="logo">
                Intellitech System
            </a>

            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <?php
            // Get current page filename
            $currentPage = basename($_SERVER['PHP_SELF']);
            ?>

            <ul class="nav" id="mainNav">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link <?php echo ($currentPage == 'home.php') ? 'active' : ''; ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="../services.php" class="nav-link dropdown-toggle <?php echo ($currentPage == 'services.php') ? 'active' : ''; ?>">Services</a>
                    <div class="dropdown-menu">
                        <a href="../services/gate automation.php" class="dropdown-item">
                            <i class="fas fa-robot"></i>
                            Gate Automation
                        </a>
                        <a href="../services/gate_fabrication.php" class="dropdown-item">
                            <i class="fas fa-hammer"></i>
                            Gate Fabrication
                        </a>
                        <a href="../services/garage_door.php" class="dropdown-item">
                            <i class="fas fa-warehouse"></i>
                            Sectional Garage Door
                        </a>
                        <a href="../services/roll_up_door.php" class="dropdown-item">
                            <i class="fas fa-door-open"></i>
                            Roll Up Door
                        </a>
                        <a href="../services/electric_fence.php" class="dropdown-item">
                            <i class="fas fa-bolt"></i>
                            Smart Electric Fence
                        </a>
                        <a href="../services/smart_curtain.php" class="dropdown-item">
                            <i class="fas fa-home"></i>
                            Smart Curtain
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="../appointment.php" class="nav-link <?php echo ($currentPage == 'appointment.php') ? 'active' : ''; ?>">Appointment</a>
                </li>
                <li class="nav-item">
                    <a href="../about.php" class="nav-link <?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>">About</a>
                </li>
                <li class="nav-item">
                    <a href="../contact.php" class="nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="btn">
                        <i class="fas fa-user"></i>
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div id="navOverlay" class="nav-overlay"></div>