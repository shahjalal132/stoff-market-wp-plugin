(function ($) {
  $(document).ready(function () {
    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

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
      $(".selected-option .percentage").text(percentage + "%");
    }

    // Function to display selected options with percentages
    function displaySelectedOptions() {
      var selectedContent = $("#desired-content").val();
      var totalOptions = selectedOptions.length;
      var percentage =
        totalOptions > 1 ? parseFloat((100 / totalOptions).toFixed(2)) : 100;

      $("#selected-options").append(
        '<div class="selected-option" contenteditable="true"> <span class="remove-option">x</span>' +
          selectedContent +
          '<span class="percentage">' +
          percentage +
          "%</span>" +
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
      // Reset form fields
      $("#msform")[0].reset();

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
    });

    // event listener for the "get-bids" button
    $("#get-bids").click(function (e) {
      e.preventDefault();

      // retrieve the form data
      var formData = $("#msform").serializeArray();

      formData.push({
        name: "desired_content",
        value: JSON.stringify(selectedOptions),
      });

      console.log(formData);

      // send ajax request
      /* $.ajax({
        url: "process-data.php",
        type: "POST",
        data: formData,
        success: function (response) {
          console.log(response);

          alert("Form data submitted successfully.");
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText); // Log any errors
          alert("Error submitting form data. Please try again.");
        },
      }); */
    });
  });
})(jQuery);
