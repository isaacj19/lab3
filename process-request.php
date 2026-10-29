<?php

// 1. Confirm POST request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed. Please submit the form properly.");
}

// 2. Retrieve submitted values safely using null-coalescing defaults
$course = trim($_POST["course"] ?? "");
$topic = trim($_POST["topic"] ?? "");
$preferredDate = trim($_POST["preferreddate"] ?? "");
$preferredTime = trim($_POST["preferredtime"] ?? "");

// 3. Initialize errors array and allowed option arrays
$errors = [];
$allowedCourses = ["IS 6465", "IS 6495", "IS 6570"];
$allowedTimes = ["Morning", "Afternoon", "Evening"];

// 4. Server-Side Validation logic
if (!in_array($course, $allowedCourses, true)) {
    $errors["course"] = "Select a valid course.";
}

if (!in_array($preferredTime, $allowedTimes, true)) {
    $errors["preferredtime"] = "Select a valid preferred time.";
}

if ($topic === "" || mb_strlen($topic) > 120) {
    $errors["topic"] = "Enter a topic between 1 and 120 characters.";
}

// Date validation: must match Y-m-d format and not be in the past
$dateObj = DateTime::createFromFormat("Y-m-d", $preferredDate);
$today = new DateTime("today");

if (!$dateObj || $dateObj->format("Y-m-d") !== $preferredDate) {
    $errors["preferreddate"] = "Enter a valid preferred date.";
} elseif ($dateObj < $today) {
    $errors["preferreddate"] = "Preferred date cannot be in the past.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@latest/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="container py-5">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <h2>Validation Errors</h2>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="request-form.html" class="btn btn-secondary">Return to Form</a></p>
            </div>
        <?php else: ?>
            <h1>Request received</h1>
            <p><strong>Course:</strong> <?php echo htmlspecialchars($course, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Topic:</strong> <?php echo htmlspecialchars($topic, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Preferred Date:</strong> <?php echo htmlspecialchars($preferredDate, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Preferred Time:</strong> <?php echo htmlspecialchars($preferredTime, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Status:</strong> Pending review</p>
        <?php endif; ?>
    </main>
</body>
</html>