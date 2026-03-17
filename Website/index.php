<?php
$raw = ['Nayeon','Jeongyeon','Momo','Sana','Jihyo','Mina','Dahyun','Chaeyoung','Tzuyu'];

function slugify($s){
  $s = preg_replace('/[^a-z0-9]+/i','-',trim(strtolower($s)));
  return trim($s,'-');
}

function find_local_image($name){
  $base = __DIR__ . '/assets/img/';
  $slug = slugify($name);
  $exts = ['jpg','jpeg','png','webp','gif','svg'];
  foreach($exts as $e){
    $path = $base . $slug . '.' . $e;
    if(file_exists($path)){
      return 'assets/img/' . $slug . '.' . $e;
    }
  }
  return null;
}

$members = array_map(function($name){
  $local = find_local_image($name);
  if($local) return ['name'=>$name,'img'=>$local];
  $seed = rawurlencode($name);
  $img = "https://ui-avatars.com/api/?name={$seed}&background=FFE6F2&color=FF6FA3&rounded=true&format=svg";
  return ['name'=>$name, 'img'=>$img];
}, $raw);
$hour = (int)date('G');
if ($hour < 12) $greeting = 'Good morning, ONCE!';
elseif ($hour < 18) $greeting = 'Good afternoon, ONCE!';
else $greeting = 'Good evening, ONCE!';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>TWICE — Fan Tribute</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Sacramento&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="stage">
    <header class="hero">
      <div class="hero-inner">
        <h1 class="title">TWICE — Fan Tribute</h1>
        <p class="subtitle"><?=htmlspecialchars($greeting)?></p>
        <p class="tag">A simple animated theme for ONCE</p>
      </div>
      <div class="glow"></div>
      <div class="sparkles" aria-hidden="true"></div>
    </header>

    <main>
      <section class="members">
        <?php foreach($members as $m): ?>
        <article class="card">
          <div class="avatar" aria-hidden="true">
            <?php if(!empty($m['img'])): ?>
              <img src="<?=htmlspecialchars($m['img'])?>" alt="<?=htmlspecialchars($m['name'])?> avatar" loading="lazy" decoding="async">
            <?php else: ?>
              <span><?=htmlspecialchars(substr($m['name'],0,1))?></span>
            <?php endif; ?>
          </div>
          <h3><?=htmlspecialchars($m['name'])?></h3>
          <p class="role">TWICE member</p>
          <button class="cheer" data-name="<?=htmlspecialchars($m['name'])?>">Cheer</button>
        </article>
        <?php endforeach; ?>
      </section>
    </main>

    <footer class="foot">Built with love for ONCE · <?=date('Y')?></footer>
  </div>

  <canvas id="confetti-canvas" aria-hidden="true"></canvas>
  <script src="assets/js/main.js"></script>
</body>
</html>