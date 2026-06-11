<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // 1. Leta taarifa za bidhaa ili tujue bei na faida
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product && $product['stock'] >= $quantity) {
        // 2. Piga hesabu ya Faida (Bei ya kuuzia - bei ya kununulia) * idadi
        $faida_kwa_kitu = $product['bei_ya_kuuzia'] - $product['bei_ya_kununulia'];
        $jumla_ya_faida = $faida_kwa_kitu * $quantity;
        $jumla_ya_mauzo = $product['bei_ya_kuuzia'] * $quantity;

        // 3. Punguza mzigo stoo (UPDATE query)
        $update_stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $update_stmt->bind_param("ii", $quantity, $product_id);
       
        if ($update_stmt->execute()) {
            // Simulation imekamilika kwa usahihi (Accuracy)
            echo "<div style='font-family:Arial; margin:5px; padding:20px; background:#d4edda; border:1px solid #c3e6cb; color:#155724; border-radius:5px;'>";
            echo "<h3>Transaction Successful! (Kama Sekunde 30 za McDonald's)</h3>";
            echo "<p>Bidhaa: <strong>{$product['jina_la_bidhaa']}</strong></p>";
            echo "<p>Idadi Iliyouzwa: <strong>{$quantity}</strong></p>";
            echo "<p>Jumla ya Pesa Zilizopokelewa: <strong>Tsh " . number_format($jumla_ya_mauzo) . "</strong></p>";
            echo "<p>Faida Iliyoingia Kwenye Mfumo: <strong style='color:blue;'>Tsh " . number_format($jumla_ya_faida) . "</strong></p>";
            echo "<br><a href='index.php' style='background:#333; color:white; padding:8px 15px; text-decoration:none; border-radius:3px;'>Rudi Kwenye Stoo</a>";
            echo "</div>";
        }
    } else {
        echo "Mzigo hautoshi stoo au bidhaa haipo!";
        echo "<br><a href='index.php'>Rudi</a>";
    }
}
?>