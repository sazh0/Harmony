<?php
// schedule_data.php

header('Content-Type: application/json');

$filename = '../txt/projects.txt';

if (!file_exists($filename)) {
    echo json_encode([]);
    exit;
}

$content = file_get_contents($filename);

// Split the file into project blocks using the separator line.
$blocks = explode("---------------------------------", $content);

$projects = [];

foreach ($blocks as $block) {
    $block = trim($block);
    if (empty($block)) {
        continue;
    }
    
    $lines = explode("\n", $block);
    $project = [];
    $pages = [];
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (stripos($line, "Project Title:") === 0) {
            $project['title'] = trim(substr($line, strlen("Project Title:")));
        } 
        // You can parse additional project fields if needed.
        else if (stripos($line, "Pages & Components:") === 0) {
            // Section header – skip it.
            continue;
        } 
        else if (strpos($line, "-") === 0) {
            // This is a page line, e.g.: "- a: Header, Logo, Footer, ..."
            $line = ltrim($line, "- "); // remove leading "- " 
            $parts = explode(":", $line, 2);
            if (count($parts) == 2) {
                $pageName = trim($parts[0]);
                $components = trim($parts[1]);
                $pages[] = [
                    "page" => $pageName,
                    "components" => $components
                ];
            }
        }
    }
    if (!empty($project)) {
        $project['pages'] = $pages;
        $projects[] = $project;
    }
}

echo json_encode($projects);
?>