<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('assets/js/jquery3.0.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Add your stylesheet and other head elements here -->
    <style>
        .nav-item a.nav-link.active {
            background-color: #00d3fd;
            color: black;
            font-weight: bold;
        }

        .nav-item a.nav-link:hover {
            background-color: white !important;
            color: black !important;
        }

        #chevron-icon {
            transition: transform 0.3s ease;
        }

        /* Rotation of the caret icon when expanded */
        #chevron-icon.rotate {
            transform: rotate(180deg);
        }

        /* Default background for Dashboard when logged in */
    </style>
</head>
<body>

    @can('admin-access')

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" id="dashboard-link" data-bs-target="#dashboard"
               href="{{ url('dashboard') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Farmers Data Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('farmreport') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-list-task"></i>
                <span>Farmers Data</span>
            </a>
        </li>

        {{-- <!-- Reports Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('reports') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-folder"></i>
                <span>Reports</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('search') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-search"></i>
                <span>Search</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleProfileNav()">
                <i class="ri-file-text-line "></i><span>Reports</span>
                <i class="bi bi-caret-down ms-auto" id="profile-chevron-icon"></i>
            </a>
            <ul id="profile-nav" class="nav-content">
                <li>
                    <a href="{{ url('benefits') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-person-circle" style="font-size: 16px;"></i><span style="color: #0000000;">Benefits</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('commodities') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-journal-text" style="font-size: 16px;"></i><span style="color: #0000000;">Commodities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('reports') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-people" style="font-size: 16px;"></i><span style="color: #0000000;">Download Reports</span>
                    </a>
                </li>
            </ul>
        </li>

            <!-- Profile -->
            <li class="nav-heading">Profile</li>

            <!-- Settings Nav -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="toggleSettingsNav()">
                    <i class="bi bi-sliders"></i><span>Settings</span>
                    <i class="bi bi-caret-down ms-auto" id="settings-chevron-icon"></i>
                </a>
                <ul id="settings-nav" class="nav-content">
                    <li>
                        <a href="{{ url('profile') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-person-circle" style="font-size: 16px;"></i><span style="color: #0000000;">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('audit') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-journal-text" style="font-size: 16px;"></i><span style="color: #0000000;">Audit Trail</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('manageusers') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-people" style="font-size: 16px;"></i><span style="color: #0000000;">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('backup') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-database-check" style="font-size: 16px;"></i><span style="color: #0000000;">Database Backup</span>
                        </a>
                    </li>
                </ul>
            </li>


        <!-- Logout Nav -->
        <li class="nav-item">
            <a href="#" onclick="logout()" class="nav-link" style="background-color: #00d3fd; cursor: pointer;">
                <i class="bi bi-box-arrow-in-right"></i>
                <span style="color: black;">Logout</span>
            </a>
        </li>
    </ul>


</aside>
@endcan


{{-- Staff --}}
@can('staff-access')

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" id="dashboard-link" data-bs-target="#dashboard"
               href="{{ url('dashboard') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Farmers Data Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('farmreport') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-list-task"></i>
                <span>Farmers Data</span>
            </a>
        </li>

        {{-- <!-- Reports Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('reports') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-folder"></i>
                <span>Reports</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('search') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-search"></i>
                <span>Search</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleProfileNav()">
                <i class="ri-file-text-line "></i><span>Reports</span>
                <i class="bi bi-caret-down ms-auto" id="profile-chevron-icon"></i>
            </a>
            <ul id="profile-nav" class="nav-content">
                <li>
                    <a href="{{ url('benefits') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-person-circle" style="font-size: 16px;"></i><span style="color: #0000000;">Benefits</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('commodities') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-journal-text" style="font-size: 16px;"></i><span style="color: #0000000;">Commodities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('reports') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                        <i class="bi bi-people" style="font-size: 16px;"></i><span style="color: #0000000;">Download Reports</span>
                    </a>
                </li>
            </ul>
        </li>

            <!-- Profile -->
            <li class="nav-heading">Profile</li>

            <!-- Settings Nav -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="toggleSettingsNav()">
                    <i class="bi bi-sliders"></i><span>Settings</span>
                    <i class="bi bi-caret-down ms-auto" id="settings-chevron-icon"></i>
                </a>
                <ul id="settings-nav" class="nav-content">
                    <li>
                        <a href="{{ url('profile') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-person-circle" style="font-size: 16px;"></i><span style="color: #0000000;">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('audit') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-journal-text" style="font-size: 16px;"></i><span style="color: #0000000;">Audit Trail</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('manageusers') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-people" style="font-size: 16px;"></i><span style="color: #0000000;">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('backup') }}" class="nav-item nav-link" style="background-color: #00d3fd;">
                            <i class="bi bi-database-check" style="font-size: 16px;"></i><span style="color: #0000000;">Database Backup</span>
                        </a>
                    </li>
                </ul>
            </li>


        <!-- Logout Nav -->
        <li class="nav-item">
            <a href="#" onclick="logout()" class="nav-link" style="background-color: #00d3fd; cursor: pointer;">
                <i class="bi bi-box-arrow-in-right"></i>
                <span style="color: black;">Logout</span>
            </a>
        </li>
    </ul>


</aside>
@endcan







@can('secretary-access')
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Nav -->

        <!-- Farmers Data Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('farmdata') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-list-task"></i>
                <span>Farmers Data</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('profilee') }}" onclick="setActiveNavItem(this)">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>



        <!-- Logout Nav -->
        <li class="nav-item">
            <a href="#" onclick="logout()" class="nav-link" style="background-color: #00d3fd; cursor: pointer;">
                <i class="bi bi-box-arrow-in-right"></i>
                <span style="color: black;">Logout</span>
            </a>
        </li>
    </ul>


</aside>
@endcan


<!-- ... Your HTML code ... -->

<script>
    let profileNavVisible = false;
    let settingsNavVisible = false;

    const profileNav = document.getElementById("profile-nav");
    const settingsNav = document.getElementById("settings-nav");
    const profileChevronIcon = document.getElementById("profile-chevron-icon");
    const settingsChevronIcon = document.getElementById("settings-chevron-icon");

    function toggleProfileNav() {
        profileNavVisible = !profileNavVisible;

        if (profileNavVisible) {
            profileNav.style.display = "block";
            profileChevronIcon.classList.add("rotate");
        } else {
            profileNav.style.display = "none";
            profileChevronIcon.classList.remove("rotate");
        }
    }

    function toggleSettingsNav() {
        settingsNavVisible = !settingsNavVisible;

        if (settingsNavVisible) {
            settingsNav.style.display = "block";
            settingsChevronIcon.classList.add("rotate");
        } else {
            settingsNav.style.display = "none";
            settingsChevronIcon.classList.remove("rotate");
        }
    }

    // Initially hide the dropdowns
    profileNav.style.display = "none";
    settingsNav.style.display = "none";

    function logout() {
        // Assuming the 'route' function is defined properly.
        // You can replace it with the actual route URL for logout.
        var logoutUrl = "{{ route('logout') }}";

        // Create a form dynamically
        var form = document.createElement("form");
        form.setAttribute("action", logoutUrl);
        form.setAttribute("method", "POST");

        // Add CSRF token to the form for security
        var csrfInput = document.createElement("input");
        csrfInput.setAttribute("type", "hidden");
        csrfInput.setAttribute("name", "_token");
        csrfInput.setAttribute("value", "{{ csrf_token() }}");

        form.appendChild(csrfInput);
        document.body.appendChild(form);

        // Submit the form to perform logout
        form.submit();
    }
</script>





</body>
</html>
