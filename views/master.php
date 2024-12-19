<?php 

if (!isset($_SESSION['log_in']) || !$_SESSION['log_in']) {
    header('Location: /BlissES/login');
    exit();
}
 ?>







<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->title ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/css/icons.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>



<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>




<style type="text/css">
  .drawer {
    position: fixed;
    right: 0;
    top: 0;
    height: 100%;
    width: 300px;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
    transform: translateX(100%);
    transition: transform 0.3s;
    padding: 1rem !important;
    z-index: 9999; /* Ensure the drawer is in front of all other elements */
  }
  .drawer.open {
    transform: translateX(0);
  }
  .chat-windows {
    position: fixed;
    bottom: 0;
    right: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 9998; /* Make sure chat windows are below the drawer */
  }
  .direct-chat {
    width: 100%;
    background: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  }
  .input-group input {
    border-radius: 20px;
  }
  .input-group-append button {
    border-radius: 20px;
    background-color: #007bff;
    color: white;
  }
</style>








</head>




<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="assets/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>




  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="profile" class="nav-link">Profile </a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
  

<!-- Messages Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" id="open-drawer">
        <i class="far fa-comments"></i>
        <span id="unread-message-badge" class="badge badge-danger navbar-badge">0</span>
    </a>
</li>

<script>
$(document).ready(function() {
    // Function to fetch and update the unread message count
    function updateUnreadMessageCount() {
        $.ajax({
            url: 'message_count', // Replace with your backend endpoint
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Ensure response.count is valid
                if (response && response.count !== undefined) {
                    const badge = $('#unread-message-badge'); // Use the badge ID
                    const unreadCount = parseInt(response.count, 10);

                    if (unreadCount > 0) {
                        badge.text(unreadCount).show(); // Show badge with count
                    } else {
                        badge.hide(); // Hide badge when count is 0
                    }
                } else {
                    console.error('Invalid response from server.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch unread message count:', error);
            }
        });
    }

    // Call the function every second
    setInterval(updateUnreadMessageCount, 20000);

    // Call immediately on page load
    updateUnreadMessageCount();
});
</script>

      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>





      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout" class="nav-link text-red">Logout</a>
      </li>





    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="assets/logo1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;background-color: transparent;">
      <span class="brand-text font-weight-light" style="font-size:1rem"><?= $this->title ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
       <a href="#" class="d-block"><?= isset($this->name) ? $this->name : 'Default Name' ?></a>

        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

<?php include './includes/navigator.php' ;?>

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo isset($pageTitle) ? $pageTitle : 'Management'; ?></h1>
          </div><!-- /.col -->
    
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">












      
      <div class="container-fluid">
 <?php echo isset($content) ? $content : "<div class='alert alert-danger'>No content available.</div>"; ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include './includes/footer.php' ;?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery UI 1.11.s4 -->
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
  
</script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/widget.js"></script>
<!-- ChartJS -->

<script src="assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/js/pages/dashboard.js"></script>


<!-- DataTables  & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script type="text/javascript">

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });


</script>




 <template id="chat-window-template">
    <div class="col-md-3">
      <!-- DIRECT CHAT PRIMARY -->
      <div class="card card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
          <h3 class="card-title"></h3>
          <div class="card-tools">
            <!-- <span title="3 New Messages" class="badge bg-primary">3</span> -->
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool close-chat" title="Close Chat">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <!-- Conversations will be dynamically added here -->
          <div class="direct-chat-messages">
            <!-- Dynamic chat messages loop -->
          </div>
          <!--/.direct-chat-messages-->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form method="POST" action="#" class="chat-form" id="message-form">
            <div class="input-group">
              <input type="hidden" name="receiver_id" class="receiver-id">
              <input type="text" name="message" class="chat-input form-control" placeholder="Type Message ..." >
              <span class="input-group-append">
                <button type="submit" class="btn btn-primary">Send</button>
              </span>
            </div>
          </form>
        </div>
        <!-- /.card-footer-->
      </div>
      <!--/.direct-chat -->
    </div>
    <!-- /.col -->
  </template>
  <!-- Drawer for Classmates/Teachers -->
  <div id="user-drawer" class="drawer control-sidebar-content">
    <div class="drawer-header">
     
      <div class="row">


<div class="col-6"> <h5>Contact List</h5></div>
<div class="col-6"> <button id="close-drawer" class="close-btn">X</button></div>


        
     
      </div>








    </div>
    <div class="drawer-body">

    </div>
  </div>
  <!-- Pop-up Chat Windows -->
  <div id="chat-windows" class="chat-windows">
    <!-- Dynamically populated chat windows -->
  </div>
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
      const drawer = document.getElementById('user-drawer');
      const openDrawerBtn = document.getElementById('open-drawer');
      const closeDrawerBtn = document.getElementById('close-drawer');
      const userList = document.getElementById('user-list');
       const adviserList = document.getElementById('teacher-list');
      const chatWindows = document.getElementById('chat-windows');
      const chatWindowTemplate = document.getElementById('chat-window-template');
  // Toggle drawer and fetch data
      openDrawerBtn.addEventListener('click', () => {
        drawer.classList.add('open');
    fetchContacts(); // Fetch the list of available contacts
  });
      closeDrawerBtn.addEventListener('click', () => drawer.classList.remove('open'));
  // Fetch user list using $.ajax
