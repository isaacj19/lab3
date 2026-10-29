<?php

// 1. Indexed arrays
$timeSlots = ["Morning", "Afternoon", "Evening"];
echo $timeSlots[0] . "<br>";        // Morning
echo $timeSlots[1] . "<br>";        // Afternoon
echo $timeSlots[2] . "<br>";        // Evening
echo '<br>';

// 2. Associative arrays
$request = [
    "course" => "IS 6465",
    "topic" => "PHP arrays",
    "status" => "Pending review"
];
echo $request["topic"];    // PHP arrays
echo '<br><br>';

// 3. Multidimensional arrays
$requests = [
    ["student" => "Amina", "course" => "IS 6465", "status" => "Pending review"],
    ["student" => "Diego", "course" => "IS 6495", "status" => "Matched"]
];
print_r($requests[0]);

echo '<br><br>';

// 4. Foreach loop rendering select options
$courses = ["IS 6465", "IS 6495", "IS 6570"];

foreach ($courses as $course) {
    $cleanCourse = htmlspecialchars($course, ENT_QUOTES, "UTF-8");
    echo "<option value='{$cleanCourse}'>{$cleanCourse}</option><br>";
}

?>