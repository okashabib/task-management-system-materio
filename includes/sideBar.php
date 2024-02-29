<body>

  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="../dashboard/index.php" class="app-brand-link">
        <span class="app-brand-logo demo">
          <span style="color: var(--bs-primary)">
            <i class="menu-icon tf-icons mdi mdi-incognito mdi-36px"></i>
          </span>
        </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-2">TMS.</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <li class="menu-item <?php echo strpos($_SERVER['PHP_SELF'], '/dashboard/') !== false ? 'active' : ''; ?>">
        <a href="../dashboard/index.php" class="menu-link">
          <i class="menu-icon tf-icons mdi mdi-view-dashboard"></i>
          <div data-i18n="Icons">Dashboard</div>
        </a>
      </li>
      <li class="menu-item <?php echo strpos($_SERVER['PHP_SELF'], '/user/') !== false ? 'active' : ''; ?>">
        <a href="../user/index.php" class="menu-link">
          <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
          <div data-i18n="Basic">Users</div>
        </a>
      </li>
    </ul>
  </aside>

</body>
