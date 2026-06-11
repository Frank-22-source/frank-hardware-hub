<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Frank Hardware Hub - Simulation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #333; color: white; }
        .alert { background-color: #ffcccc; color: #cc0000; font-weight: bold; padding: 5px; border-radius: 4px; }
        .safe { background-color: #d4edda; color: #155724; padding: 5px; border-radius: 4px; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</</head>
<body>

<div class="box">
    <h2>Frank Hardware Hub — POS System Simulation</h2>
    <p>Hali ya Stoo ya Kidijitali (Kasi na Udhibiti):</p>
   
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Jina la Bidhaa</th>
                <th>Idadi Iliyopo (Stock)</th>
                <th>Bei ya Kuuzia (Tsh)</th>
                <th>Hali ya Bidhaa (Alert)</th>
                <th>Simulate Mauzo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM products";
            $result = $conn->query($query);
           
            while($row = $result->fetch_assoc()) {
                // Testing kama stock imeshuka chini ya reorder level
                if ($row['stock'] <= $row['reorder_level']) {
                    $status = "<span class='alert'>AGIZA MZIGO MPYA! (Stock Iko Chini)</span>";
                } else {
                    $status = "<span class='safe'>Mzigo Upo wa Kutosha</span>";
                }
               
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['jina_la_bidhaa']}</td>
                        <td><strong>{$row['stock']}</strong></td>
                        <td>" . number_format($row['bei_ya_kuuzia']) . "</td>
                        <td>{$status}</td>
                        <td>
                            <form action='sell.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='product_id' value='{$row['id']}'>
                                <input type='number' name='quantity' min='1' max='{$row['stock']}' placeholder='Idadi' required style='width:60px;'>
                                <button type='submit' style='background:#28a745; color:white; border:none; padding:5px 10px; cursor:pointer;'>Uza</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>