function fetchContacts() {
    $.ajax({
        url: 'fetch-chat-available', // Replace with your server endpoint
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Clear existing content
            $('#teacher-list').empty();
            $('#user-list').empty();

            // Remove sections to ensure they are recreated only when necessary
            $('#adviser-section').remove();
            $('#classmate-section').remove();
            $('#parent-section').remove();

            // Handle adviser data
            if (data.adviser) {
                const adviserSection = `
                    <div id="adviser-section">
                        <h5>My Adviser</h5>
                        <ul id="teacher-list"></ul>
                    </div>`;
                $(adviserSection).appendTo('.drawer-body');

                const adviserItem = document.createElement('li');
                adviserItem.textContent = `Adviser: ${data.adviser.name}`;
                adviserItem.dataset.userId = data.adviser.id; // Store the adviser's ID
                adviserItem.addEventListener('click', () => openChatWindow(data.adviser)); // Add click event
                $('#teacher-list').append(adviserItem);
            }

            // Handle classmates data
            if (data.classmates && data.classmates.length > 0) {
                const classmateSection = `
                    <div id="classmate-section">
                        <h5>My Classmates</h5>
                        <ul id="user-list"></ul>
                    </div>`;
                $(classmateSection).appendTo('.drawer-body');

                data.classmates.forEach(user => {
                    const li = document.createElement('li');
                    li.textContent = user.name; // Display the user's name
                    li.dataset.userId = user.id; // Store the user's ID
                    li.addEventListener('click', () => openChatWindow(user)); // Add click event
                    $('#user-list').append(li); // Append to classmates list
                });
            }


                        // Handle classmates data
if (data.adviser_class && data.adviser_class.length > 0) {
    const AdviserSection = `
        <div id="classmate-section">
            <h5>My Advisory Class</h5>
            <ul id="user-list"></ul>
        </div>`;
    $(AdviserSection).appendTo('.drawer-body');

    data.adviser_class.forEach(user => {
        const li = document.createElement('li');
        li.textContent = `${user.name}`;

        if (user.unread_count > 0) {
            li.innerHTML += ` <span class="badge badge-danger">${user.unread_count}</span>`;
        }

        li.dataset.userId = user.id;
        li.addEventListener('click', () => openChatWindow(user));
        $('#user-list').append(li);
    });
}


            // Handle parents data
            if (data.parents && data.parents.length > 0) {
                const parentSection = `
                    <div id="parent-section">
                        <h5>Parents</h5>
                        <ul id="parent-list"></ul>
                    </div>`;
                $(parentSection).appendTo('.drawer-body');

                data.parents.forEach(parent => {
                    const li = document.createElement('li');
                    li.textContent = parent.name; // Display parent's name
                    li.dataset.userId = parent.id; // Store parent's ID
                    li.addEventListener('click', () => openChatWindow(parent)); // Add click event
                    $('#parent-list').append(li); // Append to parents list
                });
            }

            // Show message if no data for any section
            if (!data.adviser && (!data.classmates || data.classmates.length === 0) && (!data.parents || data.parents.length === 0) && (!data.adviser_class || data.adviser_class.length === 0)) {
                const noDataMessage = `<p>No contacts available</p>`;
                $('.drawer-body').append(noDataMessage);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching contacts:', error);
        }
    });
}




function openChatWindow(user) {
    drawer.classList.remove('open'); // Close the drawer
    let chatWindow = document.querySelector(`.direct-chat[data-user-id="${user.id}"]`);

    // If chat window already open, use it
    if (!chatWindow) {
        chatWindow = chatWindowTemplate.content.cloneNode(true).querySelector('.direct-chat');
        chatWindow.dataset.userId = user.id;
        chatWindow.querySelector('.card-title').textContent = user.name; // Set the chat window title
        chatWindow.querySelector('.receiver-id').value = user.id; // Set receiver ID for the form
        chatWindow.querySelector('.close-chat').addEventListener('click', () => chatWindow.remove());
        chatWindows.appendChild(chatWindow);
    }

    // Fetch previous chat messages
    fetchChatMessages(user.id).then(messages => {
        const messagesContainer = chatWindow.querySelector('.direct-chat-messages');
        messagesContainer.innerHTML = ''; // Clear existing messages

        if (messages.length > 0) {
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('direct-chat-msg');
                if (msg.sender_id === user.id) {
                    messageDiv.classList.add('right'); // Align the message to the right if it's from the user
                }
                messageDiv.innerHTML = `
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-${msg.sender_id === user.id ? 'right' : 'left'}">${msg.sender_name}</span>
                        <span class="direct-chat-timestamp float-${msg.sender_id === user.id ? 'left' : 'right'}">${msg.timestamp}</span>
                    </div>
                    <img class="direct-chat-img" src="${msg.sender_avatar}" alt="Message User Image">
                    <div class="direct-chat-text">${msg.message}</div>
                `;
                messagesContainer.appendChild(messageDiv);
            });
        } else {
            const noMessages = document.createElement('div');
            noMessages.classList.add('direct-chat-msg');
            noMessages.textContent = 'No previous messages.';
            messagesContainer.appendChild(noMessages);
        }

        // Automatically scroll to the bottom of the chatbox
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Start fetching new messages every second
        startFetchingMessagesForChat(user.id);
    });
}












