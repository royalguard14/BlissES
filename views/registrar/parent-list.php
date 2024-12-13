<?php
ob_start();


$pageTitle = 'Registrar Management'; 
    // Function to get initials
function getInitials($string) {
  $words = explode(' ', $string);
  $initials = '';
  foreach ($words as $word) {
    $initials .= strtoupper($word[0]);
  }
  return $initials;
}







// Function to display toast messages
function displayToastMessage($session_key, $toast_class, $title) {
    if (isset($_SESSION[$session_key])) {
        $message = $_SESSION[$session_key];
        unset($_SESSION[$session_key]);
        echo "<script type='text/javascript'>
        document.querySelector('.preloader').style.display = 'none';
        document.addEventListener('DOMContentLoaded', function() {
            $(document).Toasts('create', {
                class: '$toast_class',
                title: '$title',
                autohide: true,
                delay: 3000,
                body: '" . addslashes($message) . "'
            });
        });
        </script>";
    }
}

// Check if 'error' session is set and call the function
if (isset($_SESSION['error'])) {
    displayToastMessage('error', 'bg-danger', 'Error');
}

// Check if 'info' session is set and call the function
if (isset($_SESSION['info'])) {
    displayToastMessage('info', 'bg-info', 'Information');
}

// Check if 'success' session is set and call the function
if (isset($_SESSION['success'])) {
    displayToastMessage('success', 'bg-success', 'Success');
}









?>


<div class="row">
<section class="col-lg-5 connectedSortable">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-plus mr-1"></i>
                Add New Parent
            </h3>
        </div>

        <div class="card-body">
            <!-- Add Parent Form -->
            <form id="add-parent-form" method="POST" action="parents-add" enctype="multipart/form-data">
                <!-- Individual Parent -->
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" class="form-control">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="sex">Gender</label>
                            <select name="sex" id="sex" class="form-control" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="con_no">Contact Number</label>
                    <input type="text" id="con_no" name="con_no" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Add Parent</button>
            </form>
        </div>
    </div>
</section>


<section class="col-lg-7 connectedSortable">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">


        Parent's List
      </h3>
    </div>
    <div class="card-body">
      <table id="example3" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-align: center;">#</th>
            <th style="text-align: center;">Full Name</th>
            <th style="text-align: center;">Information</th>
            <th  style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
         <?php if(isset($parents)): ?>
          <?php $index = 1; ?>
          <?php foreach ($parents as $data): ?>
            <tr>
             <td style="text-align: center; vertical-align: middle;"><?php echo $index++; ?></td> 
             <td style="text-align: center; vertical-align: middle;">
              <?php 
              echo htmlspecialchars(ucwords(
                $data['last_name'] . ', ' . 
                $data['first_name'] . 
                (isset($data['middle_name']) && !empty($data['middle_name']) ? ' ' . $data['middle_name'][0] . '.' : '')
              ));
              ?>
            </td>
            <td style="text-align: left; vertical-align: middle;">
              <?php 
    // Display details
              echo "<strong>Address:</strong> <small>" . htmlspecialchars(ucwords(
                $data['house_street_sitio_purok'] . ", " .  
                $data['barangay'] . ", " .  
                $data['municipality_city'] . ", " .  
                getInitials($data['province']))) . "</small><br>";
       
              echo "<strong>Contact Number:</strong> <small>" . htmlspecialchars(ucwords($data['contact_number'])) . "</small><br>";
             
              ?>
            </td>
            <td style="text-align: center; vertical-align: middle;">





<div class="btn-group">

              <button type="button" class="btn btn-block btn-outline-warning update-teacher-btn m-1" 
              data-teacher='<?php echo json_encode([
                "user_id" => $data['user_id'],
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "middle_name" => $data['middle_name'],
                "email" => $data['email'],
                "sex" => $data['sex'],
                "birth_date" => $data['birth_date'],
                "contact_number" => $data['contact_number'],
                "religion" => $data['religion'],
                "house_street_sitio_purok" => $data['house_street_sitio_purok'],
                "barangay" => $data['barangay'],
                "municipality_city" => $data['municipality_city'],
                "province" => $data['province'],
                "role_id" => $data['role_id'],

                ]) ?>'
                data-toggle="modal" data-target="#updateTeacherModal">
                Update
              </button>

          
 
             <form action="/BlissES/users/delete" method="POST" style="display:inline;">
              <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
              <input type="hidden" name="paths" value="parents-list">
              <button type="submit" class="btn btn-block btn-outline-danger mt-1">Delete</button>
            </form>
   



         
          
 
           
              <button type="button" class="btn btn-block btn-outline-info m-1" onclick="openChildren('<?php echo $data['user_id']; ?>')">Parent</button>
   
  


</div>





          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>

</table>
</div>
</section>
</div>








