<?php
ob_start();
$pageTitle = 'Campus info Management'; 





if (isset($_SESSION['error'])) {
  $error_message = $_SESSION['error'];
  unset($_SESSION['error']);
  echo "<script type='text/javascript'>
  document.querySelector('.preloader').style.display = 'none';
  document.addEventListener('DOMContentLoaded', function() {
    $(document).Toasts('create', {
      class: 'bg-danger',
      title: 'Error',
      autohide: true,
      delay: 3000,
      body: '" . addslashes($error_message) . "'
      });
      });
      </script>";
    }




?>




<div class="row">
  <section class="col-lg-5 connectedSortable">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          Academic Year
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
              <button type="button" class="btn btn-block btn-outline-primary btn-xs" data-toggle="modal" data-target="#schoolyearModal" >
                New Record
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="text-align: center;">#</th>
              <th style="text-align: center;">Year</th>
              <th style="text-align: center;">End</th>
              <th style="text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($academicYear)): ?>
              <?php $index = 1; ?>
              <?php foreach ($academicYear as $data): ?>
                <tr>
                  <td style="text-align: center;"><?php echo $index++; ?></td> 
                  <td style="text-align: center;"><?php echo $data['start']; ?></td>
                  <td style="text-align: center;"><?php echo $data['end']; ?></td>
    
                <td>
                  <form action="campus-school-year/delete" method="POST" style="display:inline;">
                    <input type="hidden" name="sy_id" value="<?php echo $data['id']; ?>">
                    <button type="submit" class="btn btn-block btn-outline-danger btn-xs">Drop</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<section class="col-lg-7 connectedSortable">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Campus Information
      </h3>
    </div>
    <div class="card-body">
      <form method="POST" action="campus-info/update">
        
<?php foreach ($campusInfo as $info): ?>
  <div class="form-group">
    <label for="campus-info-<?= $info['id']; ?>"><?= $info['name']; ?>:</label>

    <?php if ($info['id'] == 6): ?>
      <!-- If ID is 6, show the select dropdown with academic years -->
      <select class="form-control" name="campus_info[<?= $info['id']; ?>]" id="campus-info-<?= $info['id']; ?>" required>
        <option value="" <?= (empty($info['function']) ? 'selected' : ''); ?>>Select academic year</option>
        <?php
          // Loop through and create options for each academic year
          foreach ($academicYear as $year): ?>
            <option value="<?= $year['id']; ?>" 
              <?= ($info['function'] == $year['id']) ? 'selected' : ''; ?>>
              <?= $year['start'] . ' - ' . $year['end']; ?>
            </option>
          <?php endforeach; ?>
      </select>

    <?php elseif ($info['id'] == 8): ?>
      <!-- If ID is 8, show the select dropdown for grading periods -->
      <select class="form-control" name="campus_info[<?= $info['id']; ?>]" id="campus-info-<?= $info['id']; ?>" required>
        <option value="" <?= (empty($info['function']) ? 'selected' : ''); ?>>Select grading period</option>
        <option value="1" <?= ($info['function'] == 1) ? 'selected' : ''; ?>>First Grading</option>
        <option value="2" <?= ($info['function'] == 2) ? 'selected' : ''; ?>>Second Grading</option>
        <option value="3" <?= ($info['function'] == 3) ? 'selected' : ''; ?>>Third Grading</option>
        <option value="4" <?= ($info['function'] == 4) ? 'selected' : ''; ?>>Fourth Grading</option>
      </select>

    <?php else: ?>
      <!-- Default input for other IDs -->
      <input type="text" class="form-control" name="campus_info[<?= $info['id']; ?>]" 
             id="campus-info-<?= $info['id']; ?>" value="<?= htmlspecialchars($info['function']); ?>" required>
    <?php endif; ?>
  </div>
<?php endforeach; ?>





      </div>
      <div class="card-footer d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
  </div>
</section>


</div>
<div class="modal fade" id="schoolyearModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Record New School Year</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="campus-school-year/create">
        <div class="modal-body">
          <div class="form-group">
            <label for="start_school_year">Start</label>
            <input
            type="number"
            name="start_school_year"
            id="start_school_year"
            class="form-control"
            required
            />
          </div>
          <div class="form-group">
            <label for="end_school_year">End</label>
            <input
            type="number"
            name="end_school_year"
            id="end_school_year"
            class="form-control"
            readonly
            />
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit"  class="btn btn-primary">Record</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  // Get references to input elements
  const startYearInput = document.getElementById('start_school_year');
  const endYearInput = document.getElementById('end_school_year');
  // Get the current year
  const currentYear = new Date().getFullYear();
  // Set the minimum value for the "Start" year dynamically
  startYearInput.min = currentYear;
  // Event listener for when the "Start" year is changed
  startYearInput.addEventListener('input', function () {
    const startYear = parseInt(startYearInput.value, 10);
    // Set the "End" year to be one year after the "Start" year
    if (!isNaN(startYear)) {
      endYearInput.value = startYear + 1;
    } else {
      endYearInput.value = ''; // Clear "End" year if input is invalid
    }
  });
</script>
<?php
$content = ob_get_clean();
include 'views/master.php';
?>