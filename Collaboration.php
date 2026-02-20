<?php
$topics = [
    'Ancient Egypt and Modern Germany',
    'Cultural Exchange Programs',
    'Common Historical Interests'
];

$selectedTopic = $topics[0];
$studentOne = 'alaa';
$studentTwo = 'magda';
$codeSnippet = 'basmala';
$message = 'welcome';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedTopic = $_POST['topic'] ?? $topics[0];
    $studentOne = $_POST['student_one'] ?? '';
    $studentTwo = $_POST['student_two'] ?? '';
    $codeSnippet = $_POST['code_snippet'] ?? '';

    if (!empty($studentOne) && !empty($studentTwo) && !empty($codeSnippet)) {
        $message = '<div style="background:#e0ffe0;padding:10px;margin:10px 0;">✅ Status: Active Collaboration</div>';
    } else {
        $message = '<div style="background:#ffe0e0;padding:10px;margin:10px 0;">⚠️ Error: Missing fields</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Collaborative Coding Interface</title>
    <style>
        body { font-family: monospace; max-width: 800px; margin: 20px auto; padding: 0 20px; background: #f4f4f4; }
        .container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; font-family: monospace; }
        button { background: #007acc; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px; font-size: 16px; }
        button:hover { background: #005a9e; }
        .output { margin-top: 20px; }
        hr { margin: 25px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌐 Collaborative Coding Interface</h1>
        <p>Two students, one code.</p>

        <form method="post">
            <label for="topic">📌 Select Topic:</label>
            <select name="topic" id="topic">
                <option value="Ancient Egypt and Modern Germany">Ancient Egypt and Modern Germany</option>
                <option value="Cultural Exchange Programs">Cultural Exchange Programs</option>
                <option value="Common Historical Interests">Common Historical Interests</option>
            </select>

            <label for="student_one">👤 Student A (Identifier):</label>
            <input type="text" name="student_one" id="student_one" placeholder="e.g., Student_A" required>

            <label for="student_two">👤 Student B (Identifier):</label>
            <input type="text" name="student_two" id="student_two" placeholder="e.g., Student_B" required>

            <label for="code_snippet">💻 Shared Code:</label>
            <textarea name="code_snippet" id="code_snippet" rows="6" placeholder="Write PHP code here..." required>&lt;?php
function sum($a, $b) {
    return $a + $b;
}
echo sum(5, 3);
?&gt;</textarea>

            <button type="submit">▶ Start Collaboration</button>
        </form>

        <?php if ($message) echo $message; ?>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($studentOne) && !empty($studentTwo) && !empty($codeSnippet)): ?>
        <hr>
        <div class="output">
            <h3>📤 Submitted Data:</h3>
            <p><strong>Topic:</strong> <?= htmlspecialchars($selectedTopic) ?></p>
            <p><strong>Student A:</strong> <?= htmlspecialchars($studentOne) ?></p>
            <p><strong>Student B:</strong> <?= htmlspecialchars($studentTwo) ?></p>
            <p><strong>Code:</strong></p>
            <pre style="background:#f0f0f0; padding:10px; border-radius:4px; overflow-x:auto;"><?= htmlspecialchars($codeSnippet) ?></pre>
            <h4>⚙️ Execution Result:</h4>
            <?php
            $tempFile = tempnam(sys_get_temp_dir(), 'code_') . '.php';
            file_put_contents($tempFile, $codeSnippet);
            ob_start();
            try {
                include $tempFile;
                $executionResult = ob_get_clean();
                echo '<pre style="background:#1e1e1e; color:#d4d4d4; padding:10px; border-radius:4px;">' . htmlspecialchars($executionResult) . '</pre>';
            } catch (Throwable $e) {
                ob_end_clean();
                echo '<pre style="background:#ffe0e0; color:#c00; padding:10px;">Error: ' . htmlspecialchars($e->getMessage()) . '</pre>';
            }
            unlink($tempFile);
            ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>