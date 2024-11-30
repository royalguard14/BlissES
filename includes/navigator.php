<?php 
// Get the current page from the URL
$current_page = basename($_SERVER['REQUEST_URI'], ".php");
?>

<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
    
    <!-- Dashboard Item -->
    <li class="nav-item">
      <a href="dashboard" class="nav-link <?= ($current_page == 'dashboard') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/dashboard.png" alt="Custom Icon" >
        <p>Dashboard</p>
      </a>
    </li>

<?php if ($_SESSION['role_id'] === 1 || $_SESSION['role_id'] === 3): ?>
<li class="nav-header">Student Space</li>



    <li class="nav-item">
      <a href="learners-profile" class="nav-link <?= ($current_page == 'learners-profile') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Information</p>
      </a>
    </li>


        <li class="nav-item">
      <a href="learners-attendance" class="nav-link <?= ($current_page == 'learners-attendance') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Attendance Record</p>
      </a>
    </li>


        <li class="nav-item">
      <a href="learners-enrollment-history" class="nav-link <?= ($current_page == 'learners-enrollment-history') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Enrollemnt History</p>
      </a>
    </li>


        <li class="nav-item">
      <a href="learners-academic-history" class="nav-link <?= ($current_page == 'learners-academic-history') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Academic Record</p>
      </a>
    </li>

        <li class="nav-item">
      <a href="learners-storage" class="nav-link <?= ($current_page == 'learners-storage') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Storage</p>
      </a>
    </li>
<?php endif; ?>




    <?php if ($_SESSION['role_id'] === 1 || $_SESSION['role_id'] === 2): ?>

    <li class="nav-header">Advisory Class</li>
    <li class="nav-item">
      <a href="myclass-list" class="nav-link <?= ($current_page == 'myclass-list') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
        <p>Enrolled Student</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="class-record" class="nav-link <?= ($current_page == 'class-record') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/marking.png" alt="Custom Icon" >
        <p>Class Record</p>
      </a>
    </li>

    <li class="nav-item <?= ($current_page == 'schoolform1' || $current_page == 'schoolform2') ? 'menu-is-opening menu-open' : ''; ?>">
      <a href="#" class="nav-link <?= ($current_page == 'schoolform1' || $current_page == 'schoolform2') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/google-forms.png" alt="Custom Icon" >
        <p>
          School Form
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="schoolform1" class="nav-link <?= ($current_page == 'schoolform1') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>SF1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="schoolform2" class="nav-link <?= ($current_page == 'schoolform2') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>SF2</p>
          </a>
        </li>
      </ul>
    </li>

<?php endif; ?>


   <?php if ($_SESSION['role_id'] === 1 || $_SESSION['role_id'] === 4): ?>
    <li class="nav-header">Registrar</li>
    <li class="nav-item">
      <a href="teacher-list" class="nav-link <?= ($current_page == 'teacher-list') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/training.png" alt="Custom Icon" >
        <p>Employee's</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="students-list" class="nav-link <?= ($current_page == 'students-list') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/student.png" alt="Custom Icon" >
        <p>Learner's</p>
      </a>
    </li>
      <li class="nav-item">
      <a href="parents-list" class="nav-link <?= ($current_page == 'parents-list') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/family.png" alt="Custom Icon" >
        <p>Parents's</p>
      </a>
    </li>
    <?php endif; ?>

    <!-- Check if the user is an admin -->
    <?php if ($_SESSION['role_id'] === 1): ?>

      <li class="nav-header">School Setting</li>
      <li class="nav-item <?= ($current_page == 'campus-profile' || $current_page == 'campus-grades' || $current_page == 'campus-sections' || $current_page == 'campus-subjects') ? 'menu-is-opening menu-open' : ''; ?>">
        <a href="#" class="nav-link <?= ($current_page == 'campus-profile' || $current_page == 'campus-grades' || $current_page == 'campus-sections' || $current_page == 'campus-subjects') ? 'active' : ''; ?>">
          <img class="icon-white" src="assets/img/icons/campus.png" alt="Custom Icon" >
          <p>
            Campus
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="campus-profile" class="nav-link <?= ($current_page == 'campus-profile') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="campus-grades" class="nav-link <?= ($current_page == 'campus-grades') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Grade</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="campus-sections" class="nav-link <?= ($current_page == 'campus-sections') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Section</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="campus-subjects" class="nav-link <?= ($current_page == 'campus-subjects') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Subject</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-header">Administrative Setting</li>
      <li class="nav-item <?= ($current_page == 'roles' || $current_page == 'permissions' || $current_page == 'accounts') ? 'menu-is-opening menu-open' : ''; ?>">
        <a href="#" class="nav-link <?= ($current_page == 'roles' || $current_page == 'permissions' || $current_page == 'accounts') ? 'active' : ''; ?>">
          <img class="icon-white" src="assets/img/icons/gears.png" alt="Custom Icon" >
          <p>
            Developer
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="roles" class="nav-link <?= ($current_page == 'roles') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Roles</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="permissions" class="nav-link <?= ($current_page == 'permissions') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Permissions</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="accounts" class="nav-link <?= ($current_page == 'accounts') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Accounts</p>
            </a>
          </li>
        </ul>
      </li>
    <?php endif; ?>

  </ul>
</nav>
<!-- /.sidebar-menu -->