<!-- Modal for updating teacher details -->
<div class="modal fade" id="updateTeacherModal" tabindex="-1" role="dialog" aria-labelledby="updateTeacherModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateTeacherModalLabel">Update Parent Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form to update teacher details -->
        <form id="updateTeacherForm" method="POST" action="parents-update">
          <input type="hidden" name="user_id" id="teacherUserId">
          <input type="hidden" name="role_id" id="userrole">
          
          <!-- Row for name fields (First, Middle, Last) -->
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="teacherFirstName">First Name</label>
                <input type="text" class="form-control" name="first_name" id="teacherFirstName" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="teacherMiddleName">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" id="teacherMiddleName">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="teacherLastName">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="teacherLastName" required>
              </div>
            </div>
          </div>

          <!-- Row for Email, Gender, and Birth Date -->
          <div class="row">

            <input type="hidden" class="form-control" name="email" id="teacherEmail" readonly>

            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherSex">Gender</label>
                <select class="form-control" name="sex" id="teacherSex">
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherBirthDate">Birth Date</label>
                <input type="date" class="form-control" name="birth_date" id="teacherBirthDate" required>
              </div>
            </div>
          </div>
          <hr>
          <!-- Row for Mother Tongue, Ethnic Group, and Religion -->
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherEthnicGroup">Contact No.</label>
                <input type="text" class="form-control" name="conh_no" id="conh_no" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherReligion">Religion</label>
                <input type="text" class="form-control" name="religion" id="teacherReligion" required>
              </div>
            </div>
        </div>
          <hr>
          <!-- Row for Address Details (House/Street, Barangay, Municipality/City) -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherHouseStreetSitio">House/Street/Sitio/Purok</label>
                <input type="text" class="form-control" name="house_street_sitio_purok" id="teacherHouseStreetSitio" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherBarangay">Barangay</label>
                <input type="text" class="form-control" name="barangay" id="teacherBarangay" required>
              </div>
            </div>

          </div>


          <!-- Row for Province -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherProvince">Province</label>
                <input type="text" class="form-control" name="province" id="teacherProvince" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="teacherMunicipalityCity">Municipality/City</label>
                <input type="text" class="form-control" name="municipality_city" id="teacherMunicipalityCity" required>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script type="text/javascript">
 // Open the modal with teacher data
  $(document).on('click', '.update-teacher-btn', function() {
    // Get the teacher's data from the clicked button's data-teacher attribute
    var teacherData = $(this).data('teacher'); // Retrieve the teacher's data from the 
    console.log(teacherData);

    // Populate the form fields in the modal
    $('#teacherUserId').val(teacherData.user_id);
    $('#teacherFirstName').val(teacherData.first_name);
    $('#teacherLastName').val(teacherData.last_name);
    $('#teacherMiddleName').val(teacherData.middle_name);
    $('#teacherEmail').val(teacherData.email);
    $('#teacherSex').val(teacherData.sex);
    $('#teacherBirthDate').val(teacherData.birth_date);

    $('#conh_no').val(teacherData.contact_number);
    $('#teacherReligion').val(teacherData.religion);


    $('#teacherHouseStreetSitio').val(teacherData.house_street_sitio_purok);
    $('#teacherBarangay').val(teacherData.barangay);
    $('#teacherMunicipalityCity').val(teacherData.municipality_city);
    $('#teacherProvince').val(teacherData.province);
    $('#userrole').val(teacherData.role_id);
    


    // Open the modal
    $('#updateTeacherModal').modal('show');
  });

</script>

<script type="text/javascript">
  
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
</script>




      <div class="modal fade" id="permissionsModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Children List</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <form id="permissionsForm">
          <input type="hidden" id="perm_role_id">
          <div class="row" id="permissionsList"></div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->











<script type="text/javascript">

    function openChildren(id) {
      $('#perm_role_id').val(id);
      
      $.ajax({
        url: 'parents-family',  // Endpoint to get children data
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ user_id: id }),
        dataType: 'json',
        success: function(response) {
          console.log('Response:', response);
          
          if (response.success) {
            var permissionsList = $('#permissionsList');
            permissionsList.empty(); // Clear any previous list

            // Check if there are children to display
            if (response.children && Array.isArray(response.children)) {
              response.children.forEach(function(child) {
                if (child && child.id) {
                  // Convert both child.id and assigned_children values to strings for comparison
                  var isChecked = response.assigned_children.includes(child.id.toString()) ? 'checked' : '';
                  permissionsList.append(`
                    <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input permission-checkbox" type="checkbox" value="${child.id}" id="child${child.id}" ${isChecked}>
                      <label class="form-check-label" for="child${child.id}">${child.fullname}</label>
                    </div>
                    </div>
                  `);
                }
              });
              
              // Add event listener for check/uncheck actions
              $('.permission-checkbox').change(function() {
                updateChildren(id);  // Update children based on user id
              });

              $('#permissionsModal').modal('show');
            } else {
              showToast('Error', 'No children data available.');
            }
          } else {
            showToast('Error', 'Failed to load children.');
          }
        }
      });
    }

    function updateChildren(userId) {
      var selectedChildren = [];
      
      // Gather all selected children
      $('.permission-checkbox:checked').each(function() {
        selectedChildren.push($(this).val());
      });

      $.ajax({
        url: 'update-children',  // Endpoint to update children data
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ user_id: userId, children: selectedChildren }),
        dataType: 'json',
        success: function(response) {
         showToast('Success', 'Permissions updated successfully.');
        }
       
      });
    }


      // Function to display toast notifications
  function showToast(title, message) {
    $(document).Toasts('create', {
      title: title,
      body: message,
      autohide: true,
      delay: 2000,
      class: title === 'Success' ? 'bg-success' : 'bg-danger'
    });
  }

</script>



<?php
$content = ob_get_clean();
include 'views/master.php';
?>