<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <h1>
        Index
    </h1>
    
    <p>
<?php 
        foreach ($products as $product) {
?>
            <p>
                <a href="product/{{ $product->id }}">
                    {{ $product->name }}
                </a>
            </p>          
<?php
            }
?>
    </p>

</body>
</html>