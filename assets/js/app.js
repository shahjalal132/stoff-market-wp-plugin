(function ($) {
  $(document).ready(function () {
    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(window).on("load", function () {
      // Check if the URL contains the specific hash
      if (window.location.hash === "#msform") {
        // If hash is present, show the .main-form section
        $(".main-form").show();
        // move to a specific id
        $("html, body").animate(
          {
            scrollTop: $("#msform").offset().top,
          },
          {
            duration: 1000,
            easing: "linear",
          }
        );
      }
    });
    $(".get-custom-bids").on("click", function () {
      $(".main-form").show();
      // move to a specific id
      $("html, body").animate(
        {
          scrollTop: $("#msform").offset().top,
        },
        {
          duration: 1000,
          easing: "linear",
        }
      );
    });

    $(".next").click(function () {
      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      // Validate current step before proceeding
      if (validateStep(current_fs)) {
        // Add Class Active
        $("#progressbar li")
          .eq($("fieldset").index(next_fs))
          .addClass("active");

        // Show the next fieldset
        next_fs.show();
        // Hide the current fieldset with style
        current_fs.animate(
          { opacity: 0 },
          {
            step: function (now) {
              // For making fieldset appear animation
              opacity = 1 - now;

              current_fs.css({
                display: "none",
                position: "relative",
              });
              next_fs.css({ opacity: opacity });
            },
            duration: 500,
          }
        );
        setProgressBar(++current);

        // Check if the next step is the finish step
        if (next_fs.hasClass("finish-step")) {
          $("#progressbar").hide();
        }
      }
    });

    $(".previous").click(function () {
      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();

      // Remove class active
      $("#progressbar li")
        .eq($("fieldset").index(current_fs))
        .removeClass("active");

      // Show the previous fieldset
      previous_fs.show();

      // Hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // For making fieldset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative",
            });
            previous_fs.css({ opacity: opacity });
          },
          duration: 500,
        }
      );
      setProgressBar(--current);
    });

    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar").css("width", percent + "%");
    }

    $(".submit").click(function () {
      return false;
    });

    // Array to store selected options
    var selectedOptions = [];

    // Function to update selected options list
    function updateSelectedOptions() {
      var selectedContent = $("#desired-content").val();
      if (selectedContent !== "") {
        // Add selected option to the array if it's not already present
        if (!selectedOptions.includes(selectedContent)) {
          selectedOptions.push(selectedContent);

          // Calculate and update percentages for all selected options
          updatePercentages();

          // Display selected options with updated percentages
          displaySelectedOptions();
        }
      }
    }

    // Function to calculate and update percentages
    function updatePercentages() {
      var totalOptions = selectedOptions.length;
      var percentage =
        totalOptions > 1 ? parseFloat((100 / totalOptions).toFixed(2)) : 100;

      // Update percentage for each selected option
      $(".selected-option .percentage").text(percentage);
    }

    // Function to display selected options with percentages
    function displaySelectedOptions() {
      var selectedContent = $("#desired-content").val();
      var totalOptions = selectedOptions.length;
      var percentage =
        totalOptions > 1 ? parseFloat((100 / totalOptions).toFixed(2)) : 100;

      $("#selected-options").append(
        '<div class="selected-option"> <span class="remove-option">x</span>' +
          selectedContent +
          '<span class="percentage" contenteditable="true">' +
          percentage +
          "</span>%" +
          "</div>"
      );
    }

    // When select option changes
    $("#desired-content").change(function () {
      updateSelectedOptions();
    });

    // When remove option is clicked
    $(document).on("click", ".remove-option", function () {
      // Get the selected option text
      var optionToRemove = $(this)
        .parent()
        .text()
        .trim()
        .replace(/(\d+\.\d+%|\d+%)$/, "")
        .trim();

      // Remove the option from selectedOptions array
      selectedOptions.splice(selectedOptions.indexOf(optionToRemove), 1);

      // Remove the selected option from UI
      $(this).parent().remove();

      // Recalculate and update percentages after an option is removed
      updatePercentages();
    });

    // Function to validate current step
    function validateStep(currentStep) {
      var isValid = true;
      var errorMessageContainer = currentStep.find(".error-message");

      // Check if any required fields are empty in the current step
      currentStep
        .find(
          'input[type="text"], input[type="email"], input[type="number"], select'
        )
        .each(function () {
          if ($(this).val() === "") {
            isValid = false;
            $(this).addClass("error");
          } else {
            $(this).removeClass("error");
          }
        });

      // Email validation specifically for Step One
      if (currentStep.hasClass("w-534")) {
        var emailValue = currentStep.find("#email").val();
        if (!validateEmail(emailValue)) {
          isValid = false;
          showNotification("Please enter a valid email address", 5000);
        }
      }

      // Check if "Already launched?" field is empty only if it's step one
      if (currentStep.hasClass("w-534")) {
        var alreadyLaunchedValue = currentStep
          .find('input[name="lanced"]:checked')
          .val();
        if (!alreadyLaunchedValue) {
          isValid = false;
          showNotification(
            "Please select whether already launched or not",
            5000
          );
        }
      }

      // Check if "Fabric" field is empty only if it's step two
      if (currentStep.hasClass("w-787")) {
        var fabricValue = currentStep
          .find('input[name="fabric"]:checked')
          .val();
        if (!fabricValue) {
          isValid = false;
          showNotification("Please select fabric structure", 5000);
        }
      }

      // Show/hide error message container based on validation result
      if (!isValid) {
        // Call the function to show notification
        showNotification("Please fill up all fields", 5000);
      }

      return isValid;
    }

    // Function to validate email
    function validateEmail(email) {
      var re = /\S+@\S+\.\S+/;
      return re.test(email);
    }

    // Function to generate options for days
    function generateDays() {
      for (var i = 1; i <= 31; i++) {
        var day = ("0" + i).slice(-2); // Add leading zero if single digit
        $("#delivery-day").append(
          "<option value='" + day + "'>" + day + "</option>"
        );
      }
    }

    // Function to generate options for years
    function generateYears() {
      var currentYear = new Date().getFullYear();
      for (var i = currentYear; i <= 2030; i++) {
        $("#delivery-year").append(
          "<option value='" + i + "'>" + i + "</option>"
        );
      }
    }

    // Call the functions to generate options
    generateDays();
    generateYears();

    // Notification function
    function showNotification(message, duration) {
      var notification = $("#notification");
      var progressBar = $("#notification-progress");

      // Set notification message
      $("#notification-message").text(message);

      // Reset progress bar
      progressBar.css("width", "100%");

      // Show notification
      notification.fadeIn();

      // Start progress bar animation
      progressBar.animate(
        { width: "0%" },
        {
          duration: duration,
          easing: "linear",
          complete: function () {
            // Hide notification when progress completes
            notification.fadeOut();
          },
        }
      );
    }

    // Function to reset the form and go back to step one
    function resetForm() {
      // clear all input fields
      $(
        'input[type="text"], input[type="email"], input[type="number"], select'
      ).val("");

      // Remove error classes
      $('input[type="text"], input[type="email"], select').removeClass("error");

      // Remove selected options
      $("#selected-options").empty();

      // Reset progress bar
      setProgressBar(1);

      // Show the first fieldset and hide the rest
      $("fieldset").css({ opacity: 0 }).hide();
      $("fieldset:first").css({ opacity: 1 }).show();

      // Reset current step
      current = 1;

      // Make the first step active in the progress bar
      $("#progressbar li").removeClass("active");
      $("#progressbar li:first").addClass("active");

      // Show progress bar
      $("#progressbar").show();

      // remove all elements from selectedOptions
      selectedOptions = [];
    }

    // Event listener for the "thank-you-button"
    $(document).on("click", "#thank-you-button", function () {
      // Reset the form and go back to step one
      resetForm();

      // Redirect to main page
      window.location.href = "/";
    });

    // Select the design upload input element
    const uploadInput = document.getElementById("design_upload");

    // Select the input element that will store the base64 encoded image data
    const imageInput = document.getElementById("image_base64");

    // Add an event listener to the upload input for when the file selection changes
    uploadInput.addEventListener("change", (event) => {
      // Get the first selected file from the event object
      const file = event.target.files[0];

      // Check if a file is actually selected
      if (file) {
        // Create a new FileReader object
        const reader = new FileReader();

        // Define a function to handle the onload event of the FileReader
        reader.onload = (e) => {
          // Get the base64 encoded data from the event target result
          const base64Data = e.target.result;

          // Set the value of the image_base64 input element to the base64 encoded data
          imageInput.value = base64Data;
          $(".image-show").show();

          // OPTIONAL: Uncomment the following line to see the base64 data in the console for debugging purposes
          // console.log(base64Data);
        };

        // Start reading the selected file as a data URL (base64 encoded)
        reader.readAsDataURL(file);
      } else {
        // If no file is selected, clear the value of the image_base64 input element
        imageInput.value = "";
      }
    });

    // event listener for the "get-bids" button
    $("#get-bids").click(function (e) {
      e.preventDefault();

      if ($(".submit__generated").hasClass("valid")) {
        // retrieve the form data
        var formData = $("#msform").serializeArray();

        // log the form data
        var selectOption = $(".selected-option").text();

        // remove x from beginning
        selectOption = selectOption.replace("x", "");

        var imageBase64 = $("#image_base64").val();

        // convert selectOption text to array with space as delimiter
        selectOption = selectOption.split(" ");

        // remove first ''
        selectOption.shift();

        // push to formData array the selectOption array
        formData.push({ name: "desired_contents", value: selectOption });

        // push to formData array the imageBase64
        formData.push({ name: "fabric_design", value: imageBase64 });

        // send ajax request
        $.ajax({
          url: "/wp-json/stoff-market/v1/send-email",
          type: "POST",
          data: formData,
          beforeSend: function () {
            // Show loading spinner before AJAX request
            $("#loading-spinner").show();
          },
          success: function (response) {
            // log the response
            // console.log(response);

            // Hide loading spinner after AJAX request is successful
            $("#loading-spinner").hide();

            window.location.href = "/thank-you/";

            // wait for 3 seconds
            /* setTimeout(function () {
              // redirect to thank you page
              window.location.href = "/thank-you/";
            }, 3000); */
          },
          error: function (xhr, status, error) {
            // Hide loading spinner if AJAX request encounters an error
            $("#loading-spinner").hide();

            console.error(xhr.responseText);
          },
          complete: function () {
            // Hide loading spinner after AJAX request is complete (regardless of success or failure)
            $("#loading-spinner").hide();
          },
        });
      } else {
        alert("Please solve the captcha");
      }
    });

    // captcha code starts here
    var a,
      b,
      c,
      submitContent,
      captcha,
      locked,
      validSubmit = false,
      timeoutHandle;

    // Generating a simple sum (a + b) to make with a result (c)
    function generateCaptcha() {
      a = Math.ceil(Math.random() * 10);
      b = Math.ceil(Math.random() * 10);
      c = a + b;
      submitContent =
        "<span>" +
        a +
        "</span> + <span>" +
        b +
        "</span>" +
        ' = <input class="submit__input" type="text" maxlength="2" size="2" required />';
      $(".submit__generated").html(submitContent);

      init();
    }

    // Check the value 'c' and the input value.
    function checkCaptcha() {
      if (captcha === c) {
        // Pop the green valid icon
        $(".submit__generated").removeClass("unvalid").addClass("valid");
        $(".submit").removeClass("overlay");
        $(".submit__overlay").fadeOut("fast");

        $(".submit__error").addClass("hide");
        $(".submit__error--empty").addClass("hide");
        validSubmit = true;
      } else {
        if (captcha === "") {
          $(".submit__error").addClass("hide");
          $(".submit__error--empty").removeClass("hide");
        } else {
          $(".submit__error").removeClass("hide");
          $(".submit__error--empty").addClass("hide");
        }
        // Pop the red unvalid icon
        $(".submit__generated").removeClass("valid").addClass("unvalid");
        $(".submit").addClass("overlay");
        $(".submit__overlay").fadeIn("fast");
        validSubmit = false;
      }
      return validSubmit;
    }

    function unlock() {
      locked = false;
    }

    // Refresh button click - Reset the captcha
    $(".submit__control i.fa-refresh").on("click", function () {
      if (!locked) {
        locked = true;
        setTimeout(unlock, 500);
        generateCaptcha();
        setTimeout(checkCaptcha, 0);
      }
    });

    // init the action handlers - mostly useful when 'c' is refreshed
    function init() {
      $("form").on("submit", function (e) {
        e.preventDefault();
        if ($(".submit__generated").hasClass("valid")) {
          // var formValues = [];
          captcha = $(".submit__input").val();
          if (captcha !== "") {
            captcha = Number(captcha);
          }

          checkCaptcha();

          if (validSubmit === true) {
            validSubmit = false;
            // Temporary direct 'success' simulation
            submitted();

            alert("Hello");
          }
        } else {
          return false;
        }
      });

      // Captcha input result handler
      $(".submit__input").on(
        "propertychange change keyup input paste",
        function () {
          // Prevent the execution on the first number of the string if it's a 'multiple number string'
          // (i.e: execution on the '1' of '12')
          window.clearTimeout(timeoutHandle);
          timeoutHandle = window.setTimeout(function () {
            captcha = $(".submit__input").val();
            if (captcha !== "") {
              captcha = Number(captcha);
            }
            checkCaptcha();
          }, 150);
        }
      );
    }

    generateCaptcha();
    // captcha code ends here
  });
})(jQuery);
