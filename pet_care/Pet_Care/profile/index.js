function previewImage(input) {
    var preview = document.getElementById("profileImagePreview");
    var file = input.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
      preview.src = reader.result;
    };

    if (file) {
      reader.readAsDataURL(file);
    } else {
      preview.src = "../profile/image/person.svg";
    }
  }
//  Form Validation
  document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("registrationForm");
    form.addEventListener("submit", function (event) {
      var isValid = true;

      // Validation for profile image
      var profileImage = document.getElementById("profileImageUpload");
      var profileImageError = document.getElementById("profile-image-error");
      if (profileImage.files.length === 0) {
        isValid = false;
        profileImageError.innerHTML = "Please upload a profile image.";
      } else {
        profileImageError.innerHTML = "";
      }

      

      // Validation for email
      var emailField = document.getElementById("email");
      var emailErrorMessage = document.getElementById("email-error");
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
        isValid = false;
        emailErrorMessage.innerHTML = "Please enter a valid email address.";
      } else {
        emailErrorMessage.innerHTML = "";
      }

      // Validation for password
      var passwordField = document.getElementById("password");
      var passwordErrorMessage = document.getElementById("password-error");
      if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,20}$/.test(passwordField.value)
      ) {
        isValid = false;
        passwordErrorMessage.innerHTML =
          "Password should contain at least one number, one uppercase letter, one lowercase letter, one special character, and be 8-20 characters long.";
      } else {
        passwordErrorMessage.innerHTML = "";
      }

      // Validation for confirm password
      var confirmPassField = document.getElementById("confirm_pass");
      var confirmPassErrorMessage = document.getElementById("confirm-pass-error");
      if (confirmPassField.value !== passwordField.value) {
        isValid = false;
        confirmPassErrorMessage.innerHTML = "Passwords do not match.";
      } else {
        confirmPassErrorMessage.innerHTML = "";
      }

      // Validation for address
      var addressField = document.getElementById("address");
      var addressErrorMessage = document.getElementById("address-error");
      if (addressField.value.trim() === "") {
        isValid = false;
        addressErrorMessage.innerHTML = "Please enter a valid address.";
      } else {
        addressErrorMessage.innerHTML = "";
      }

      if (!isValid) {
        event.preventDefault();
      }
      // Validation for terms and conditions checkbox
      var termsCheckbox = document.getElementById("termsCheck");
      if (!termsCheckbox.checked) {
        isValid = false;
        alert("Please accept the terms and conditions.");
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  });