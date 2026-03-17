<?php
// Simple image upload for member photos. Saves to assets/img/{slug}.{ext}
$members = ['Nayeon','Jeongyeon','Momo','Sana','Jihyo','Mina','Dahyun','Chaeyoung','Tzuyu'];
function slugify($s){return preg_replace('/[^a-z0-9]+/i','-',trim(strtolower($s)));
}
$messages = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $targetDir = __DIR__ . '/assets/img/';
    foreach($members as $name){
        $key = 'file_' . slugify($name);
        if(!isset($_FILES[$key]) || $_FILES[$key]['error'] === UPLOAD_ERR_NO_FILE) continue;
        $f = $_FILES[$key];
        if($f['error'] !== UPLOAD_ERR_OK){ $messages[] = "$name: upload error code " . $f['error']; continue; }
        // basic validation
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif','image/svg+xml'=>'svg+xml'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);
        if(!array_key_exists($mime, $allowed)) { $messages[] = "$name: unsupported file type ($mime)"; continue; }
        $ext = $allowed[$mime];
        // for svg mime may be 'image/svg+xml' -> ext 'svg+xml' above; normalize
        if(strpos($ext,'svg') !== false) $ext = 'svg';
        $slug = slugify($name);
        $dest = $targetDir . $slug . '.' . $ext;
        if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
        if(move_uploaded_file($f['tmp_name'],$dest)){
            $messages[] = "$name: uploaded successfully.";
        } else {
            $messages[] = "$name: failed to move uploaded file.";
        }
    }
}
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Upload member photos</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>body{padding:28px} form{display:grid;gap:12px;max-width:760px}</style>
</head>
<body>
  <h1>Upload TWICE member photos</h1>
  <p>Choose image files to upload for members. Allowed types: JPG, PNG, WebP, GIF, SVG. Files will be saved to <code>assets/img/</code> with filenames like <code>nayeon.jpg</code>.</p>
  <?php if($messages): ?>
    <ul>
    <?php foreach($messages as $m): ?>
      <li><?=htmlspecialchars($m)?></li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <?php foreach($members as $name): $slug = slugify($name); ?>
      <label style="display:block">
        <?=htmlspecialchars($name)?>
        <input type="file" name="file_<?=htmlspecialchars($slug)?>" accept="image/*">
      </label>
    <?php endforeach; ?>
    <div>
      <button type="submit" style="padding:10px 14px;border-radius:8px;background:#ff6fa3;color:#fff;border:0">Upload</button>
      <a href="index.php" style="margin-left:12px">Back to site</a>
    </div>
  </form>
</body>
</html>