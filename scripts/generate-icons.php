<?php

$src = __DIR__.'/../public/images/logo.png';
if (! file_exists($src)) {
    exit("Logo not found\n");
}

$data = file_get_contents($src);
$img = @imagecreatefromstring($data);
if ($img === false) {
    $img = @imagecreatefromjpeg($src);
}
if ($img === false) {
    exit("Could not load image\n");
}
$w = imagesx($img);
$h = imagesy($img);
$black = imagecolorallocate($img, 15, 23, 42);

// Favicon 32x32 — LR monogram (top ~45%)
$cropH = (int) ($h * 0.42);
$cropSize = min($w, $cropH);
$cx = (int) (($w - $cropSize) / 2);

$fav = imagecreatetruecolor(32, 32);
imagealphablending($fav, false);
imagesavealpha($fav, true);
$trans = imagecolorallocatealpha($fav, 0, 0, 0, 127);
imagefill($fav, 0, 0, $trans);
imagecopyresampled($fav, $img, 0, 0, $cx, 0, 32, 32, $cropSize, $cropH);
imagepng($fav, __DIR__.'/../public/favicon-32x32.png');
imagepng($fav, __DIR__.'/../public/favicon.png');

// Apple touch 180
$at = imagecreatetruecolor(180, 180);
$bg = imagecolorallocate($at, 15, 23, 42);
imagefill($at, 0, 0, $bg);
$lw = 150;
$lh = (int) ($h * $lw / $w);
$logo = imagecreatetruecolor($lw, $lh);
imagecopyresampled($logo, $img, 0, 0, 0, 0, $lw, $lh, $w, $h);
imagecopy($at, $logo, (int) ((180 - $lw) / 2), (int) ((180 - $lh) / 2), 0, 0, $lw, $lh);
imagepng($at, __DIR__.'/../public/apple-touch-icon.png');

// OG image 1200x630
$og = imagecreatetruecolor(1200, 630);
imagefill($og, 0, 0, $bg);
$logoW = 420;
$logoH = (int) ($h * $logoW / $w);
$logoOg = imagecreatetruecolor($logoW, $logoH);
imagecopyresampled($logoOg, $img, 0, 0, 0, 0, $logoW, $logoH, $w, $h);
imagecopy($og, $logoOg, (int) ((1200 - $logoW) / 2), (int) ((630 - $logoH) / 2), 0, 0, $logoW, $logoH);
imagepng($og, __DIR__.'/../public/images/og-image.png', 9);

// PWA icons
foreach ([192, 512] as $s) {
    $icon = imagecreatetruecolor($s, $s);
    imagefill($icon, 0, 0, $bg);
    $lw = (int) ($s * 0.82);
    $lh = (int) ($h * $lw / $w);
    $l = imagecreatetruecolor($lw, $lh);
    imagecopyresampled($l, $img, 0, 0, 0, 0, $lw, $lh, $w, $h);
    imagecopy($icon, $l, (int) (($s - $lw) / 2), (int) (($s - $lh) / 2), 0, 0, $lw, $lh);
    imagepng($icon, __DIR__."/../public/images/icon-{$s}.png");
}

// favicon.ico (16+32 combined simple - just copy 32 as ico alternative)
copy(__DIR__.'/../public/favicon-32x32.png', __DIR__.'/../public/favicon.ico');

echo "Icons generated successfully.\n";
