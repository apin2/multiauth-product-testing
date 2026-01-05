<?php
// Create a simple default product image
$im = imagecreate(300, 300);
$bg = imagecolorallocate($im, 200, 200, 200); // Light gray background
$textcolor = imagecolorallocate($im, 50, 50, 50); // Dark gray text

// Add text to the image
imagestring($im, 5, 90, 140, 'No Image', $textcolor);

// Ensure the directory exists
if (!is_dir('storage/app/public/products')) {
    mkdir('storage/app/public/products', 0755, true);
}

// Save the image
imagepng($im, 'storage/app/public/products/default-product.png');
imagedestroy($im);

echo "Default product image created successfully!";