<?php
header('Content-Type: application/json');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Retrieve and trim project details from POST data
$projectTitle       = isset($_POST['projectTitle']) ? trim($_POST['projectTitle']) : '';
$projectDescription = isset($_POST['projectDescription']) ? trim($_POST['projectDescription']) : '';
$targetAudience     = isset($_POST['targetAudience']) ? trim($_POST['targetAudience']) : '';
$designGoals        = isset($_POST['designGoals']) ? trim($_POST['designGoals']) : '';
$pageComponentsData = isset($_POST['pageComponentsData']) ? trim($_POST['pageComponentsData']) : '';

// Validate required fields
if (empty($projectTitle) || empty($projectDescription) || empty($targetAudience) || empty($designGoals)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required project fields.']);
    exit;
}

// Decode page components JSON data
$pageComponents = json_decode($pageComponentsData, true);

// Build the project details string
$content  = "Project Title: {$projectTitle}\n";
$content .= "Project Description: {$projectDescription}\n";
$content .= "Target Audience: {$targetAudience}\n";
$content .= "Design Goals: {$designGoals}\n";
$content .= "Pages & Components:\n";

if (is_array($pageComponents) && count($pageComponents) > 0) {
    foreach ($pageComponents as $page => $components) {
        $componentsStr = is_array($components) ? implode(", ", $components) : $components;
        $content .= "- {$page}: " . ($componentsStr ? $componentsStr : 'No components added') . "\n";
    }
} else {
    $content .= "No page components data provided.\n";
}

// Append timestamp and separator
$content .= "Submitted on: " . date("Y-m-d H:i:s") . "\n";
$content .= "---------------------------------\n";

// Specify the file to which the project details will be saved
$filename = "../txt/projects.txt";

// Save the content to the file (append mode)
if (file_put_contents($filename, $content, FILE_APPEND | LOCK_EX)) {
    echo json_encode(['status' => 'success', 'message' => 'Project saved successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save project.']);
}
?>