// Function to fetch new messages every second for an open chat window
function fetchNewMessages(userId) {
    $.ajax({
        url: 'fetch-message',  // Replace with the correct endpoint
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ user_id: userId }),  // Send the user_id to fetch new messages
        dataType: 'json',
        success: function (data) {
            const chatWindow = document.querySelector(`.direct-chat[data-user-id="${userId}"]`);
            const messagesContainer = chatWindow.querySelector('.direct-chat-messages');

            // Clear existing messages to avoid duplication
            messagesContainer.innerHTML = '';

            if (data.length > 0) {
                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('direct-chat-msg');
                    if (msg.sender_id === userId) {
                        messageDiv.classList.add('right'); // Align the message to the right if it's from the user
                    }
                    messageDiv.innerHTML = `
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-${msg.sender_id === userId ? 'right' : 'left'}">${msg.sender_name}</span>
                            <span class="direct-chat-timestamp float-${msg.sender_id === userId ? 'left' : 'right'}">${msg.timestamp}</span>
                        </div>
                        <img class="direct-chat-img" src="${msg.sender_avatar}" alt="Message User Image">
                        <div class="direct-chat-text">${msg.message}</div>
                    `;
                    messagesContainer.appendChild(messageDiv);
                });
            } else {
                const noMessages = document.createElement('div');
                noMessages.classList.add('direct-chat-msg');
                noMessages.textContent = 'No new messages.';
                messagesContainer.appendChild(noMessages);
            }

            // Automatically scroll to the bottom of the chatbox
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        },
        error: function (xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
}

// Call the function every second for each open chat window
function startFetchingMessagesForChat(userId) {
    setInterval(function () {
        fetchNewMessages(userId);
    }, 1000); // 1000 milliseconds = 1 second
}











  // Fetch previous chat messages using $.ajax
  function fetchChatMessages(userId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: 'fetch-message',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ user_id: userId }),
        dataType: 'json',
        success: function (data) {
          resolve(data);
        },
        error: function (xhr, status, error) {
          console.error('Error fetching messages:', error);
          reject(error);
        }
      });
    });
  }


  $(document).on("submit", "#message-form", function (e) {
  e.preventDefault(); // Prevent the default form submission
  // Retrieve the input values
  const receiverId = $('.receiver-id').val(); // Get the value of the hidden input
  const messageContent = $('.chat-input').val(); // Get the value of the message input
  // Optional: Check if message content is empty before proceeding
  if (!messageContent.trim()) {
    alert("Message cannot be empty!");
    return;
  }
  sendMessage(receiverId, messageContent);
});



  // Send a message using $.ajax
  function sendMessage(userId, messageContent) {
    const chatWindow = document.querySelector(`.direct-chat[data-user-id="${userId}"]`);
    const messagesContainer = chatWindow.querySelector('.direct-chat-messages');
    $.ajax({
      url: 'sendMessage', // Replace with the correct endpoint for sending the message
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        user_id: userId,
        message: messageContent,
      }),
      dataType: 'json',
      success: function (data) {

        if (data.status === 'success') {
          const messageContent = $('.chat-input').val(); 
          // Add the sent message to the chat window
          const messageDiv = document.createElement('div');
          messageDiv.classList.add('direct-chat-msg', 'right'); // Align the sent message to the right
          messageDiv.innerHTML = `
          <div class="direct-chat-infos clearfix">
          <span class="direct-chat-name float-right">${data.sender_name}</span>
          <span class="direct-chat-timestamp float-left">${data.timestamp}</span>
          </div>
          <img class="direct-chat-img" src="${data.sender_avatar}" alt="Message User Image">
          <div class="direct-chat-text">${messageContent}</div>
          `;
          messagesContainer.appendChild(messageDiv);
          messagesContainer.scrollTop = messagesContainer.scrollHeight; // Scroll to bottom
          $('.chat-input').val('');
        } else {
          console.error('Error sending message');
        }
      },
    });
  }
});
</script>
















</body>
</html>
