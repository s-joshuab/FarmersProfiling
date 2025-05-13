@extends('layouts.index')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="title-container text-center py-4">
                <h1 class="display-4 font-weight-bold">Add Benefits</h1>
            </div>
            <form method="post" action="{{ route('farmers.beneficiary', ['id' => $farmersprofile->id]) }}">
                @csrf
                <input type="hidden" name="farmersprofile_id" value="{{ $farmersprofile->id }}">

                <div id="form-container">
                    <!-- Initial form fields (first form, cannot be removed) -->
                    <div class="col-md-12 dynamic-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="benefits">Benefits</label>
                                    <input type="text" class="form-control" name="benefits[]" placeholder="Enter something">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" name="date[]" placeholder="Select date">
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <!-- Text to remove the form (hidden for the first form) -->
                                <span class="remove-form-text" style="display: none; color: red; cursor: pointer;">
                                    Remove this form
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <!-- Cancel button aligned to the left -->
                        <div class="col-md-4 mt-3">
                            <button type="button" class="btn btn-secondary w-50" onclick="cancelForm()">Cancel</button>
                        </div>
                        
                        <!-- Add Form and Submit buttons aligned to the right -->
                        <div class="col-md-8 mt-3">
                            <div class="row justify-content-end">
                                <!-- Add Form button -->
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success w-100" onclick="addForm()">
                                        Add Form <i class="bi bi-plus"></i>
                                    </button>
                                </div>  
                                <!-- Submit button -->
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to add a new form dynamically
    function addForm() {
        var formContainer = document.getElementById('form-container');

        // Clone the first form (excluding the remove-form-text span)
        var newForm = document.querySelector('.dynamic-form').cloneNode(true);

        // Clear the input values in the cloned form
        var inputs = newForm.querySelectorAll('input');
        inputs.forEach(function(input) {
            input.value = ''; // Clear each input
        });

        // Display the "Remove this form" text only for added forms (not the first one)
        var removeText = newForm.querySelector('.remove-form-text');
        removeText.style.display = 'inline'; // Make the text visible

        // Add event listener to the "Remove this form" text
        removeText.addEventListener('click', function() {
            formContainer.removeChild(newForm);
        });

        // Append the new form to the container
        formContainer.appendChild(newForm);
    }

    // Function to clear all the forms and reset to the initial state
    function cancelForm() {
        var formContainer = document.getElementById('form-container');
        
        // Clear all dynamic forms
        formContainer.innerHTML = '';

        // Add the initial (first) form back to the container
        var initialForm = `
            <div class="col-md-12 dynamic-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="benefits">Benefits</label>
                            <input type="text" class="form-control" name="benefits[]" placeholder="Enter something">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date[]" placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <span class="remove-form-text" style="display: none; color: red; cursor: pointer;">
                            Remove this form
                        </span>
                    </div>
                </div>
            </div>
        `;

        formContainer.innerHTML = initialForm;
    }
</script>

@endsection
