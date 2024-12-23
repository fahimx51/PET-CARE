<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Care || Admin Dashboard</title>
  <link rel="stylesheet" href="admin_dashbord.css">
  <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
</head>

<body>
  <div class="sidebar">
    <div class="logo">
      <h1><span>Pet</span>&nbsp;Care</h1>
      <hr>
    </div>
    <ul class="nav">
      <li>
        <a href="#" onclick="toggleSubMenu(event, 'userSubmenu')">Account</a>
        <ul class="submenu" id="userSubmenu">
          <li><a href="#" onclick="loadContent('reg_users.php')">Registered Users</a></li>
          <li><a href="#" onclick="loadContent('temp_user.php')">Pending Users</a></li>
        </ul>
      </li>
      <li>
        <a href="#" onclick="toggleSubMenu(event, 'appointmentSubmenu')">Appointments</a>
        <ul class="submenu" id="appointmentSubmenu">
          <li><a href="#" onclick="loadContent('pending_appointment.php')">Pending Appointments</a></li>
          <li><a href="#" onclick="loadContent('approved_appointments.php')">Approved Appointments</a></li>
        </ul>
      </li>
      <li>
        <a href="#" onclick="toggleSubMenu(event, 'lostandfoundpetSubmenu')">Lost And Found Pets</a>
        <ul class="submenu" id="lostandfoundpetSubmenu">
          <li><a href="#" onclick="loadContent('lost_pets.php')">Lost Pets Request</a></li>
          <li><a href="#" onclick="loadContent('found_pets.php')">Found Pets Request</a></li>
          <li><a href="#" onclick="loadContent('approved_lost_pets.php')">Approved Lost Pets</a></li>
          <li><a href="#" onclick="loadContent('approved_found_pets.php')">Approved Found Pets</a></li>
        </ul>

      </li>
      <li><a href="#" onclick="loadContent('pets.php')">Pets</a></li>
      <li>
        <a href="#" onclick="toggleSubMenu(event, 'petfoodSubmenu')">Pet Food</a>
        <ul class="submenu" id="petfoodSubmenu">
          <li><a href="#" onclick="loadContent('admin_add_product.php')">Add Pet Food</a></li>
          <li><a href="#" onclick="loadContent('pet_food_list.php')">Products of Foods</a></li>
          <li><a href="#" onclick="loadContent('order_list.php')">Orders</a></li>
          <li><a href="#" onclick="loadContent('chart.php')">Charts</a></li>
          <li><a href="#" onclick="loadContent('confirmed_orders.php')">Confirmed Orders</a></li>
          <li><a href="#" onclick="loadContent('confirmed_orders.php')">Payment List</a></li>
        </ul>
      </li>
      <li><a href="#" onclick="loadContent('adoption_requests.php')">Pet Adoptions Request</a></li>
      <li><a href="#" onclick="loadContent('user_message.php')">User Message</a></li>

    </ul>
  </div>

  <button onclick="logout()" class="logout-button">Logout</button>

  <div class="content">
    <div class="main-content" id="mainContent">
      <div class="cards-container">
        <div class="card" onclick="loadContent('reg_users.php')">
          <div class="card-header">Registered Users</div>
          <div class="card-body" id="registeredUsersCount"></div>
        </div>

        <div class="card" onclick="loadContent('temp_user.php')">
          <div class="card-header">Pending Users</div>
          <div class="card-body" id="otherUsersCount"></div>
        </div>

        <div class="card" onclick="loadContent('pending_appointment.php')">
          <div class="card-header">Pending Appointments</div>
          <div class="card-body" id="pendingAppointmentsCount"></div>
        </div>

        <div class="card" onclick="loadContent('approved_appointments.php')">
          <div class="card-header">Approved Appointments</div>
          <div class="card-body" id="approvedAppointmentsCount"></div>
        </div>

        <div class="card" onclick="loadContent('lost_pets.php')">
          <div class="card-header">Lost Pets Request</div>
          <div class="card-body" id="lostPetsCount"></div>
        </div>

        <div class="card" onclick="loadContent('found_pets.php')">
          <div class="card-header">Found Pets Request</div>
          <div class="card-body" id="foundPetsCount"></div>
        </div>

        <div class="card" onclick="loadContent('approved_lost_pets.php')">
          <div class="card-header">Approved Lost Pets</div>
          <div class="card-body" id="approvedLostPetsCount"></div>
        </div>

        <div class="card" onclick="loadContent('approved_found_pets.php')">
          <div class="card-header">Approved Found Pets</div>
          <div class="card-body" id="approvedFoundPetsCount"></div>
        </div>


        <div class="card" onclick="loadContent('pets.php')">
          <div class="card-header">Pets</div>
          <div class="card-body" id="petsCount"></div>
        </div>

        <div class="card" onclick="loadContent('adoption_requests.php')">
          <div class="card-header">Adoption Requests</div>
          <div class="card-body" id="adoptionRequestsCount"></div>
        </div>

        <div class="card" onclick="loadContent('adoption_requests.php')">
          <div class="card-header">Approved Adoptions</div>
          <div class="card-body" id="approvedAdoptionsCount"></div>
        </div>

        <div class="card" onclick="loadContent('user_message.php')">
          <div class="card-header">User Messages</div>
          <div class="card-body" id="userMessagesCount"></div>
        </div>
      </div>

    </div>
  </div>

  <script>
    function loadContent(page) {
      fetchData(page, 'mainContent');
    }

    function fetchData(url, elementId) {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", url, true);
      xhttp.send();
      xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          document.getElementById(elementId).innerHTML = this.responseText;
        }
      };

    }


    function fetchCounts() {
    fetchData('get_registered_users_count.php', 'registeredUsersCount');
    fetchData('get_pending_registration_count.php', 'otherUsersCount');
    fetchData('get_pending_appointments_count.php', 'pendingAppointmentsCount');
    fetchData('get_approved_appointments_count.php', 'approvedAppointmentsCount');
    fetchData('get_lost_pets_count.php', 'lostPetsCount');
    fetchData('get_found_pets_count.php', 'foundPetsCount');
    fetchData('get_pets_count.php', 'petsCount');
    fetchData('get_adoption_requests_count.php', 'adoptionRequestsCount');
    fetchData('get_approved_adoptions_count.php', 'approvedAdoptionsCount');
    fetchData('get_user_messages_count.php', 'userMessagesCount');
    fetchData('get_approved_lost_pets_count.php', 'approvedLostPetsCount'); 
    fetchData('get_approved_found_pets_count.php', 'approvedFoundPetsCount');
}


    window.onload = function() {
      fetchCounts();
    };

    function toggleSubMenu(event, submenuId) {
      event.preventDefault();
      var submenu = document.getElementById(submenuId);

      if (submenu.style.display === 'block') {
        submenu.style.display = 'none';
      } else {
        submenu.style.display = 'block';
      }

    }

    function logout() {
      window.location.href = 'logout.php';
    }
  </script>

</body>

</html>