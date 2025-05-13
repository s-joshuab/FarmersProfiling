
// // Function to enable or disable crop checkboxes based on the "High Value Crops" checkbox status
// function toggleCropCheckboxes() {
// var highValueCropsCheckbox = document.getElementById('highValueCrops');
// var cropCheckboxes = document.querySelectorAll('input[type="checkbox"][id$="Crop"]');

// if (highValueCropsCheckbox.checked) {
// cropCheckboxes.forEach(function (checkbox) {
// checkbox.disabled = false;
// });
// } else {
// cropCheckboxes.forEach(function (checkbox) {
// checkbox.disabled = true;
// checkbox.checked = false;
// });
// }
// }

// // Function to enable or disable the "Talong" checkbox specifically
// function toggleTalongCheckbox() {
// var highValueCropsCheckbox = document.getElementById('highValueCrops');
// var talongCheckbox = document.getElementById('talong');

// if (highValueCropsCheckbox.checked) {
// talongCheckbox.disabled = false;
// } else {
// talongCheckbox.disabled = true;
// talongCheckbox.checked = false;
// }
// }

// // Add event listeners to the "High Value Crops" and "Talong" checkboxes
// var highValueCropsCheckbox = document.getElementById('highValueCrops');
// highValueCropsCheckbox.addEventListener('change', function () {
// toggleCropCheckboxes();
// toggleTalongCheckbox();
// });
// var talongCheckbox = document.getElementById('talong');
// talongCheckbox.addEventListener('change', function () {
// toggleTalongCheckbox();
// });

// // Call the function initially to set the initial state based on the checkbox status
// toggleCropCheckboxes();
// toggleTalongCheckbox();
