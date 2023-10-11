<ul class="nav nav-tabs">
    <?php if($user_type == 1 or $user_type == 2)  { ?>
        <li role="presentation" <?php if($redirect == "summary") echo "class='active'"; ?>><a href="?page=summary">Summary</a></li>
        <li role="presentation" <?php if($redirect == "students") echo "class='active'"; ?>><a href="?page=students">Students</a></li>
        <li role="presentation" <?php if($redirect == "grades") echo "class='active'"; ?>><a href="?page=grades">Grades</a></li>
        <li role="presentation" <?php if($redirect == "reports") echo "class='active'"; ?>><a href="?page=reports">Report Design</a></li>
    <?php }
        if($user_type == 1) { ?>
        <li role="presentation" <?php if($redirect == "customers") echo "class='active'"; ?>><a href="?page=customers">Customers</a></li>
        <li role="presentation" <?php if($redirect == "courses") echo "class='active'"; ?>><a href="?page=courses">Courses</a></li>
        <li role="presentation" <?php if($redirect == "student_course") echo "class='active'"; ?>><a href="?page=student_course">Student-Course Map</a></li>
        <li role="presentation" <?php if($redirect == "instructors") echo "class='active'"; ?>><a href="?page=instructors">Instructors</a></li>
        <li role="presentation" <?php if($redirect == "email") echo "class='active'"; ?>><a href="?page=email">Email</a></li>
    <?php } ?>
    <li role="presentation" <?php if($redirect == "settings") echo "class='active'"; ?>><a href="?page=settings">Settings</a></li>
    <li role="presentation"><a href="?logout=true">Log Out</a></li>
</ul>
