<?php
require_once 'config/config.php';
require_once 'classes/AIWrapper.php';
$recipe = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ingredients'])) {
try {
$ingredients = explode(',', $_POST['ingredients']);
$ingredients = array_map('trim', $ingredients);
$wrapper = new AIWrapper(API_KEY);
$recipe = $wrapper->generateRecipe($ingredients);
} catch (Exception $e) {
$error = "Error: " . $e->getMessage();
}
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>AI Recept Generator</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h1>AI Recept Generator</h1>
<?php if ($error): ?>
<div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<form method="post">
<label for="ingredients">Ingrediënten (gescheiden door komma's):</label>
<textarea id="ingredients" name="ingredients" rows="3" required><?php
echo isset($_POST['ingredients']) ? htmlspecialchars($_POST['ingredients']) : '';
?></textarea>
<button type="submit">Genereer Recept</button>
</form>
<?php if ($recipe): ?>
<div class="recipe">
<h2>Gegenereerd Recept</h2>
<pre><?php echo htmlspecialchars($recipe); ?></pre>
</div>
<?php endif; ?>
</div>
</body>
</html>